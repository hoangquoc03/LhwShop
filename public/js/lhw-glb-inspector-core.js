import { solveLandmarkSimilarity } from "./lhw-landmark-solver.js";

const CATEGORY_MEASUREMENTS = {
    top: [
        ["shoulderWidth", ["LHW_Shoulder_L", "LHW_Shoulder_R"]],
        ["neckToHem", ["LHW_Neck", "LHW_Hem"]],
        ["chestToBack", ["LHW_Chest_Front", "LHW_Back_Center"]],
    ],
    bottom: [
        ["kneeWidth", ["LHW_Knee_L", "LHW_Knee_R"]],
        ["waistToCrotch", ["LHW_Waist", "LHW_Crotch"]],
        ["leftKneeToHem", ["LHW_Knee_L", "LHW_Hem_L"]],
        ["rightKneeToHem", ["LHW_Knee_R", "LHW_Hem_R"]],
        ["waistToFront", ["LHW_Waist", "LHW_Waist_Front"]],
    ],
};

export function validateLandmarkGeometry(category, points, bounds) {
    const errors = [];
    const extent = Math.max(...bounds.size);
    const verticalSpan = bounds.size[1];
    const minimumGap = Math.max(extent * 1e-5, verticalSpan * 0.005);
    const point = (name) => points.get(name);
    const distance = (left, right) =>
        Math.hypot(
            left[0] - right[0],
            left[1] - right[1],
            left[2] - right[2],
        );
    const requireGap = (higher, lower, name) => {
        if (higher - lower <= minimumGap) {
            errors.push({
                code: "incorrect-landmark-order",
                message: `${name} must be clearly above the next landmark.`,
            });
        }
    };
    const requireProportion = (value, minimum, maximum, name) => {
        if (!Number.isFinite(value) || value < minimum || value > maximum) {
            errors.push({
                code: "implausible-landmark-proportions",
                message: `${name} is outside the accepted relative range (${minimum}-${maximum}).`,
            });
        }
    };
    if (bounds.min && bounds.max) {
        for (const [name, position] of points) {
            const tolerance = extent * 1e-5;
            if (
                position.some(
                    (value, axis) =>
                        value < bounds.min[axis] - tolerance ||
                        value > bounds.max[axis] + tolerance,
                )
            ) {
                errors.push({
                    code: "landmark-outside-bounds",
                    message: `${name} lies outside the mesh bounds.`,
                });
            }
        }
    }

    if (category === "top") {
        const neck = point("LHW_Neck");
        const shoulderLeft = point("LHW_Shoulder_L");
        const shoulderRight = point("LHW_Shoulder_R");
        const hem = point("LHW_Hem");
        const chest = point("LHW_Chest_Front");
        const back = point("LHW_Back_Center");
        const bodyHeight = neck[1] - hem[1];
        requireGap(neck[1], shoulderLeft[1], "Neck and left shoulder");
        requireGap(neck[1], shoulderRight[1], "Neck and right shoulder");
        requireGap(shoulderLeft[1], hem[1], "Left shoulder and hem");
        requireGap(shoulderRight[1], hem[1], "Right shoulder and hem");
        requireGap(
            (shoulderLeft[1] + shoulderRight[1]) / 2,
            chest[1],
            "Shoulders and front chest",
        );
        requireGap(
            (shoulderLeft[1] + shoulderRight[1]) / 2,
            back[1],
            "Shoulders and back center",
        );
        requireGap(chest[1], hem[1], "Front chest and hem");
        requireGap(neck[1], chest[1], "Neck and front chest");
        requireGap(back[1], hem[1], "Back center and hem");
        requireGap(neck[1], back[1], "Neck and back center");
        requireProportion(
            distance(shoulderLeft, shoulderRight) / bodyHeight,
            0.1,
            2.5,
            "Shoulder width relative to neck-to-hem height",
        );
        requireProportion(
            distance(chest, back) / extent,
            1e-5,
            1,
            "Front-chest to back-center separation",
        );
        requireProportion(
            Math.abs(chest[1] - back[1]) / bodyHeight,
            0,
            0.25,
            "Front-chest and back-center vertical alignment",
        );
    } else if (category === "bottom") {
        const waist = point("LHW_Waist");
        const crotch = point("LHW_Crotch");
        const kneeLeft = point("LHW_Knee_L");
        const kneeRight = point("LHW_Knee_R");
        const hemLeft = point("LHW_Hem_L");
        const hemRight = point("LHW_Hem_R");
        const waistFront = point("LHW_Waist_Front");
        const kneeY = (kneeLeft[1] + kneeRight[1]) / 2;
        const hemY = (hemLeft[1] + hemRight[1]) / 2;
        const bodyHeight = waist[1] - hemY;
        const kneeSide = kneeRight.map((value, index) => value - kneeLeft[index]);
        const hemSide = hemRight.map((value, index) => value - hemLeft[index]);
        const sideCosine =
            kneeSide.reduce(
                (sum, value, index) => sum + value * hemSide[index],
                0,
            ) /
            (Math.hypot(...kneeSide) * Math.hypot(...hemSide));

        requireGap(waist[1], crotch[1], "Waist and crotch");
        requireGap(crotch[1], kneeLeft[1], "Crotch and left knee");
        requireGap(crotch[1], kneeRight[1], "Crotch and right knee");
        requireGap(kneeLeft[1], hemLeft[1], "Left knee and hem");
        requireGap(kneeRight[1], hemRight[1], "Right knee and hem");
        requireProportion(
            distance(waist, waistFront) / extent,
            1e-5,
            1,
            "Waist to front-waist separation",
        );
        requireProportion(
            Math.abs(waist[1] - waistFront[1]) / bodyHeight,
            0,
            0.15,
            "Waist and front-waist vertical alignment",
        );
        requireProportion(
            Math.abs(kneeLeft[1] - kneeRight[1]) / bodyHeight,
            0,
            0.25,
            "Left/right knee vertical alignment",
        );
        requireProportion(
            Math.abs(hemLeft[1] - hemRight[1]) / bodyHeight,
            0,
            0.25,
            "Left/right hem vertical alignment",
        );
        requireProportion(
            distance(kneeLeft, kneeRight) / bodyHeight,
            0.1,
            2.5,
            "Knee width relative to waist-to-hem height",
        );
        if (!Number.isFinite(sideCosine) || sideCosine < 0.25) {
            errors.push({
                code: "incorrect-landmark-order",
                message:
                    "Left/right knee and hem labels must follow the same garment sides.",
            });
        }
    }

    return {
        valid: errors.length === 0,
        reason: errors[0]?.code || null,
        errors,
    };
}

