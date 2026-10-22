import assert from "node:assert/strict";
import test from "node:test";
import {
    classifyGLBLoadError,
    createGLBFailureReport,
    createGLBLoadError,
    createInspectionExport,
    inspectGLBData,
    resolveProductGLBUrl,
} from "../../public/js/lhw-glb-inspector-core.js";

const topNames = ["LHW_Neck", "LHW_Shoulder_L", "LHW_Shoulder_R", "LHW_Hem"];
const bottomNames = [
    "LHW_Waist",
    "LHW_Crotch",
    "LHW_Knee_L",
    "LHW_Knee_R",
    "LHW_Hem_L",
    "LHW_Hem_R",
];
const landmarks = { top: topNames, bottom: bottomNames, shoes: null };
const identity = [1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1];

test("resolves Product IDs to relative product GLB URLs", () => {
    assert.equal(resolveProductGLBUrl("13"), "/models/products/13/product.glb");
    assert.equal(resolveProductGLBUrl("17"), "/models/products/17/product.glb");
    assert.equal(
        resolveProductGLBUrl("", "/custom/model.glb"),
        "/custom/model.glb",
    );
    assert.throws(() => resolveProductGLBUrl("../17"), /positive integer/);
});

test("distinguishes HTTP, network, and GLB parse failures", () => {
    assert.equal(
        classifyGLBLoadError(
            new Error(
                'fetch for "http://example.test/missing.glb" responded with 404: Not Found',
            ),
        ),
        "glb-http-error",
    );
    assert.equal(
        classifyGLBLoadError(new TypeError("Failed to fetch")),
        "glb-network-error",
    );
    assert.equal(
        classifyGLBLoadError(new Error("Invalid GLB header")),
        "glb-parse-failed",
    );
    assert.equal(
        classifyGLBLoadError({
            type: "error",
            target: {
                status: 404,
                statusText: "Not Found",
                responseURL: "https://shop.test/missing.glb",
            },
        }),
        "glb-http-error",
    );
});

function node(name, position, options = {}) {
    return {
        name,
        type: options.type || "Object3D",
        path: options.path || `/Garment/${name}`,
        parent: options.parent || null,
        isObject3D: options.isObject3D ?? true,
        localPosition: options.localPosition || position,
        localQuaternion: [0, 0, 0, 1],
        localScale: [1, 1, 1],
        worldQuaternion: [0, 0, 0, 1],
        worldScale: [1, 1, 1],
        worldPosition: position,
        localMatrix: options.localMatrix || identity,
        worldMatrix: options.worldMatrix || identity,
    };
}

function completeNodes() {
    return [
        node(topNames[0], [0, 2, 0]),
        node(topNames[1], [-1, 1.8, 0]),
        node(topNames[2], [1, 1.8, 0]),
        node(topNames[3], [0, 0, 0]),
    ];
}

function inspect(overrides = {}) {
    return inspectGLBData({
        url: "/models/products/test.glb",
        productId: "test",
        category: "top",
        expectedLandmarksByCategory: landmarks,
        nodes: completeNodes(),
        meshes: [
            {
                name: "Mesh",
                path: "/Garment/Mesh",
                bounds: {
                    min: [-1, 0, -0.2],
                    max: [1, 2, 0.2],
                },
            },
        ],
        bounds: { min: [-1, 0, -0.2], max: [1, 2, 0.2] },
        ...overrides,
    });
}

test("reports a complete GLB structure without claiming visual fit", () => {
    const report = inspect({ assetMetadata: { version: "2.0" } });

    assert.equal(report.status.structuralValid, true);
    assert.equal(report.status.landmarksComplete, true);
    assert.equal(report.status.eligibleForLandmarkAutoFit, true);
    assert.equal(report.autoFitReadiness.status, "ready");
    assert.equal(report.autoFitReadiness.ready, true);
    assert.equal(report.counts.landmarks.found, 4);
    assert.equal(report.status.note.includes("not validated"), true);
    assert.equal(report.measurements[0].valid, true);
    assert.equal(report.measurements[0].distance, 2);
});

