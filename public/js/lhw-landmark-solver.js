const DEFAULT_VALIDATION = {
    minimumScale: 0.02,
    maximumScale: 50,
    maximumRmsError: Infinity,
};

function subtract(left, right) {
    return left.map((value, index) => value - right[index]);
}

function dot(left, right) {
    return left.reduce((sum, value, index) => sum + value * right[index], 0);
}

function cross(left, right) {
    return [
        left[1] * right[2] - left[2] * right[1],
        left[2] * right[0] - left[0] * right[2],
        left[0] * right[1] - left[1] * right[0],
    ];
}

function rotateByQuaternion(point, [x, y, z, w]) {
    const vector = [x, y, z];
    const twiceCross = cross(vector, point).map((value) => value * 2);
    const crossTwiceCross = cross(vector, twiceCross);
    return point.map(
        (value, index) =>
            value + w * twiceCross[index] + crossTwiceCross[index],
    );
}

function analyzePointSpread(points) {
    const center = [0, 1, 2].map(
        (axis) =>
            points.reduce((sum, point) => sum + point[axis], 0) / points.length,
    );
    const centered = points.map((point) => subtract(point, center));
    let variance = 0;
    let maximumDistance = 0;
    let minimumPairDistance = Infinity;
    let maximumArea = 0;

    for (let index = 0; index < centered.length; index += 1) {
        variance += dot(centered[index], centered[index]);
        for (let other = index + 1; other < centered.length; other += 1) {
            const difference = subtract(centered[index], centered[other]);
            const distance = Math.sqrt(dot(difference, difference));
            maximumDistance = Math.max(maximumDistance, distance);
            minimumPairDistance = Math.min(minimumPairDistance, distance);
            maximumArea = Math.max(
                maximumArea,
                Math.sqrt(
                    dot(
                        cross(centered[index], centered[other]),
                        cross(centered[index], centered[other]),
                    ),
                ),
            );
        }
    }

    if (maximumDistance <= 1e-8) {
        return { ok: false, reason: "duplicate-landmarks" };
    }
    if (minimumPairDistance <= maximumDistance * 1e-8) {
        return { ok: false, reason: "duplicate-landmarks" };
    }
    if (variance <= 1e-12 || maximumArea <= maximumDistance ** 2 * 1e-8) {
        return { ok: false, reason: "degenerate-landmark-layout" };
    }

    return { ok: true, center, centered, variance };
}

function largestEigenvectorSymmetric4(matrix) {
    const values = matrix.map((row) => [...row]);
    const vectors = Array.from({ length: 4 }, (_, row) =>
        Array.from({ length: 4 }, (_, column) => (row === column ? 1 : 0)),
    );

    for (let iteration = 0; iteration < 64; iteration += 1) {
        let p = 0;
        let q = 1;
        let largest = Math.abs(values[p][q]);
        for (let row = 0; row < 4; row += 1) {
            for (let column = row + 1; column < 4; column += 1) {
                if (Math.abs(values[row][column]) > largest) {
                    p = row;
                    q = column;
                    largest = Math.abs(values[row][column]);
                }
            }
        }
        if (largest < 1e-12) break;

        const angle =
            0.5 * Math.atan2(2 * values[p][q], values[q][q] - values[p][p]);
        const cosine = Math.cos(angle);
        const sine = Math.sin(angle);
        const app = values[p][p];
        const aqq = values[q][q];
        const apq = values[p][q];
        values[p][p] =
            cosine * cosine * app - 2 * sine * cosine * apq + sine * sine * aqq;
        values[q][q] =
            sine * sine * app + 2 * sine * cosine * apq + cosine * cosine * aqq;
        values[p][q] = 0;
        values[q][p] = 0;

        for (let index = 0; index < 4; index += 1) {
            if (index !== p && index !== q) {
                const aip = values[index][p];
                const aiq = values[index][q];
                values[index][p] = cosine * aip - sine * aiq;
                values[p][index] = values[index][p];
                values[index][q] = sine * aip + cosine * aiq;
                values[q][index] = values[index][q];
            }
            const vip = vectors[index][p];
            const viq = vectors[index][q];
            vectors[index][p] = cosine * vip - sine * viq;
            vectors[index][q] = sine * vip + cosine * viq;
        }
    }

    let largestIndex = 0;
    for (let index = 1; index < 4; index += 1) {
        if (values[index][index] > values[largestIndex][largestIndex]) {
            largestIndex = index;
        }
    }
    return vectors.map((row) => row[largestIndex]);
}