export function resolveProductGLBUrl(productId, fallbackUrl = "") {
    const normalizedId = String(productId ?? "").trim();
    if (!normalizedId) return fallbackUrl;
    if (!/^\d+$/.test(normalizedId) || Number(normalizedId) < 1) {
        throw new Error("Product ID must be a positive integer.");
    }
    return `/models/products/${normalizedId}/product.glb`;
}

export function classifyGLBLoadError(error) {
    const detail = error instanceof Error ? error.message : String(error);
    const response = error?.target ?? error?.currentTarget ?? error?.response;
    const status = error?.status ?? response?.status;
    if (
        (Number(status) >= 400 && Number(status) < 600) ||
        /responded with\s+\d{3}/i.test(detail)
    ) {
        return "glb-http-error";
    }
    if (
        /failed to fetch|networkerror|network request failed|load failed/i.test(
            detail,
        ) ||
        /ERR_CONNECTION_REFUSED|ERR_CONNECTION_RESET|ERR_NAME_NOT_RESOLVED|ERR_INTERNET_DISCONNECTED/i.test(
            detail,
        )
    ) {
        return "glb-network-error";
    }
    if (
        response &&
        (response.status === 0 ||
            error?.type === "error" ||
            error?.type === "timeout")
    ) {
        return "glb-network-error";
    }
    return "glb-parse-failed";
}

export function describeGLBLoadError(error) {
    const response = error?.target ?? error?.currentTarget ?? error?.response;
    const status = error?.status ?? response?.status;
    const statusText = error?.statusText ?? response?.statusText;
    const url = response?.responseURL ?? error?.url ?? null;
    const message = error instanceof Error ? error.message : error?.message;
    return {
        name: error?.name ?? null,
        message:
            message ||
            (status
                ? `HTTP ${status}${statusText ? ` ${statusText}` : ""}${url ? ` (${url})` : ""}`
                : error?.type
                  ? `GLB request failed (${error.type})${url ? ` (${url})` : ""}`
                  : String(error)),
        status:
            Number.isFinite(Number(status)) && Number(status) > 0
                ? Number(status)
                : null,
        statusText: statusText || null,
        url,
        type: error?.type ?? null,
    };
}

