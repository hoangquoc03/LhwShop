import assert from "node:assert/strict";
import test from "node:test";
import {
    selectLandmarkFit,
    solveLandmarkSimilarity,
    transformLandmark,
} from "../../public/js/lhw-landmark-solver.js";

const source = [
    [0, 0, 0],
    [1, 0, 0],
    [0, 1, 0],
    [0, 0, 1],
    [1, 1, 1],
];

function transformed(points, rotation, scale, translation) {
    const [x, y, z, w] = rotation;
    return points.map(([px, py, pz]) => {
        const tx = 2 * (y * pz - z * py);
        const ty = 2 * (z * px - x * pz);
        const tz = 2 * (x * py - y * px);
        const rx = px + w * tx + y * tz - z * ty;
        const ry = py + w * ty + z * tx - x * tz;
        const rz = pz + w * tz + x * ty - y * tx;
        return [
            rx * scale + translation[0],
            ry * scale + translation[1],
            rz * scale + translation[2],
        ];
    });
}

function assertPointsClose(actual, expected, tolerance = 1e-8) {
    assert.equal(actual.length, expected.length);
    for (let index = 0; index < actual.length; index += 1) {
        for (let axis = 0; axis < 3; axis += 1) {
            assert.ok(
                Math.abs(actual[index][axis] - expected[index][axis]) <=
                    tolerance,
                `point ${index}, axis ${axis}: ${actual[index][axis]} != ${expected[index][axis]}`,
            );
        }
    }
}

test("solves identity transform", () => {
    const result = solveLandmarkSimilarity(source, source);

    assert.equal(result.ok, true);
    assert.ok(result.rmsError < 1e-10);
    assertPointsClose(
        source.map((point) => transformLandmark(point, result)),
        source,
    );
});

test("solves 90 degree rotation", () => {
    const expected = transformed(
        source,
        [0, 0, Math.SQRT1_2, Math.SQRT1_2],
        1,
        [0, 0, 0],
    );
    const result = solveLandmarkSimilarity(source, expected);

    assert.equal(result.ok, true);
    assertPointsClose(
        source.map((point) => transformLandmark(point, result)),
        expected,
    );
});

test("solves uniform scale and translation", () => {
    const expected = transformed(source, [0, 0, 0, 1], 2.5, [3, -4, 5]);
    const result = solveLandmarkSimilarity(source, expected);

    assert.equal(result.ok, true);
    assert.ok(Math.abs(result.scale - 2.5) < 1e-10);
    assert.deepEqual(
        result.translation.map((value) => Number(value.toFixed(8))),
        [3, -4, 5],
    );
    assertPointsClose(
        source.map((point) => transformLandmark(point, result)),
        expected,
    );
});

test("accepts small landmark noise within the RMS threshold", () => {
    const exact = transformed(source, [0, 0, 0, 1], 1.4, [0.4, -0.2, 0.8]);
    const noisy = exact.map((point, index) => [
        point[0] + (index % 2 ? 0.0004 : -0.0003),
        point[1] + (index % 3 ? -0.0002 : 0.0003),
        point[2] + (index % 2 ? 0.0001 : -0.0002),
    ]);
    const result = solveLandmarkSimilarity(source, noisy, {
        maximumRmsError: 0.002,
    });

    assert.equal(result.ok, true);
    assert.ok(result.rmsError < 0.002);
});

test("rejects missing and mismatched landmark pairs", () => {
    assert.equal(
        solveLandmarkSimilarity(source.slice(0, 2), source.slice(0, 2)).reason,
        "insufficient-landmark-pairs",
    );
    assert.equal(
        solveLandmarkSimilarity(source, source.slice(0, 4)).reason,
        "insufficient-landmark-pairs",
    );
});

test("rejects duplicate, collinear, and non-finite landmarks", () => {
    assert.equal(
        solveLandmarkSimilarity(
            [source[0], source[0], source[2], source[3]],
            [source[0], source[0], source[2], source[3]],
        ).reason,
        "duplicate-landmarks",
    );
    const line = [
        [0, 0, 0],
        [1, 0, 0],
        [2, 0, 0],
        [3, 0, 0],
    ];
    assert.equal(
        solveLandmarkSimilarity(line, line).reason,
        "degenerate-landmark-layout",
    );
    assert.equal(
        solveLandmarkSimilarity(
            [
                [0, 0, 0],
                [1, 0, 0],
                [0, 1, Number.NaN],
            ],
            [
                [0, 0, 0],
                [1, 0, 0],
                [0, 1, 0],
            ],
        ).reason,
        "invalid-landmark-coordinates",
    );
});

test("rejects scale and residual outside validation bounds", () => {
    const tooLarge = transformed(source, [0, 0, 0, 1], 8, [0, 0, 0]);
    assert.equal(
        solveLandmarkSimilarity(source, tooLarge, {
            minimumScale: 0.1,
            maximumScale: 4,
            maximumRmsError: 1,
        }).reason,
        "similarity-scale-out-of-range",
    );

    const inconsistent = source.map((point) => [...point]);
    inconsistent[4] = [4, -3, 2];
    assert.equal(
        solveLandmarkSimilarity(source, inconsistent, {
            maximumRmsError: 0.01,
        }).reason,
        "landmark-residual-exceeds-tolerance",
    );
});

test("selects legacy fallback when landmark fitting is rejected", () => {
    let fallbackCalls = 0;
    const selection = selectLandmarkFit(
        { ok: false, reason: "landmark-residual-exceeds-tolerance" },
        () => {
            fallbackCalls += 1;
            return { fitMethod: "legacy-bounds" };
        },
    );

    assert.equal(selection.method, "legacy-bounds");
    assert.equal(selection.reason, "landmark-residual-exceeds-tolerance");
    assert.deepEqual(selection.report, { fitMethod: "legacy-bounds" });
    assert.equal(fallbackCalls, 1);
});
