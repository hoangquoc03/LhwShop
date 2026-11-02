/**
 * LHW landmark similarity solver.
 * Fits a uniform scale + quaternion rotation + translation from paired 3D points.
 * No third-party dependencies.
 */

function finitePoint(point) {
    return Array.isArray(point) && point.length >= 3 &&
        point.slice(0, 3).every((value) => Number.isFinite(Number(value)));
}

function mean(points) {
    const result = [0, 0, 0];
    for (const point of points) {
        for (let axis = 0; axis < 3; axis += 1) result[axis] += Number(point[axis]);
    }
    return result.map((value) => value / points.length);
}

function dot(a, b) {
    return a[0] * b[0] + a[1] * b[1] + a[2] * b[2];
}

function norm(value) {
    return Math.sqrt(dot(value, value));
}

function multiplyQuaternionVector(q, v) {
    const [x, y, z, w] = q;
    const tx = 2 * (y * v[2] - z * v[1]);
    const ty = 2 * (z * v[0] - x * v[2]);
    const tz = 2 * (x * v[1] - y * v[0]);
    return [
        v[0] + w * tx + (y * tz - z * ty),
        v[1] + w * ty + (z * tx - x * tz),
        v[2] + w * tz + (x * ty - y * tx),
    ];
}

function largestEigenvectorSymmetric4(matrix) {
    const a = matrix.map((row) => [...row]);
    const v = Array.from({ length: 4 }, (_, row) =>
        Array.from({ length: 4 }, (_, col) => row === col ? 1 : 0),
    );

    for (let iteration = 0; iteration < 80; iteration += 1) {
        let p = 0;
        let q = 1;
        let largest = Math.abs(a[p][q]);
        for (let row = 0; row < 4; row += 1) {
            for (let col = row + 1; col < 4; col += 1) {
                const value = Math.abs(a[row][col]);
                if (value > largest) {
                    largest = value;
                    p = row;
                    q = col;
                }
            }
        }
        if (largest < 1e-13) break;

        const angle = 0.5 * Math.atan2(2 * a[p][q], a[q][q] - a[p][p]);
        const c = Math.cos(angle);
        const s = Math.sin(angle);
        const app = a[p][p];
        const aqq = a[q][q];
        const apq = a[p][q];

        a[p][p] = c * c * app - 2 * s * c * apq + s * s * aqq;
        a[q][q] = s * s * app + 2 * s * c * apq + c * c * aqq;
        a[p][q] = 0;
        a[q][p] = 0;

        for (let k = 0; k < 4; k += 1) {
            if (k !== p && k !== q) {
                const akp = a[k][p];
                const akq = a[k][q];
                a[k][p] = c * akp - s * akq;
                a[p][k] = a[k][p];
                a[k][q] = s * akp + c * akq;
                a[q][k] = a[k][q];
            }
            const vkp = v[k][p];
            const vkq = v[k][q];
            v[k][p] = c * vkp - s * vkq;
            v[k][q] = s * vkp + c * vkq;
        }
    }

    let index = 0;
    for (let i = 1; i < 4; i += 1) {
        if (a[i][i] > a[index][index]) index = i;
    }
    const eigen = v.map((row) => row[index]); // [w, x, y, z]
    const length = Math.hypot(...eigen);
    if (!Number.isFinite(length) || length < 1e-12) return null;
    const normalized = eigen.map((value) => value / length);
    // Canonical sign makes diagnostics deterministic.
    return normalized[0] < 0 ? normalized.map((value) => -value) : normalized;
}

/**
 * @param {number[][]} sourcePoints Source coordinates.
 * @param {number[][]} targetPoints Corresponding target coordinates.
 * @param {{minimumScale?:number, maximumScale?:number, maximumRmsError?:number}} validation
 * @returns {{ok:boolean, reason?:string, scale?:number, rotation?:number[], translation?:number[], rmsError?:number, errors?:number[]}}
 */