test("reports missing landmarks and typo suggestions", () => {
    const report = inspect({
        nodes: completeNodes()
            .filter((entry) => entry.name !== "LHW_Hem")
            .concat(node("LHW_Hemm", [0, 0, 0])),
    });
    const hem = report.landmarks.find((entry) => entry.name === "LHW_Hem");

    assert.equal(hem.status, "missing");
    assert.equal(hem.similarNames[0].name, "LHW_Hemm");
    assert.equal(report.status.eligibleForLandmarkAutoFit, false);
    assert.equal(report.autoFitReadiness.status, "missing-landmarks");
    assert.equal(report.autoFitReadiness.ready, false);
    assert.deepEqual(report.autoFitReadiness.missingLandmarks, ["LHW_Hem"]);
});

test("requires all six configured bottom landmarks", () => {
    const report = inspect({
        category: "bottom",
        expectedLandmarksByCategory: landmarks,
        nodes: [],
    });

    assert.equal(report.counts.landmarks.expected, 6);
    assert.equal(report.counts.landmarks.missing, 6);
    assert.equal(report.autoFitReadiness.status, "missing-landmarks");
    assert.deepEqual(report.autoFitReadiness.missingLandmarks, bottomNames);
});

test("marks duplicate landmark node names ambiguous with hierarchy paths", () => {
    const nodes = completeNodes();
    nodes.push(
        node(topNames[1], [-0.8, 1.7, 0], { path: "/Other/LHW_Shoulder_L" }),
    );
    const report = inspect({ nodes });
    const shoulder = report.landmarks.find(
        (entry) => entry.name === topNames[1],
    );

    assert.equal(shoulder.status, "duplicate");
    assert.equal(shoulder.reason, "duplicate-name");
    assert.equal(shoulder.matches.length, 2);
    assert.deepEqual(shoulder.matches[0].localPosition, [-1, 1.8, 0]);
    assert.deepEqual(shoulder.matches[0].worldPosition, [-1, 1.8, 0]);
    assert.equal(report.counts.landmarks.duplicate, 1);
    assert.equal(report.autoFitReadiness.status, "invalid-landmarks");
    assert.equal(report.autoFitReadiness.ready, false);
});

test("marks a named non-Object3D or non-finite landmark invalid", () => {
    const nodes = completeNodes();
    nodes[0] = node(topNames[0], [Number.NaN, 0, 0], { isObject3D: false });
    const report = inspect({ nodes });

    assert.equal(report.landmarks[0].status, "invalid");
    assert.equal(
        report.landmarks[0].reason,
        "invalid-object-or-transform-data",
    );
    assert.equal(report.status.transformDataValid, false);
    assert.equal(report.autoFitReadiness.ready, false);
});

test("reports Infinity landmark transforms as invalid", () => {
    const nodes = completeNodes();
    nodes[0] = node(topNames[0], [Infinity, 0, 0]);
    const report = inspect({ nodes });

    assert.equal(report.landmarks[0].status, "invalid");
    assert.equal(report.autoFitReadiness.status, "invalid-transforms");
    assert.equal(report.autoFitReadiness.ready, false);
});

test("reports empty and degenerate bounds as invalid", () => {
    const empty = inspect({ bounds: null, meshes: [] });
    assert.equal(empty.bounds.valid, false);
    assert.equal(empty.status.structuralValid, false);

    const degenerate = inspect({
        bounds: { min: [1, 1, 1], max: [1, 1, 2] },
    });
    assert.equal(degenerate.bounds.reason, "degenerate-bounds");
    assert.equal(degenerate.status.structuralValid, false);
    assert.equal(degenerate.autoFitReadiness.status, "invalid-transforms");
});

