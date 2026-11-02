/** Lightweight validation used only by the fitting-room landmark fitting path. */
export function validateLandmarkGeometry(category, points, bounds) {
    if (!(points instanceof Map) || points.size < 3) {
        return { valid: false, reason: "insufficient-landmark-points" };
    }
    const min = bounds?.min;
    const max = bounds?.max;
    const size = bounds?.size;
    if (![min, max, size].every((value) => Array.isArray(value) && value.length >= 3 && value.slice(0, 3).every(Number.isFinite))) {
        return { valid: false, reason: "invalid-model-bounds" };
    }
    if (size.some((value) => value <= 1e-8)) {
        return { valid: false, reason: "degenerate-model-bounds" };
    }

    const epsilon = Math.max(...size.map(Math.abs)) * 0.025 + 1e-6;
    const normalized = [];
    for (const [name, point] of points.entries()) {
        if (!Array.isArray(point) || point.length < 3 || !point.slice(0, 3).every(Number.isFinite)) {
            return { valid: false, reason: `invalid-landmark-coordinate:${name}` };
        }
        for (let axis = 0; axis < 3; axis += 1) {
            if (point[axis] < min[axis] - epsilon || point[axis] > max[axis] + epsilon) {
                return { valid: false, reason: `landmark-outside-model-bounds:${name}` };
            }
        }
        normalized.push(point.map((value, axis) => (value - min[axis]) / size[axis]));
    }

    // Reject a set whose points collapse to effectively one location. The solver
    // performs its own stronger geometric checks; this catches malformed GLB extras early.
    const first = normalized[0];
    const spread = normalized.reduce((sum, point) => {
        return sum + Math.hypot(point[0] - first[0], point[1] - first[1], point[2] - first[2]);
    }, 0) / normalized.length;
    if (!Number.isFinite(spread) || spread < 1e-4) {
        return { valid: false, reason: "landmarks-have-no-spatial-spread" };
    }

    return { valid: true, category, count: points.size, tolerance: epsilon };
}