export function solveLandmarkSimilarity(sourcePoints, targetPoints, validation = {}) {
    if (!Array.isArray(sourcePoints) || !Array.isArray(targetPoints) || sourcePoints.length !== targetPoints.length) {
        return { ok: false, reason: "landmark-pair-count-mismatch" };
    }
    if (sourcePoints.length < 3) return { ok: false, reason: "at-least-three-landmark-pairs-required" };
    if (!sourcePoints.every(finitePoint) || !targetPoints.every(finitePoint)) {
        return { ok: false, reason: "landmark-coordinates-must-be-finite-xyz" };
    }

    const sourceCenter = mean(sourcePoints);
    const targetCenter = mean(targetPoints);
    const p = sourcePoints.map((point) => point.slice(0, 3).map((n, i) => Number(n) - sourceCenter[i]));
    const q = targetPoints.map((point) => point.slice(0, 3).map((n, i) => Number(n) - targetCenter[i]));

    let sourceEnergy = 0;
    const s = Array.from({ length: 3 }, () => [0, 0, 0]);
    for (let i = 0; i < p.length; i += 1) {
        sourceEnergy += dot(p[i], p[i]);
        // Cross covariance S = sum(source * target^T).
        for (let r = 0; r < 3; r += 1) {
            for (let c = 0; c < 3; c += 1) s[r][c] += p[i][r] * q[i][c];
        }
    }
    if (!Number.isFinite(sourceEnergy) || sourceEnergy < 1e-12) {
        return { ok: false, reason: "source-landmarks-are-degenerate" };
    }

    const [sxx, sxy, sxz] = s[0];
    const [syx, syy, syz] = s[1];
    const [szx, szy, szz] = s[2];
    const trace = sxx + syy + szz;
    const n = [
        [trace, syz - szy, szx - sxz, sxy - syx],
        [syz - szy, sxx - syy - szz, sxy + syx, szx + sxz],
        [szx - sxz, sxy + syx, -sxx + syy - szz, syz + szy],
        [sxy - syx, szx + sxz, syz + szy, -sxx - syy + szz],
    ];
    const eigen = largestEigenvectorSymmetric4(n);
    if (!eigen) return { ok: false, reason: "rotation-solver-failed" };
    const rotation = [eigen[1], eigen[2], eigen[3], eigen[0]]; // Three.js [x,y,z,w]

    let numerator = 0;
    for (let i = 0; i < p.length; i += 1) {
        numerator += dot(q[i], multiplyQuaternionVector(rotation, p[i]));
    }
    const scale = numerator / sourceEnergy;
    const minimumScale = Number.isFinite(validation.minimumScale) ? validation.minimumScale : 0;
    const maximumScale = Number.isFinite(validation.maximumScale) ? validation.maximumScale : Infinity;
    if (!Number.isFinite(scale) || scale <= 0) return { ok: false, reason: "non-positive-or-invalid-scale" };
    if (scale < minimumScale || scale > maximumScale) {
        return { ok: false, reason: `scale-out-of-range:${scale}`, scale };
    }

    const rotatedCenter = multiplyQuaternionVector(rotation, sourceCenter);
    const translation = targetCenter.map((value, axis) => value - scale * rotatedCenter[axis]);
    const errors = sourcePoints.map((point, index) => {
        const rotated = multiplyQuaternionVector(rotation, point.slice(0, 3));
        const predicted = rotated.map((value, axis) => scale * value + translation[axis]);
        const delta = predicted.map((value, axis) => value - Number(targetPoints[index][axis]));
        return norm(delta);
    });
    const rmsError = Math.sqrt(errors.reduce((sum, value) => sum + value * value, 0) / errors.length);
    const maximumRmsError = Number.isFinite(validation.maximumRmsError) ? validation.maximumRmsError : Infinity;
    if (!Number.isFinite(rmsError) || rmsError > maximumRmsError) {
        return { ok: false, reason: `rms-error-exceeds-limit:${rmsError}`, scale, rotation, translation, rmsError, errors };
    }

    return { ok: true, scale, rotation, translation, rmsError, errors };
}

/**
 * Select landmark fit when valid; otherwise use the supplied legacy fallback.
 */
export function selectLandmarkFit(result, fallback) {
    if (result?.ok === true && result.report) {
        return { method: "landmarks", report: result.report, reason: null };
    }
    if (typeof fallback !== "function") {
        throw new TypeError("Landmark fit is invalid and no fallback function was provided.");
    }
    return {
        method: "legacy-bounds",
        report: fallback(),
        reason: result?.reason || "landmark-fit-unavailable",
    };
}