function isFiniteVector(value) {
    return (
        Array.isArray(value) &&
        value.length === 3 &&
        value.every(Number.isFinite)
    );
}

function isFiniteQuaternion(value) {
    return (
        Array.isArray(value) &&
        value.length === 4 &&
        value.every(Number.isFinite)
    );
}

function isFiniteMatrix(value) {
    return (
        Array.isArray(value) &&
        value.length === 16 &&
        value.every(Number.isFinite)
    );
}

function isValidNodeTransform(node) {
    const nodeValid =
        isFiniteVector(node.localPosition) &&
        isFiniteVector(node.worldPosition) &&
        isFiniteQuaternion(node.localQuaternion) &&
        isFiniteVector(node.localScale) &&
        isFiniteQuaternion(node.worldQuaternion) &&
        isFiniteVector(node.worldScale) &&
        isFiniteMatrix(node.localMatrix) &&
        isFiniteMatrix(node.worldMatrix);
    if (!nodeValid || !node.parent) return nodeValid;
    return (
        isFiniteVector(node.parent.localPosition) &&
        isFiniteQuaternion(node.parent.localQuaternion) &&
        isFiniteVector(node.parent.localScale) &&
        isFiniteVector(node.parent.worldPosition) &&
        isFiniteQuaternion(node.parent.worldQuaternion) &&
        isFiniteVector(node.parent.worldScale) &&
        isFiniteMatrix(node.parent.localMatrix) &&
        isFiniteMatrix(node.parent.worldMatrix)
    );
}

function transformPoint(matrix, point) {
    if (!isFiniteMatrix(matrix) || !isFiniteVector(point)) return null;
    const [x, y, z] = point;
    const w = matrix[3] * x + matrix[7] * y + matrix[11] * z + matrix[15];
    if (!Number.isFinite(w) || Math.abs(w) <= 1e-12) return null;
    return [
        (matrix[0] * x + matrix[4] * y + matrix[8] * z + matrix[12]) / w,
        (matrix[1] * x + matrix[5] * y + matrix[9] * z + matrix[13]) / w,
        (matrix[2] * x + matrix[6] * y + matrix[10] * z + matrix[14]) / w,
    ];
}

function distance(left, right) {
    if (!isFiniteVector(left) || !isFiniteVector(right)) return null;
    return Math.hypot(
        left[0] - right[0],
        left[1] - right[1],
        left[2] - right[2],
    );
}

function boundsSummary(bounds) {
    if (!bounds || !isFiniteVector(bounds.min) || !isFiniteVector(bounds.max)) {
        return {
            valid: false,
            reason: "empty-or-non-finite-bounds",
            min: null,
            max: null,
            center: null,
            size: null,
        };
    }
    const size = bounds.max.map((value, index) => value - bounds.min[index]);
    const center = bounds.min.map(
        (value, index) => (value + bounds.max[index]) / 2,
    );
    const valid = size.every((value) => Number.isFinite(value) && value > 0);
    return {
        valid,
        reason: valid ? null : "degenerate-bounds",
        min: [...bounds.min],
        max: [...bounds.max],
        center,
        size,
    };
}

function convertBounds(bounds, factor) {
    if (!bounds.valid || !factor) return null;
    return {
        min: bounds.min.map((value) => value * factor),
        max: bounds.max.map((value) => value * factor),
        center: bounds.center.map((value) => value * factor),
        size: bounds.size.map((value) => value * factor),
        unit: "meters (user-configured conversion)",
    };
}

function editDistance(left, right) {
    const row = Array.from({ length: right.length + 1 }, (_, index) => index);
    for (let i = 1; i <= left.length; i += 1) {
        let previous = row[0];
        row[0] = i;
        for (let j = 1; j <= right.length; j += 1) {
            const old = row[j];
            row[j] = Math.min(
                row[j] + 1,
                row[j - 1] + 1,
                previous + (left[i - 1] === right[j - 1] ? 0 : 1),
            );
            previous = old;
        }
    }
    return row[right.length];
}

function findSimilarNames(expected, nodes) {
    const candidates = nodes
        .filter((node) => node.name && node.name !== expected)
        .map((node) => ({
            name: node.name,
            path: node.path,
            editDistance: editDistance(
                expected.toLowerCase(),
                node.name.toLowerCase(),
            ),
        }))
        .filter((candidate) => candidate.editDistance <= 3)
        .sort((left, right) => left.editDistance - right.editDistance);
    return candidates.slice(0, 5);
}