test("warns and blocks readiness when a landmark origin is outside mesh bounds", () => {
    const nodes = completeNodes();
    nodes[0] = node(topNames[0], [20, 2, 0]);
    const report = inspect({ nodes });

    assert.equal(report.landmarks[0].outsideBounds, true);
    assert.match(
        report.landmarks[0].notes.join(" "),
        /outside the overall mesh bounds/,
    );
    assert.equal(report.autoFitReadiness.status, "invalid-landmarks");
    assert.equal(report.autoFitReadiness.ready, false);
});

test("keeps node local and GLB world positions distinct under parent transform", () => {
    const parentMatrix = [2, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 3, 0, 0, 1];
    const nodes = completeNodes();
    nodes[0] = node(topNames[0], [5, 2, 0], {
        localPosition: [1, 2, 0],
        parent: {
            name: "ScaledParent",
            path: "/Garment/ScaledParent",
            localPosition: [3, 0, 0],
            localQuaternion: [0, 0, 0, 1],
            localScale: [2, 1, 1],
            worldQuaternion: [0, 0, 0, 1],
            worldScale: [2, 1, 1],
            worldPosition: [3, 0, 0],
            localMatrix: identity,
            worldMatrix: parentMatrix,
        },
    });
    const report = inspect({ nodes });
    const neck = report.landmarks[0];

    assert.deepEqual(neck.localPosition, [1, 2, 0]);
    assert.deepEqual(neck.worldPosition, [5, 2, 0]);
    assert.equal(
        neck.notes.some((note) => note.includes("rotation/scale")),
        true,
    );
    assert.deepEqual(neck.parentTransform.worldScale, [2, 1, 1]);
});

test("transforms world positions into fitting-stage local space", () => {
    const stageWorld = [...identity];
    stageWorld[12] = 10;
    stageWorld[13] = 2;
    stageWorld[14] = 3;
    const inverseStage = [...identity];
    inverseStage[12] = -10;
    inverseStage[13] = -2;
    inverseStage[14] = -3;
    const nodes = completeNodes();
    const nodeWorld = [...identity];
    nodeWorld[12] = 12;
    nodeWorld[13] = 3;
    nodeWorld[14] = 4;
    nodes[0] = node(topNames[0], [12, 3, 4], { worldMatrix: nodeWorld });
    const report = inspect({
        nodes,
        fittingStageInverseMatrix: inverseStage,
        fittingStageWorldMatrix: stageWorld,
    });

    assert.deepEqual(report.landmarks[0].fittingStageLocalPosition, [2, 1, 1]);
    assert.equal(report.fittingStage.available, true);
});

test("reports stage-local coordinates unavailable when no stage is supplied", () => {
    const report = inspect();

    assert.equal(report.fittingStage.available, false);
    assert.equal(report.landmarks[0].fittingStageLocalPosition, null);
    assert.match(report.coordinateSpaces.fittingStageLocal, /unavailable/);
});

test("does not invent a shoe landmark convention", () => {
    const report = inspect({
        category: "shoes",
        expectedLandmarksByCategory: landmarks,
    });

    assert.equal(report.status.landmarksConfigured, false);
    assert.equal(report.landmarksConfigured, null);
    assert.equal(report.status.eligibleForLandmarkAutoFit, false);
    assert.equal(report.autoFitReadiness.status, "missing-landmarks");
    assert.match(report.warnings.at(-1), /not-configured/);
});

test("reports load errors without claiming that landmarks are missing", () => {
    const report = createGLBLoadError(
        "/missing.glb",
        new Error("404 Not Found"),
        {
            productId: "13",
            category: "top",
            expectedLandmarksByCategory: landmarks,
        },
    );

    assert.equal(report.status.structuralValid, false);
    assert.equal(report.status.landmarksConfigured, true);
    assert.equal(report.counts.landmarks.expected, 4);
    assert.equal(report.counts.landmarks.missing, 0);
    assert.equal(report.input.productId, "13");
    assert.equal(report.errors[0].code, "glb-load-failed");
    assert.equal(report.errors[0].message, "404 Not Found");
    assert.equal(report.autoFitReadiness.status, "inspection-failed");
    assert.equal(report.status.inspectionCompleted, false);
});