export function solveLandmarkSimilarity(
    sourcePoints,
    targetPoints,
    validation = {},
) {
    if (
        !Array.isArray(sourcePoints) ||
        !Array.isArray(targetPoints) ||
        sourcePoints.length !== targetPoints.length ||
        sourcePoints.length < 3
    ) {
        return { ok: false, reason: "insufficient-landmark-pairs" };
    }
    if (
        [...sourcePoints, ...targetPoints].some(
            (point) =>
                !Array.isArray(point) ||
                point.length !== 3 ||
                !point.every(Number.isFinite),
        )
    ) {
        return { ok: false, reason: "invalid-landmark-coordinates" };
    }

    const sourceSpread = analyzePointSpread(sourcePoints);
    if (!sourceSpread.ok) return sourceSpread;
    const targetSpread = analyzePointSpread(targetPoints);
    if (!targetSpread.ok) {
        return { ok: false, reason: `target-${targetSpread.reason}` };
    }

    const covariance = Array.from({ length: 3 }, () => [0, 0, 0]);
    for (let index = 0; index < sourcePoints.length; index += 1) {
        const source = sourceSpread.centered[index];
        const target = targetSpread.centered[index];
        for (let row = 0; row < 3; row += 1) {
            for (let column = 0; column < 3; column += 1) {
                covariance[row][column] += source[row] * target[column];
            }
        }
    }

    const [[sxx, sxy, sxz], [syx, syy, syz], [szx, szy, szz]] = covariance;
    const eigenvector = largestEigenvectorSymmetric4([
        [sxx + syy + szz, syz - szy, szx - sxz, sxy - syx],
        [syz - szy, sxx - syy - szz, sxy + syx, szx + sxz],
        [szx - sxz, sxy + syx, -sxx + syy - szz, syz + szy],
        [sxy - syx, szx + sxz, syz + szy, -sxx - syy + szz],
    ]);
    const norm = Math.hypot(...eigenvector);
    if (!Number.isFinite(norm) || norm <= 1e-12) {
        return { ok: false, reason: "invalid-similarity-rotation" };
    }
    const rotation = [
        eigenvector[1] / norm,
        eigenvector[2] / norm,
        eigenvector[3] / norm,
        eigenvector[0] / norm,
    ];
    const scaleNumerator = sourcePoints.reduce((sum, _point, index) => {
        return (
            sum +
            dot(
                targetSpread.centered[index],
                rotateByQuaternion(sourceSpread.centered[index], rotation),
            )
        );
    }, 0);
    const scale = scaleNumerator / sourceSpread.variance;
    const limits = { ...DEFAULT_VALIDATION, ...validation };

    if (
        !Number.isFinite(scale) ||
        !Number.isFinite(limits.minimumScale) ||
        !Number.isFinite(limits.maximumScale) ||
        Number.isNaN(limits.maximumRmsError) ||
        limits.minimumScale <= 0 ||
        limits.maximumScale < limits.minimumScale ||
        limits.maximumRmsError <= 0
    ) {
        return { ok: false, reason: "invalid-similarity-scale-or-validation" };
    }
    if (scale <= 0) {
        return { ok: false, reason: "invalid-similarity-scale" };
    }
    if (scale < limits.minimumScale || scale > limits.maximumScale) {
        return { ok: false, reason: "similarity-scale-out-of-range" };
    }

    const translation = subtract(
        targetSpread.center,
        rotateByQuaternion(sourceSpread.center, rotation).map(
            (value) => value * scale,
        ),
    );
    const errors = sourcePoints.map((point, index) => {
        const transformed = rotateByQuaternion(
            subtract(point, sourceSpread.center),
            rotation,
        ).map((value) => value * scale);
        return Math.sqrt(
            dot(
                subtract(
                    transformed.map(
                        (value, axis) => value + targetSpread.center[axis],
                    ),
                    targetPoints[index],
                ),
                subtract(
                    transformed.map(
                        (value, axis) => value + targetSpread.center[axis],
                    ),
                    targetPoints[index],
                ),
            ),
        );
    });
    const rmsError = Math.sqrt(
        errors.reduce((sum, error) => sum + error * error, 0) / errors.length,
    );

    if (!Number.isFinite(rmsError)) {
        return { ok: false, reason: "invalid-landmark-residual" };
    }
    if (rmsError > limits.maximumRmsError) {
        return {
            ok: false,
            reason: "landmark-residual-exceeds-tolerance",
            scale,
            rotation,
            translation,
            errors,
            rmsError,
        };
    }

    return {
        ok: true,
        rotation,
        scale,
        translation,
        errors,
        rmsError,
    };
}

export function transformLandmark(point, fit) {
    return rotateByQuaternion(point, fit.rotation).map(
        (value, axis) => value * fit.scale + fit.translation[axis],
    );
}

export function selectLandmarkFit(result, fallbackFactory) {
    if (result?.ok) {
        return { method: "landmarks", report: result.report };
    }

    return {
        method: "legacy-bounds",
        reason: result?.reason || "landmarks-unavailable",
        report: fallbackFactory(),
    };
}