function describeTransformAnomalies(node) {
    const notes = [];
    if (!isFiniteMatrix(node.localMatrix)) {
        notes.push("local matrix is missing or non-finite");
    }
    if (!isFiniteMatrix(node.worldMatrix)) {
        notes.push("world matrix is missing or non-finite");
    }
    if (!isFiniteVector(node.localPosition)) {
        notes.push("local position is missing or non-finite");
    }
    if (!isFiniteVector(node.worldPosition)) {
        notes.push("world position is missing or non-finite");
    }
    if (node.parent?.worldMatrix && isFiniteMatrix(node.parent.worldMatrix)) {
        const parentMatrix = node.parent.worldMatrix;
        const hasRotationOrScale =
            Math.abs(parentMatrix[0] - 1) > 1e-6 ||
            Math.abs(parentMatrix[5] - 1) > 1e-6 ||
            Math.abs(parentMatrix[10] - 1) > 1e-6 ||
            Math.abs(parentMatrix[1]) > 1e-6 ||
            Math.abs(parentMatrix[2]) > 1e-6 ||
            Math.abs(parentMatrix[4]) > 1e-6 ||
            Math.abs(parentMatrix[6]) > 1e-6 ||
            Math.abs(parentMatrix[8]) > 1e-6 ||
            Math.abs(parentMatrix[9]) > 1e-6;
        if (hasRotationOrScale) {
            notes.push(
                "parent rotation/scale affects the node's GLB scene/world position",
            );
        }
    }
    return notes;
}