test("reports invalid GLB parsing without presenting an inspection result", () => {
    const report = createGLBFailureReport(
        "/invalid.glb",
        new Error("Invalid GLB header"),
        { code: "glb-parse-failed", failureStage: "parse" },
    );
    const exported = createInspectionExport(report);

    assert.equal(report.status.inspectionCompleted, false);
    assert.equal(report.autoFitReadiness.status, "inspection-failed");
    assert.equal(exported.success, false);
    assert.equal(exported.errors[0].message, "Invalid GLB header");
    assert.equal(exported.landmarks.length, 0);
});

test("exports successful and failed reports with stable diagnostic fields", () => {
    const success = createInspectionExport(
        inspect({ assetMetadata: { version: "2.0" } }),
    );
    assert.equal(success.success, true);
    assert.equal(success.assetUrl, "/models/products/test.glb");
    assert.equal(success.inspectionStatus, "completed");
    assert.equal(success.nodeCount, 4);
    assert.equal(success.meshCount, 1);
    assert.equal(success.autoFitReadiness.status, "ready");
    assert.ok(Array.isArray(success.landmarks));

    const failed = createInspectionExport(
        createGLBFailureReport(
            "/missing.glb",
            Object.assign(new Error("Not Found"), { status: 404 }),
            { productId: "13", category: "top", code: "glb-http-error" },
        ),
    );
    assert.equal(failed.success, false);
    assert.equal(failed.assetUrl, "/missing.glb");
    assert.equal(failed.productId, "13");
    assert.equal(failed.inspectionStatus, "inspection-failed");
    assert.equal(failed.autoFitReadiness.status, "inspection-failed");
    assert.equal(failed.errors[0].status, 404);
    assert.equal(failed.nodeCount, 0);
    assert.deepEqual(failed.landmarks, []);
});

test("reports glTF 2.0 coordinate convention and meter unit provenance", () => {
    const report = inspect({ assetMetadata: { version: "2.0" } });

    assert.equal(report.coordinateSystem.handedness, "right-handed");
    assert.equal(report.coordinateSystem.upAxis, "+Y");
    assert.match(report.coordinateSystem.forwardAxis, /unknown/);
    assert.equal(report.units.physicalUnit, "meters");
    assert.equal(report.units.unitToMeters, 1);
});

test("does not report ready when unit metadata is unavailable", () => {
    const report = inspect();

    assert.equal(report.autoFitReadiness.status, "unknown-units");
    assert.equal(report.autoFitReadiness.ready, false);
    assert.equal(report.status.eligibleForLandmarkAutoFit, false);
});

test("preserves raw units and reports optional user conversion", () => {
    const report = inspect({ unitToMeters: 0.01 });

    assert.deepEqual(report.landmarks[0].worldPosition, [0, 2, 0]);
    assert.deepEqual(report.landmarks[0].worldPositionMeters, [0, 0.02, 0]);
    assert.equal(report.units.physicalUnit, "unknown");
    assert.equal(report.measurements[0].distanceMeters, 0.02);
});

test("does not consider a zero landmark distance a valid measurement", () => {
    const nodes = completeNodes();
    nodes[2] = node(topNames[2], [-1, 1.8, 0]);
    const report = inspect({ nodes });

    assert.equal(report.measurements[0].distance, 0);
    assert.equal(report.measurements[0].valid, false);
    assert.equal(report.measurements[0].reason, "zero-distance");
});

test("does not mark a complete but degenerate landmark layout Auto-Fit eligible", () => {
    const nodes = topNames.map((name, index) =>
        node(name, [index, index * 2, 0]),
    );
    const report = inspect({ nodes });

    assert.equal(report.status.landmarksComplete, true);
    assert.equal(report.status.landmarkLayoutValid, false);
    assert.equal(
        report.status.landmarkLayoutReason,
        "degenerate-landmark-layout",
    );
    assert.equal(report.status.eligibleForLandmarkAutoFit, false);
});