export function inspectGLBData({
    url,
    productId = null,
    category,
    expectedLandmarksByCategory = {},
    nodes = [],
    meshes = [],
    bounds = null,
    fittingStageInverseMatrix = null,
    fittingStageWorldMatrix = null,
    unitToMeters = null,
    assetMetadata = null,
}) {
    const configured =
        Object.prototype.hasOwnProperty.call(
            expectedLandmarksByCategory,
            category,
        ) &&
        Array.isArray(expectedLandmarksByCategory[category]) &&
        expectedLandmarksByCategory[category].length > 0;
    const expectedLandmarks = configured
        ? [...expectedLandmarksByCategory[category]]
        : [];
    const stageAvailable =
        isFiniteMatrix(fittingStageInverseMatrix) &&
        isFiniteMatrix(fittingStageWorldMatrix);
    const gltfVersion = assetMetadata?.version || null;
    const physicalUnit = gltfVersion === "2.0" ? "meters" : "unknown";
    const effectiveUnitToMeters =
        Number.isFinite(unitToMeters) && unitToMeters > 0
            ? unitToMeters
            : physicalUnit === "meters"
              ? 1
              : null;
    const coordinateSystem = {
        format: gltfVersion ? `glTF ${gltfVersion}` : "unknown",
        handedness: gltfVersion === "2.0" ? "right-handed" : "unknown",
        upAxis: gltfVersion === "2.0" ? "+Y" : "unknown",
        forwardAxis: "unknown; asset does not declare semantic garment facing",
        source:
            gltfVersion === "2.0"
                ? "glTF 2.0 coordinate convention; semantic front/back is not inferred"
                : "No recognized glTF 2.0 coordinate metadata was supplied",
    };
    const overallBounds = boundsSummary(bounds);
    const scaleToMeters = effectiveUnitToMeters;
    const meshReports = meshes.map((mesh) => {
        const meshBounds = boundsSummary(mesh.bounds);
        return {
            name: mesh.name || "(unnamed)",
            path: mesh.path || null,
            bounds: meshBounds,
            boundsMeters: convertBounds(meshBounds, scaleToMeters),
        };
    });
    const byName = new Map();
    for (const node of nodes) {
        if (!node.name) continue;
        const matches = byName.get(node.name) || [];
        matches.push(node);
        byName.set(node.name, matches);
    }

    const landmarkReports = expectedLandmarks.map((name) => {
        const matches = byName.get(name) || [];
        if (!matches.length) {
            return {
                name,
                status: "missing",
                reason: "node-not-found",
                similarNames: findSimilarNames(name, nodes),
            };
        }
        if (matches.length > 1) {
            return {
                name,
                status: "duplicate",
                reason: "duplicate-name",
                matches: matches.map((node) => ({
                    path: node.path || null,
                    type: node.type || null,
                    parent: node.parent || null,
                    localPosition: node.localPosition || null,
                    localQuaternion: node.localQuaternion || null,
                    localScale: node.localScale || null,
                    worldPosition: node.worldPosition || null,
                    worldQuaternion: node.worldQuaternion || null,
                    worldScale: node.worldScale || null,
                    localMatrix: node.localMatrix || null,
                    worldMatrix: node.worldMatrix || null,
                    fittingStageLocalPosition:
                        stageAvailable && isFiniteVector(node.worldPosition)
                            ? transformPoint(
                                  fittingStageInverseMatrix,
                                  node.worldPosition,
                              )
                            : null,
                })),
            };
        }

        const node = matches[0];
        const notes = describeTransformAnomalies(node);
        const boundsTolerance = overallBounds.valid
            ? Math.max(...overallBounds.size) * 1e-5
            : 0;
        const outsideBounds =
            overallBounds.valid &&
            isFiniteVector(node.worldPosition) &&
            node.worldPosition.some(
                (value, axis) =>
                    value < overallBounds.min[axis] - boundsTolerance ||
                    value > overallBounds.max[axis] + boundsTolerance,
            );
        if (outsideBounds) {
            notes.push("landmark origin lies outside the overall mesh bounds");
        }
        const stagePosition =
            stageAvailable && isFiniteVector(node.worldPosition)
                ? transformPoint(fittingStageInverseMatrix, node.worldPosition)
                : null;
        const invalid =
            !node.isObject3D ||
            !isValidNodeTransform(node) ||
            (stageAvailable && !stagePosition);

        if (invalid) {
            return {
                name,
                status: "invalid",
                reason: "invalid-object-or-transform-data",
                path: node.path || null,
                type: node.type || null,
                outsideBounds,
                parent: node.parent || null,
                localPosition: node.localPosition || null,
                localPositionMeters:
                    scaleToMeters && isFiniteVector(node.localPosition)
                        ? node.localPosition.map(
                              (value) => value * scaleToMeters,
                          )
                        : null,
                worldPosition: node.worldPosition || null,
                worldPositionMeters:
                    scaleToMeters && isFiniteVector(node.worldPosition)
                        ? node.worldPosition.map(
                              (value) => value * scaleToMeters,
                          )
                        : null,
                fittingStageLocalPosition: stagePosition,
                fittingStageLocalPositionMeters:
                    scaleToMeters && stagePosition
                        ? stagePosition.map((value) => value * scaleToMeters)
                        : null,
                notes,
            };
        }

        return {
            name,
            status: "found",
            path: node.path || null,
            type: node.type || null,
            outsideBounds,
            parent: node.parent || null,
            localPosition: [...node.localPosition],
            localPositionMeters: scaleToMeters
                ? node.localPosition.map((value) => value * scaleToMeters)
                : null,
            worldPosition: [...node.worldPosition],
            worldPositionMeters: scaleToMeters
                ? node.worldPosition.map((value) => value * scaleToMeters)
                : null,
            fittingStageLocalPosition: stagePosition,
            fittingStageLocalPositionMeters:
                scaleToMeters && stagePosition
                    ? stagePosition.map((value) => value * scaleToMeters)
                    : null,
            transform: {
                localPosition: [...node.localPosition],
                localQuaternion: node.localQuaternion || null,
                localScale: node.localScale || null,
                worldQuaternion: node.worldQuaternion || null,
                worldScale: node.worldScale || null,
                localMatrix: [...node.localMatrix],
                worldMatrix: [...node.worldMatrix],
            },
            parentTransform: node.parent
                ? {
                      name: node.parent.name,
                      path: node.parent.path,
                      localPosition: node.parent.localPosition || null,
                      localQuaternion: node.parent.localQuaternion || null,
                      localScale: node.parent.localScale || null,
                      worldQuaternion: node.parent.worldQuaternion || null,
                      worldScale: node.parent.worldScale || null,
                      worldPosition: node.parent.worldPosition || null,
                      localMatrix: node.parent.localMatrix || null,
                      worldMatrix: node.parent.worldMatrix || null,
                  }
                : null,
            notes,
        };
    });

    const duplicateLandmarkNames = landmarkReports
        .filter((landmark) => landmark.reason === "duplicate-name")
        .map((landmark) => landmark.name);
    const counts = {
        expected: landmarkReports.length,
        found: landmarkReports.filter((landmark) => landmark.status === "found")
            .length,
        missing: landmarkReports.filter(
            (landmark) => landmark.status === "missing",
        ).length,
        invalid: landmarkReports.filter(
            (landmark) => landmark.status === "invalid",
        ).length,
        duplicate: duplicateLandmarkNames.length,
    };
    const landmarkByName = new Map(
        landmarkReports.map((landmark) => [landmark.name, landmark]),
    );
    const foundLandmarkPoints = expectedLandmarks.map((name) =>
        landmarkByName.get(name),
    );
    const completePoints =
        configured &&
        foundLandmarkPoints.length > 0 &&
        foundLandmarkPoints.every(
            (landmark) =>
                landmark?.status === "found" &&
                isFiniteVector(landmark.worldPosition),
        );
    const layoutValidation = completePoints
        ? solveLandmarkSimilarity(
              foundLandmarkPoints.map((landmark) => landmark.worldPosition),
              foundLandmarkPoints.map((landmark) => landmark.worldPosition),
              { minimumScale: 0.02, maximumScale: 50 },
          )
        : null;
    const geometryValidation = completePoints && overallBounds.valid
        ? validateLandmarkGeometry(
              category,
              new Map(
                  foundLandmarkPoints.map((landmark) => [
                      landmark.name,
                      landmark.worldPosition,
                  ]),
              ),
              overallBounds,
          )
        : null;
    const landmarkLayoutValid = layoutValidation && geometryValidation
        ? layoutValidation.ok && geometryValidation.valid
        : configured
          ? false
          : null;
    const measurements = (CATEGORY_MEASUREMENTS[category] || []).map(
        ([name, pair]) => {
            const left = landmarkByName.get(pair[0]);
            const right = landmarkByName.get(pair[1]);
            const valid = left?.status === "found" && right?.status === "found";
            const value = valid
                ? distance(left.worldPosition, right.worldPosition)
                : null;
            return {
                name,
                landmarks: [...pair],
                valid: valid && Number.isFinite(value) && value > 0,
                distance: Number.isFinite(value) ? value : null,
                unit: "raw GLB scene units",
                distanceMeters:
                    Number.isFinite(value) && scaleToMeters
                        ? value * scaleToMeters
                        : null,
                reason: valid
                    ? !Number.isFinite(value)
                        ? "non-finite-distance"
                        : value <= 0
                          ? "zero-distance"
                          : null
                    : "required-landmarks-unavailable",
            };
        },
    );
    const transformDataValid = nodes.every(isValidNodeTransform);
    const hasMesh = meshes.length > 0;
    const meshBoundsValid = meshReports.every((mesh) => mesh.bounds.valid);
    const structureValid =
        hasMesh && overallBounds.valid && meshBoundsValid && transformDataValid;
    const outsideBoundsLandmarks = landmarkReports
        .filter((landmark) => landmark.outsideBounds)
        .map((landmark) => landmark.name);
    const eligibleForLandmarkAutoFit =
        configured &&
        expectedLandmarks.length > 0 &&
        counts.found === expectedLandmarks.length &&
        counts.missing === 0 &&
        counts.invalid === 0 &&
        counts.duplicate === 0 &&
        landmarkLayoutValid === true &&
        structureValid &&
        physicalUnit !== "unknown";
    let readinessStatus = "ready";
    let readinessReason = "Required landmarks and transforms are valid.";
    if (!structureValid) {
        readinessStatus = "invalid-transforms";
        readinessReason =
            "Mesh bounds or one or more node transforms are invalid.";
    } else if (!configured || counts.missing > 0) {
        readinessStatus = "missing-landmarks";
        readinessReason = configured
            ? "One or more required landmarks are missing."
            : `No required landmark convention is configured for category ${category}.`;
    } else if (
        counts.invalid > 0 ||
        counts.duplicate > 0 ||
        outsideBoundsLandmarks.length > 0 ||
        landmarkLayoutValid !== true
    ) {
        readinessStatus = "invalid-landmarks";
        readinessReason =
            counts.duplicate > 0
                ? "One or more required landmark names are duplicated."
                : outsideBoundsLandmarks.length > 0
                  ? "One or more landmark origins lie outside mesh bounds."
                  : layoutValidation?.reason ||
                    geometryValidation?.reason ||
                    "One or more landmark transforms are invalid.";
    } else if (physicalUnit === "unknown") {
        readinessStatus = "unknown-units";
        readinessReason =
            "Coordinate units are not verified; confirm physical scale before fitting.";
    }
    const readinessWarnings = [
        ...(physicalUnit === "unknown"
            ? [
                  "Physical units are unknown; confirm scale before applying meter-based fit offsets.",
              ]
            : []),
        ...(outsideBoundsLandmarks.length
            ? [
                  `Landmark origins outside overall mesh bounds: ${outsideBoundsLandmarks.join(", ")}.`,
              ]
            : []),
    ];
    return {
        schemaVersion: 1,
        input: { url, productId: productId || null, category },
        status: {
            inspectionCompleted: true,
            structuralValid: structureValid,
            transformDataValid,
            meshBoundsValid,
            landmarksConfigured: configured,
            landmarksComplete:
                configured && counts.found === expectedLandmarks.length,
            landmarkLayoutValid,
            landmarkLayoutReason:
                layoutValidation?.reason || geometryValidation?.reason || null,
            landmarkGeometryValid: geometryValidation?.valid ?? null,
            eligibleForLandmarkAutoFit,
            note: eligibleForLandmarkAutoFit
                ? "Landmark structure is complete; avatar fit and visual fit are not validated."
                : configured
                  ? "Landmark-based Auto-Fit is unavailable for this asset; this report does not evaluate legacy fitting."
                  : "No landmark convention is configured for this category.",
        },
        units: {
            reportedCoordinates: "raw GLB scene units",
            physicalUnit,
            projectConvention:
                physicalUnit === "meters"
                    ? "glTF 2.0 defines linear distances in meters."
                    : "The fitting room uses meter-based offsets, but this asset unit is unverified.",
            unitToMeters: scaleToMeters,
            convertedPositionUnit: scaleToMeters ? "meters" : null,
        },
        coordinateSystem,
        unitStatus: {
            value: physicalUnit,
            source:
                physicalUnit === "meters"
                    ? "glTF 2.0 specification"
                    : "unverified",
            userConversion:
                Number.isFinite(unitToMeters) && unitToMeters > 0
                    ? unitToMeters
                    : null,
        },
        counts: {
            nodes: nodes.length,
            meshes: meshes.length,
            landmarks: counts,
        },
        bounds: overallBounds,
        boundsMeters: convertBounds(overallBounds, scaleToMeters),
        meshBounds: meshReports,
        landmarkGeometry: geometryValidation,
        nodes,
        landmarksConfigured: configured ? expectedLandmarks : null,
        landmarks: landmarkReports,
        measurements,
        coordinateSpaces: {
            nodeLocal: "relative to immediate parent",
            glbSceneWorld:
                "after GLB node hierarchy transforms; before fittingStage",
            fittingStageLocal: stageAvailable
                ? "world position transformed by inverse fittingStage.matrixWorld"
                : "unavailable: no valid fittingStage transform was supplied",
        },
        hierarchyPolicy: {
            configured: false,
            note: "The project defines landmark names but no required parent or hierarchy path.",
        },
        fittingStage: {
            available: stageAvailable,
            inverseWorldMatrix: stageAvailable
                ? [...fittingStageInverseMatrix]
                : null,
            worldMatrix: stageAvailable ? [...fittingStageWorldMatrix] : null,
        },
        autoFitReadiness: {
            status: readinessStatus,
            ready: readinessStatus === "ready",
            reason: readinessReason,
            requiredLandmarks: expectedLandmarks,
            missingLandmarks: landmarkReports
                .filter((landmark) => landmark.status === "missing")
                .map((landmark) => landmark.name),
            invalidLandmarks: landmarkReports
                .filter((landmark) => landmark.status === "invalid")
                .map((landmark) => landmark.name),
            duplicateLandmarks: duplicateLandmarkNames,
            warnings: readinessWarnings,
        },
        warnings: [
            ...(expectedLandmarks.length && !counts.found
                ? ["No configured landmark nodes were found."]
                : []),
            ...(duplicateLandmarkNames.length
                ? [
                      `Duplicate landmark node names: ${duplicateLandmarkNames.join(", ")}.`,
                  ]
                : []),
            ...readinessWarnings,
            ...(configured &&
            completePoints &&
            layoutValidation &&
            !layoutValidation.ok
                ? [
                      `Landmark layout is not solver-usable: ${layoutValidation.reason}.`,
                  ]
                : []),
            ...(!hasMesh ? ["Model contains no mesh nodes."] : []),
            ...(!overallBounds.valid
                ? [`Overall bounds are invalid: ${overallBounds.reason}.`]
                : []),
            ...(nodes.length && !transformDataValid
                ? ["One or more node transforms are missing or non-finite."]
                : []),
            ...(hasMesh && !meshBoundsValid
                ? [
                      "One or more mesh bounds are empty, degenerate, or non-finite.",
                  ]
                : []),
            ...(unitToMeters !== null && scaleToMeters === null
                ? [
                      "Invalid unit-to-meter conversion was ignored; supply a positive finite number.",
                  ]
                : []),
            ...(!configured
                ? [`Landmarks for category "${category}" are not-configured.`]
                : []),
        ],
        errors: [],
    };
}

export function createGLBFailureReport(url, error, options = {}) {
    const diagnostic = describeGLBLoadError(error);
    const {
        productId = null,
        category = null,
        expectedLandmarksByCategory = {},
        code = "glb-load-failed",
        failureStage = "load",
        assetMetadata = null,
    } = options;
    const configuredLandmarks = expectedLandmarksByCategory[category];
    const landmarksConfigured =
        Array.isArray(configuredLandmarks) && configuredLandmarks.length > 0;
    return {
        schemaVersion: 1,
        input: { url, productId: productId || null, category },
        status: {
            inspectionCompleted: false,
            failureStage,
            structuralValid: false,
            transformDataValid: false,
            meshBoundsValid: false,
            landmarksConfigured,
            landmarksComplete: false,
            landmarkLayoutValid: null,
            landmarkLayoutReason: null,
            eligibleForLandmarkAutoFit: false,
            note: "Asset inspection did not complete; no landmark scan was performed.",
        },
        units: {
            reportedCoordinates: "unavailable",
            physicalUnit: "unknown",
            projectConvention:
                "The fitting room treats its configured positions as meters; GLB physical units are not verified.",
            unitToMeters: null,
            convertedPositionUnit: null,
        },
        coordinateSystem: {
            format: "unknown",
            handedness: "unknown",
            upAxis: "unknown",
            forwardAxis: "unknown",
            source: "Asset could not be loaded for coordinate-system inspection",
        },
        unitStatus: {
            value: "unknown",
            source: "unverified",
            userConversion: null,
        },
        counts: {
            nodes: 0,
            meshes: 0,
            landmarks: {
                expected: landmarksConfigured ? configuredLandmarks.length : 0,
                found: 0,
                missing: 0,
                invalid: 0,
                duplicate: 0,
            },
        },
        bounds: boundsSummary(null),
        boundsMeters: null,
        meshBounds: [],
        nodes: [],
        landmarksConfigured: landmarksConfigured
            ? [...configuredLandmarks]
            : null,
        landmarks: [],
        measurements: [],
        coordinateSpaces: {
            nodeLocal: "unavailable",
            glbSceneWorld: "unavailable",
            fittingStageLocal: "unavailable",
        },
        hierarchyPolicy: {
            configured: false,
            note: "The project defines landmark names but no required parent or hierarchy path.",
        },
        fittingStage: {
            available: false,
            inverseWorldMatrix: null,
            worldMatrix: null,
        },
        autoFitReadiness: {
            status: "inspection-failed",
            ready: false,
            reason: "The GLB did not load or parse, so Auto-Fit readiness cannot be evaluated.",
            requiredLandmarks: landmarksConfigured
                ? [...configuredLandmarks]
                : [],
            missingLandmarks: [],
            invalidLandmarks: [],
            duplicateLandmarks: [],
            warnings: [],
        },
        warnings: [],
        errors: [{ code, ...diagnostic }],
    };
}

export function createGLBLoadError(url, error, options = {}) {
    return createGLBFailureReport(url, error, options);
}
export function createInspectionExport(report) {
    const completed = report?.status?.inspectionCompleted === true;
    return {
        ...report,
        success: completed,
        assetUrl: report?.input?.url ?? null,
        productId: report?.input?.productId ?? null,
        category: report?.input?.category ?? null,
        inspectionStatus: completed ? "completed" : "inspection-failed",
        autoFitReadiness: report?.autoFitReadiness || {
            status: "inspection-failed",
            ready: false,
            reason: "No completed inspection report is available.",
            warnings: [],
        },
        coordinateSystem: report?.coordinateSystem || {
            format: "unknown",
            handedness: "unknown",
            upAxis: "unknown",
            forwardAxis: "unknown",
        },
        unitStatus: report?.unitStatus || {
            value: report?.units?.physicalUnit || "unknown",
            source: "unverified",
        },
        nodeCount: report?.counts?.nodes ?? 0,
        meshCount: report?.counts?.meshes ?? 0,
        bounds: report?.bounds ?? boundsSummary(null),
        landmarks: report?.landmarks ?? [],
        warnings: report?.warnings ?? [],
        errors: report?.errors ?? [],
    };
}
