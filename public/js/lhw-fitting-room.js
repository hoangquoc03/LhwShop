import * as THREE from "three";
import { OrbitControls } from "three/addons/controls/OrbitControls.js";
import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";
import {
    selectLandmarkFit,
    solveLandmarkSimilarity as solveLandmarkSimilarityArrays,
} from "./lhw-landmark-solver.js";
import { validateLandmarkGeometry } from "./lhw-glb-inspector-core.js";

const viewer = document.getElementById("fittingViewer");
const status = document.getElementById("fittingStatus");
const debugPanel = document.getElementById("fittingDebug");
const config = window.LHW_FITTING_CONFIG;

if (!viewer || !config) {
    throw new Error("Thiếu fittingViewer hoặc LHW_FITTING_CONFIG.");
}

const catalogItemsContainer = document.getElementById("catalogItems");
const catalogSearchInput = document.getElementById("catalogSearch");
const catalogCategoryFilter = document.getElementById("catalogCategoryFilter");
const catalogSceneItemsContainer = document.getElementById("catalogSceneItems");
const catalogMessage = document.getElementById("catalogMessage");
const clearCatalogItemsButton = document.getElementById("clearCatalogItems");
const catalogSceneItems = new Map();
const catalogCategoryOverrides = new Map();
let catalogSequence = 0;

const CATALOG_CATEGORIES = [
    { value: "top", label: "Áo / áo khoác" },
    { value: "bottom", label: "Quần / váy" },
    { value: "shoes", label: "Giày" },
    { value: "hat", label: "Mũ / nón" },
    { value: "glasses", label: "Kính" },
    { value: "necklace", label: "Vòng cổ / dây chuyền" },
    { value: "scarf", label: "Khăn / phụ kiện cổ" },
    { value: "bag", label: "Túi / balo" },
    { value: "wrist", label: "Đồng hồ / vòng tay" },
    { value: "accessory", label: "Phụ kiện khác" },
    { value: "generic", label: "Mô hình rời / chưa phân loại" },
];
const CATALOG_CATEGORY_VALUES = new Set(CATALOG_CATEGORIES.map((item) => item.value));

const scene = new THREE.Scene();
scene.background = new THREE.Color(0x292a24);
const fittingStage = new THREE.Group();
fittingStage.name = "LHW fitting stage";
scene.add(fittingStage);

const camera = new THREE.PerspectiveCamera(
    35,
    viewer.clientWidth / viewer.clientHeight,
    0.01,
    100,
);

camera.position.set(0, 1.2, 3.6);

const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
renderer.setSize(viewer.clientWidth, viewer.clientHeight);
renderer.outputColorSpace = THREE.SRGBColorSpace;
renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 1.12;
viewer.appendChild(renderer.domElement);

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.target.set(0, 0.95, 0);

scene.add(new THREE.HemisphereLight(0xffffff, 0x777788, 2));

const keyLight = new THREE.DirectionalLight(0xffffff, 2.5);
keyLight.position.set(2, 4, 3);
scene.add(keyLight);

const floor = new THREE.GridHelper(4, 24, 0x9a7b5c, 0x655d50);
floor.position.y = 0;
scene.add(floor);

const loader = new GLTFLoader();

let avatar = null;
let avatarBones = {};
let avatarAnchors = {};
let avatarHeight = 1.765;
let avatarBox = null;
let isRotating = false;
let debugSelection = "top";
const productFitMetadata = new Map();
const productBaseTransforms = new Map();
const productHelpers = new Map();
const poseBaseline = new Map();
let anchorHelpers = [];
let avatarHelpers = null;
let applyingFittingPose = false;
let lastLiveDebugUpdate = 0;
let outfitLoadInProgress = false;
const debugVisibility = {
    bounds: false,
    axes: false,
    anchors: false,
};

const clothing = {
    top: null,
    bottom: null,
    shoes: null,
};

const PRODUCT_FIT_CONFIG = {};

function mergeProductFitConfig(base, override = {}) {
    const { parts: baseParts = {}, ...baseValues } = base;
    const { parts: overrideParts = {}, ...overrideValues } = override;
    const partDefaults = {
        ...baseValues,
        parts: {},
    };
    return {
        ...baseValues,
        ...overrideValues,
        positionOffset: [
            ...(overrideValues.positionOffset || baseValues.positionOffset),
        ],
        rotationOffset: [
            ...(overrideValues.rotationOffset || baseValues.rotationOffset),
        ],
        scaleMultiplier: [
            ...(overrideValues.scaleMultiplier || baseValues.scaleMultiplier),
        ],
        normalization: {
            ...baseValues.normalization,
            ...overrideValues.normalization,
        },
        parts: Object.fromEntries(
            Object.entries({
                ...baseParts,
                ...overrideParts,
            }).map(([part, partOverride]) => [
                part,
                mergeProductFitConfig(partDefaults, partOverride),
            ]),
        ),
    };
}

// Category defaults apply to every catalog item, regardless of its database ID.
// ID-specific overrides are optional and only used when explicitly configured.
const PRODUCT_FIT_CATEGORY_DEFAULTS = config.productFit?.defaults || {};
const PRODUCT_FIT_ID_OVERRIDES = config.productFit?.overrides || {};
const BASIC_FIT_CONFIG = {
    positionOffset: [0, 0, 0],
    rotationOffset: [0, 0, 0],
    scaleMultiplier: [1, 1, 1],
    normalization: { pivot: "bounds-center", scale: "axis" },
};

// Backwards compatibility: direct productFit entries like productFit["45"] still work.
for (const [productId, override] of Object.entries(config.productFit || {})) {
    if (["defaults", "overrides"].includes(productId)) continue;
    const fallback = PRODUCT_FIT_CONFIG[productId] || {
        ...BASIC_FIT_CONFIG,
        category: override.category || "generic",
    };
    PRODUCT_FIT_CONFIG[productId] = mergeProductFitConfig(fallback, override);
}
for (const [productId, override] of Object.entries(PRODUCT_FIT_ID_OVERRIDES)) {
    const fallback = PRODUCT_FIT_CONFIG[String(productId)] || BASIC_FIT_CONFIG;
    PRODUCT_FIT_CONFIG[String(productId)] = mergeProductFitConfig(fallback, override);
}

const PRODUCT_FIT_DEFAULTS = Object.fromEntries(
    Object.entries(PRODUCT_FIT_CONFIG).map(([productId, value]) => [
        productId,
        mergeProductFitConfig(value),
    ]),
);

const CATEGORY_BY_NAME = {
    top: "13",
    bottom: "17",
    shoes: "22",
};

const boneNames = {
    pelvis: ["mixamorig1Hips", "Hips"],
    spine: ["mixamorig1Spine", "Spine"],
    spine1: ["mixamorig1Spine1", "Spine1"],
    chest: ["mixamorig1Spine2", "Spine2", "Chest"],
    neck: ["mixamorig1Neck", "Neck"],
    shoulderLeft: ["mixamorig1LeftShoulder", "LeftShoulder"],
    shoulderRight: ["mixamorig1RightShoulder", "RightShoulder"],
    upperArmLeft: ["mixamorig1LeftArm", "LeftArm"],
    upperArmRight: ["mixamorig1RightArm", "RightArm"],
    upperLegLeft: ["mixamorig1LeftUpLeg", "LeftUpLeg"],
    upperLegRight: ["mixamorig1RightUpLeg", "RightUpLeg"],
    forearmLeft: ["mixamorig1LeftForeArm", "LeftForeArm"],
    forearmRight: ["mixamorig1RightForeArm", "RightForeArm"],
    handLeft: ["mixamorig1LeftHand", "LeftHand"],
    handRight: ["mixamorig1RightHand", "RightHand"],
    kneeLeft: ["mixamorig1LeftLeg", "LeftLeg"],
    kneeRight: ["mixamorig1RightLeg", "RightLeg"],
    ankleLeft: ["mixamorig1LeftFoot", "LeftFoot"],
    ankleRight: ["mixamorig1RightFoot", "RightFoot"],
    toeLeft: ["mixamorig1LeftToeBase", "LeftToeBase"],
    toeRight: ["mixamorig1RightToeBase", "RightToeBase"],
};

function setStatus(message) {
    status.textContent = message;
}

function loadGLB(url) {
    return new Promise((resolve, reject) => {
        loader.load(
            url,
            (gltf) => resolve(gltf.scene),
            undefined,
            (error) =>
                reject(
                    new Error(
                        `Không tải được ${url}: ${error.message || error}`,
                    ),
                ),
        );
    });
}

function collectBones(model) {
    avatarBones = {};

    model.traverse((object) => {
        if (object.isBone) {
            avatarBones[object.name] = object;
        }
    });
}

function findBone(logicalName) {
    const candidates = boneNames[logicalName] || [];

    for (const name of candidates) {
        if (avatarBones[name]) return avatarBones[name];
    }

    // Dự phòng tên bone có tiền tố/hậu tố khác.
    const normalizedNames = Object.keys(avatarBones);

    for (const candidate of candidates) {
        const found = normalizedNames.find((name) =>
            name.toLowerCase().endsWith(candidate.toLowerCase()),
        );

        if (found) return avatarBones[found];
    }

    return null;
}

function getBonePosition(logicalName) {
    const bone = findBone(logicalName);
    if (!bone) return null;

    const position = new THREE.Vector3();
    bone.getWorldPosition(position);
    return position;
}

function updateAnchors() {
    avatar.updateWorldMatrix(true, true);
    avatarAnchors = {};

    for (const name of Object.keys(boneNames)) {
        avatarAnchors[name] = getBonePosition(name);
    }
}

function capturePoseBaseline() {
    poseBaseline.clear();

    for (const bone of Object.values(avatarBones)) {
        poseBaseline.set(bone, bone.quaternion.clone());
    }
}

function applyFittingPose() {
    if (!avatar || poseBaseline.size === 0) return;

    for (const [bone, quaternion] of poseBaseline) {
        bone.quaternion.copy(quaternion);
    }

    avatar.updateWorldMatrix(true, true);

    const worldAxis = new THREE.Vector3(0, 0, 1);
    const angles = [
        ["upperArmLeft", -85],
        ["upperArmRight", 85],
    ];

    for (const [name, degrees] of angles) {
        const shoulder = findBone(name);

        if (!shoulder?.parent) {
            console.warn(
                `[LHW Fitting] Không tìm thấy bone ${name}; bỏ qua pose.`,
            );
            continue;
        }

        const parentWorldQuaternion = shoulder.parent.getWorldQuaternion(
            new THREE.Quaternion(),
        );
        const worldDelta = new THREE.Quaternion().setFromAxisAngle(
            worldAxis,
            THREE.MathUtils.degToRad(degrees),
        );
        const localDelta = parentWorldQuaternion
            .clone()
            .invert()
            .multiply(worldDelta)
            .multiply(parentWorldQuaternion);

        shoulder.quaternion.premultiply(localDelta);
    }

    applyingFittingPose = true;
    updateAvatarAfterPose();
}

function resetAvatarPose() {
    applyingFittingPose = false;

    for (const [bone, quaternion] of poseBaseline) {
        bone.quaternion.copy(quaternion);
    }

    updateAvatarAfterPose();
}

function updateAvatarAfterPose() {
    avatar.updateWorldMatrix(true, true);

    avatar.traverse((object) => {
        if (object.isSkinnedMesh && object.skeleton) {
            object.skeleton.update();
        }
    });

    updateAnchors();
    updateAnchorHelpers();
    updateAvatarHelpers();
    refreshAllGarments();
    updateDebugPanel();
}

function updateAnchorHelpers() {
    const visibleAnchors = [
        "pelvis",
        "chest",
        "shoulderLeft",
        "shoulderRight",
        "ankleLeft",
        "ankleRight",
        "toeLeft",
        "toeRight",
    ];

    while (anchorHelpers.length < visibleAnchors.length) {
        const marker = new THREE.Mesh(
            new THREE.SphereGeometry(0.012, 8, 6),
            new THREE.MeshBasicMaterial({ color: 0xff5533 }),
        );
        marker.name = "LHW fitting anchor";
        fittingStage.add(marker);
        anchorHelpers.push(marker);
    }

    visibleAnchors.forEach((name, index) => {
        const marker = anchorHelpers[index];
        const position = avatarAnchors[name];
        marker.visible = debugVisibility.anchors && Boolean(position);

        if (position) {
            marker.position.copy(fittingStage.worldToLocal(position.clone()));
        }
    });
}

function updateAvatarHelpers() {
    if (!avatar) return;

    const bounds = computeModelBounds(avatar);
    if (!avatarHelpers) {
        avatarHelpers = {
            axes: new THREE.AxesHelper(0.3),
            bounds: new THREE.Box3Helper(bounds.box.clone(), 0x33aaff),
        };
        avatarHelpers.axes.name = "LHW avatar axes";
        avatarHelpers.bounds.name = "LHW avatar bounds";
        scene.add(avatarHelpers.axes, avatarHelpers.bounds);
    }

    avatarHelpers.bounds.box.copy(bounds.box);
    avatarHelpers.bounds.updateMatrixWorld(true);
    avatar.updateWorldMatrix(true, true);
    avatar.getWorldPosition(avatarHelpers.axes.position);
    avatar.getWorldQuaternion(avatarHelpers.axes.quaternion);
    const isSelected = debugSelection === "avatar";
    avatarHelpers.axes.visible = isSelected && debugVisibility.axes;
    avatarHelpers.bounds.visible = isSelected && debugVisibility.bounds;
}

function centerModelAtOrigin(model) {
    model.updateWorldMatrix(true, true);

    const box = new THREE.Box3().setFromObject(model);
    const center = box.getCenter(new THREE.Vector3());

    model.position.x -= center.x;
    model.position.z -= center.z;
    model.position.y -= box.min.y;

    model.updateWorldMatrix(true, true);
}

function calculateAvatarSize() {
    avatar.updateWorldMatrix(true, true);

    avatarBox = new THREE.Box3().setFromObject(avatar);
    const size = avatarBox.getSize(new THREE.Vector3());

    avatarHeight = size.y;

    if (!Number.isFinite(avatarHeight) || avatarHeight <= 0) {
        throw new Error("Chiều cao avatar không hợp lệ.");
    }
}

async function loadAvatar() {
    setStatus("Đang tải avatar...");

    avatar = await loadGLB(config.avatarUrl);
    centerModelAtOrigin(avatar);

    fittingStage.add(avatar);

    collectBones(avatar);
    capturePoseBaseline();
    calculateAvatarSize();
    applyFittingPose();
    updateAnchors();

    camera.position.set(0, avatarHeight * 0.68, avatarHeight * 2.2);
    setCameraView("front");
    updateAnchorHelpers();
    updateDebugPanel();

    // Studio mode: retain avatar measurements/bones for fitting, but hide the avatar render.
    avatar.visible = config.viewer?.showAvatar === true;

    console.log("LHW fitting avatar height:", avatarHeight);
    console.log("LHW fitting anchors:", avatarAnchors);
}

// Ước lượng vùng đặt trang phục.
// Đây là thông số thử nghiệm, không phải số đo cơ thể chính xác.
function getTargetForCategory(category) {
    const pelvis = avatarAnchors.pelvis;
    const ankleL = avatarAnchors.ankleLeft;
    const ankleR = avatarAnchors.ankleRight;

    if (category === "top") {
        const shoulderLeft = avatarAnchors.shoulderLeft;
        const shoulderRight = avatarAnchors.shoulderRight;

        const shoulderY =
            ((shoulderLeft?.y ?? avatarHeight * 0.82) +
                (shoulderRight?.y ?? avatarHeight * 0.82)) /
            2;

        const pelvisY = pelvis?.y ?? avatarHeight * 0.56;
        // Keep the shirt hem near the pelvis instead of extending into the trousers.
        // The target follows the shoulder-to-waist interval, with a small ease allowance.
        const topHeight = Math.max(shoulderY - pelvisY, avatarHeight * 0.18);
        const target = {
            center: new THREE.Vector3(0, (shoulderY + pelvisY) / 2 + avatarHeight * 0.012, 0.045),
            size: new THREE.Vector3(
                avatarHeight * 0.33,
                topHeight * 1.02,
                avatarHeight * 0.17,
            ),
        };

        console.log("[LHW] Top target:", {
            center: target.center,
            size: target.size,
        });

        return target;
    }

    if (category === "bottom") {
        const pelvisY = pelvis?.y ?? avatarHeight * 0.56;
        const ankleY = ((ankleL?.y ?? 0.08) + (ankleR?.y ?? 0.08)) / 2;

        // Align the waistband with the pelvis and keep the hem above the shoes.
        const legLength = Math.max(pelvisY - ankleY, avatarHeight * 0.25);
        const target = {
            center: new THREE.Vector3(0, (pelvisY + ankleY) / 2 - avatarHeight * 0.006, 0),
            size: new THREE.Vector3(
                avatarHeight * 0.27,
                legLength * 0.99,
                avatarHeight * 0.16,
            ),
        };

        console.log("[LHW] Bottom target:", {
            center: target.center,
            size: target.size,
        });

        return target;
    }

    if (category === "shoes") {
        const leftToe = avatarAnchors.toeLeft;
        const rightToe = avatarAnchors.toeRight;
        const leftAnkle = avatarAnchors.ankleLeft;
        const rightAnkle = avatarAnchors.ankleRight;

        if (!leftToe || !rightToe || !leftAnkle || !rightAnkle) {
            throw new Error("Không tìm thấy anchors bàn chân.");
        }

        const ankleCenter = leftAnkle
            .clone()
            .add(rightAnkle)
            .multiplyScalar(0.5);

        const toeCenter = leftToe.clone().add(rightToe).multiplyScalar(0.5);

        const averageFootLength =
            (leftAnkle.distanceTo(leftToe) + rightAnkle.distanceTo(rightToe)) /
            2;

        const footSpan = Math.abs(leftToe.x - rightToe.x);

        return {
            center: new THREE.Vector3(
                (ankleCenter.x + toeCenter.x) / 2,
                0.035,
                (ankleCenter.z + toeCenter.z) / 2,
            ),
            size: new THREE.Vector3(
                footSpan * 1.04,
                avatarHeight * 0.035,
                averageFootLength * 1.2,
            ),
        };
    }

    throw new Error(`Loại trang phục không hợp lệ: ${category}`);
}

function getTargetForShoeFoot(side) {
    const ankle = avatarAnchors[side === "left" ? "ankleLeft" : "ankleRight"];
    const toe = avatarAnchors[side === "left" ? "toeLeft" : "toeRight"];
    if (!ankle || !toe) {
        throw new Error(`Không tìm thấy anchors bàn chân ${side}.`);
    }

    const footLength = ankle.distanceTo(toe);
    // Give the shoe enough room in all dimensions; uniform-contain preserves its shape.
    // A minimum target size also helps GLBs exported at unusually small scales.
    const shoeHeight = avatarHeight * 0.085;
    const shoeWidth = Math.max(avatarHeight * 0.105, footLength * 0.52);
    const shoeLength = Math.max(footLength * 2.05, avatarHeight * 0.205);

    return {
        center: new THREE.Vector3(
            (ankle.x + toe.x) / 2,
            shoeHeight / 2,
            (ankle.z + toe.z) / 2,
        ),
        size: new THREE.Vector3(shoeWidth, shoeHeight, shoeLength),
    };
}

function removeClothing(category) {
    const oldModel = clothing[category];
    const oldProductId =
        productFitMetadata.get(category)?.productId ||
        CATEGORY_BY_NAME[category];

    if (oldModel) {
        fittingStage.remove(oldModel);

        oldModel.traverse((object) => {
            if (!object.isMesh) return;

            object.geometry?.dispose();

            if (Array.isArray(object.material)) {
                object.material.forEach((material) => material.dispose());
            } else {
                object.material?.dispose();
            }
        });

        clothing[category] = null;
    }

    const helpers = productHelpers.get(category);
    if (helpers) {
        scene.remove(helpers.axes, helpers.bounds);
        for (const helper of [helpers.axes, helpers.bounds]) {
            helper.geometry.dispose();
            if (Array.isArray(helper.material)) {
                helper.material.forEach((material) => material.dispose());
            } else {
                helper.material.dispose();
            }
        }
        productHelpers.delete(category);
    }

    productFitMetadata.delete(category);
    for (const key of productBaseTransforms.keys()) {
        if (key === oldProductId || key.startsWith(`${oldProductId}:`)) {
            productBaseTransforms.delete(key);
        }
    }
}

function computeModelBounds(model) {
    model.updateWorldMatrix(true, true);
    const box = new THREE.Box3().setFromObject(model);
    const size = box.getSize(new THREE.Vector3());
    const center = box.getCenter(new THREE.Vector3());

    return {
        box,
        size,
        center,
        min: box.min.clone(),
        max: box.max.clone(),
    };
}

function translateRootByWorldDelta(model, worldDelta) {
    if (!model.parent) {
        model.position.add(worldDelta);
        return;
    }

    model.parent.updateWorldMatrix(true, false);
    const parentWorldOrigin = new THREE.Vector3().setFromMatrixPosition(
        model.parent.matrixWorld,
    );
    const localDelta = model.parent
        .worldToLocal(parentWorldOrigin.clone().add(worldDelta))
        .sub(model.parent.worldToLocal(parentWorldOrigin));

    model.position.add(localDelta);
}

function getProductFitConfig(productId, category) {
    const key = String(productId);
    if (!PRODUCT_FIT_CONFIG[key]) {
        const categoryDefaults = PRODUCT_FIT_CATEGORY_DEFAULTS[category] || {};
        const idOverride = PRODUCT_FIT_ID_OVERRIDES[key] || {};
        PRODUCT_FIT_CONFIG[key] = mergeProductFitConfig(
            mergeProductFitConfig({ ...BASIC_FIT_CONFIG, category }, categoryDefaults),
            idOverride,
        );
    }
    return PRODUCT_FIT_CONFIG[key];
}

function fitModelToTarget(
    model,
    target,
    productId,
    category,
    sourceBounds,
    part = null,
) {
    const productKey = String(productId);
    const productConfig = getProductFitConfig(productKey, category);
    const configForProduct = part
        ? mergeProductFitConfig(productConfig, productConfig.parts?.[part])
        : productConfig;
    const baseTransform = productBaseTransforms.get(
        part ? `${productKey}:${part}` : productKey,
    );

    if (!baseTransform) {
        throw new Error(`Thiếu transform gốc cho sản phẩm ${productKey}.`);
    }

    model.position.copy(baseTransform.position);
    model.quaternion.copy(baseTransform.quaternion);
    model.scale.copy(baseTransform.scale);

    const rotationOffset = new THREE.Euler(
        ...configForProduct.rotationOffset.map(THREE.MathUtils.degToRad),
        "XYZ",
    );
    model.quaternion.multiply(
        new THREE.Quaternion().setFromEuler(rotationOffset),
    );

    model.updateWorldMatrix(true, true);
    const orientedBounds = computeModelBounds(model);
    const rawBounds = sourceBounds || orientedBounds;
    const rawRootTransform = {
        position: baseTransform.position.clone(),
        rotation: new THREE.Euler().setFromQuaternion(baseTransform.quaternion),
        quaternion: baseTransform.quaternion.clone(),
        scale: baseTransform.scale.clone(),
    };
    const meshSummary = [];
    model.traverse((object) => {
        if (!object.isMesh) return;

        meshSummary.push({
            name: object.name || "(unnamed)",
            vertices: object.geometry.attributes.position?.count || 0,
            indices: object.geometry.index?.count || 0,
            triangles: Math.floor(
                (object.geometry.index?.count ||
                    object.geometry.attributes.position?.count ||
                    0) / 3,
            ),
            localPosition: object.position.clone(),
            localRotation: object.rotation.clone(),
            localScale: object.scale.clone(),
            materials: (Array.isArray(object.material)
                ? object.material
                : [object.material]
            )
                .filter(Boolean)
                .map((material) => ({
                    name: material.name || "(unnamed)",
                    type: material.type,
                    side: material.side,
                    transparent: material.transparent,
                    opacity: material.opacity,
                    alphaTest: material.alphaTest,
                    depthWrite: material.depthWrite,
                    hasMap: Boolean(material.map),
                    hasAlphaMap: Boolean(material.alphaMap),
                    hasNormalMap: Boolean(material.normalMap),
                })),
        });
    });

    const normalization = {
        pivot: "bounds-center",
        scale: "axis",
        ...configForProduct.normalization,
    };
    let normalizationPoint = new THREE.Vector3();
    if (normalization.pivot === "bounds-center") {
        normalizationPoint.copy(orientedBounds.center);
    } else if (normalization.pivot === "ground") {
        normalizationPoint.set(
            orientedBounds.center.x,
            orientedBounds.min.y,
            orientedBounds.center.z,
        );
    } else if (normalization.pivot !== "none") {
        throw new Error(
            `Quy tắc pivot normalization không hỗ trợ: ${normalization.pivot}`,
        );
    }
    translateRootByWorldDelta(model, normalizationPoint.negate());
    model.updateWorldMatrix(true, true);

    const normalizedBounds = computeModelBounds(model);
    const normalizedSize = normalizedBounds.size.clone();

    if (
        normalizedBounds.box.isEmpty() ||
        normalizedSize.x <= 0 ||
        normalizedSize.y <= 0 ||
        normalizedSize.z <= 0
    ) {
        throw new Error("Bounding box sản phẩm không hợp lệ.");
    }

    const targetSize = target.size.clone();
    if (
        ![target.center.x, target.center.y, target.center.z].every(
            Number.isFinite,
        ) ||
        ![targetSize.x, targetSize.y, targetSize.z].every(
            (value) => Number.isFinite(value) && value > 0,
        ) ||
        !configForProduct.scaleMultiplier.every(
            (value) => Number.isFinite(value) && value > 0,
        )
    ) {
        throw new Error("Mục tiêu hoặc cấu hình scale fitting không hợp lệ.");
    }
    const axisScale = new THREE.Vector3(
        (targetSize.x / normalizedSize.x) * configForProduct.scaleMultiplier[0],
        (targetSize.y / normalizedSize.y) * configForProduct.scaleMultiplier[1],
        (targetSize.z / normalizedSize.z) * configForProduct.scaleMultiplier[2],
    );
    let scaleFactor = axisScale;
    if (normalization.scale === "uniform-contain") {
        const uniformScale = Math.min(axisScale.x, axisScale.y, axisScale.z);
        scaleFactor = new THREE.Vector3(
            uniformScale,
            uniformScale,
            uniformScale,
        );
    } else if (normalization.scale !== "axis") {
        throw new Error(
            `Quy tắc scale normalization không hỗ trợ: ${normalization.scale}`,
        );
    }

    model.scale.multiply(scaleFactor);
    model.updateWorldMatrix(true, true);

    const scaledBounds = computeModelBounds(model);
    const requestedOffset = new THREE.Vector3(
        ...configForProduct.positionOffset,
    );
    const desiredCenter = target.center.clone().add(requestedOffset);

    translateRootByWorldDelta(
        model,
        desiredCenter.clone().sub(scaledBounds.center),
    );
    model.updateWorldMatrix(true, true);

    const actualBounds = computeModelBounds(model);
    const centerError = actualBounds.center.clone().sub(desiredCenter);
    if (
        !isUsableBounds(actualBounds) ||
        ![centerError.x, centerError.y, centerError.z].every(Number.isFinite) ||
        ![scaleFactor.x, scaleFactor.y, scaleFactor.z].every(
            (value) => Number.isFinite(value) && value > 0,
        )
    ) {
        throw new Error("Kết quả fitting bounds không hợp lệ.");
    }

    return {
        productId: productKey,
        category,
        config: configForProduct,
        rawRootTransform,
        rawBounds,
        orientedBounds,
        meshSummary,
        normalizedBounds,
        target: {
            center: target.center.clone(),
            size: target.size.clone(),
        },
        targetLocalCenter: fittingStage.worldToLocal(target.center.clone()),
        desiredLocalCenter: fittingStage.worldToLocal(desiredCenter.clone()),
        actualBounds,
        centerError,
        normalization,
        scaleFactor,
        fitValidation: {
            valid: isUsableBounds(actualBounds),
            method: "legacy-bounds",
            note: "Bounds and transforms were checked; visual fit is not validated.",
            preFitBounds: rawBounds,
            postFitBounds: actualBounds,
        },
        rootTransform: {
            position: model.position.clone(),
            rotation: model.rotation.clone(),
            quaternion: model.quaternion.clone(),
            scale: model.scale.clone(),
        },
    };
}

function combineBounds(boundsList) {
    const box = new THREE.Box3();
    for (const bounds of boundsList) {
        box.union(bounds.box);
    }
    return {
        box,
        size: box.getSize(new THREE.Vector3()),
        center: box.getCenter(new THREE.Vector3()),
        min: box.min.clone(),
        max: box.max.clone(),
    };
}

function makeShoePairReport(group, productId, parts, warnings) {
    const partReports = parts.map((part) => part.report);
    const actualBounds = computeModelBounds(group);
    const targetBounds = combineBounds(
        partReports.map((report) => {
            const half = report.target.size.clone().multiplyScalar(0.5);
            return {
                box: new THREE.Box3(
                    report.target.center.clone().sub(half),
                    report.target.center.clone().add(half),
                ),
            };
        }),
    );
    const rawBounds = combineBounds(
        partReports.map((report) => report.rawBounds),
    );
    const orientedBounds = combineBounds(
        partReports.map((report) => report.orientedBounds),
    );
    const normalizedBounds = combineBounds(
        partReports.map((report) => report.normalizedBounds),
    );
    const targetLocalCenter = fittingStage.worldToLocal(
        targetBounds.center.clone(),
    );

    group.updateWorldMatrix(true, true);
    const firstReport = partReports[0];
    return {
        productId: String(productId),
        category: "shoes",
        config: getProductFitConfig(String(productId), "shoes"),
        fitMethod: "legacy-bounds",
        sourceUrls: parts.map(({ side, url }) => ({ side, url })),
        isShoePair: true,
        parts,
        warnings,
        rawRootTransform: firstReport.rawRootTransform,
        rawBounds,
        orientedBounds,
        normalizedBounds,
        meshSummary: partReports.flatMap((report, index) =>
            report.meshSummary.map((mesh) => ({
                ...mesh,
                name: `${parts[index].side}: ${mesh.name}`,
            })),
        ),
        target: {
            center: targetBounds.center,
            size: targetBounds.size,
        },
        targetLocalCenter,
        desiredLocalCenter: targetLocalCenter.clone(),
        actualBounds,
        centerError: actualBounds.center.clone().sub(targetBounds.center),
        normalization: firstReport.normalization,
        fitValidation: {
            valid:
                isUsableBounds(actualBounds) &&
                partReports.every(
                    (report) => report.fitValidation?.valid === true,
                ),
            method: "legacy-bounds",
            note: "Bounds checks only; shoe fit and foot orientation are not visually validated.",
            preFitBounds: rawBounds,
            postFitBounds: actualBounds,
        },
        rootTransform: {
            position: group.position.clone(),
            rotation: group.rotation.clone(),
            quaternion: group.quaternion.clone(),
            scale: group.scale.clone(),
        },
    };
}

function fitLoadedShoePair(group, productId, previousReport, warnings) {
    const parts = previousReport.parts.map((part) => ({
        ...part,
        report: fitModelToTarget(
            part.model,
            getTargetForShoeFoot(part.side),
            productId,
            "shoes",
            part.sourceBounds,
            part.side,
        ),
    }));
    return makeShoePairReport(group, productId, parts, warnings);
}

function formatVector(vector, digits = 3) {
    if (!vector) return "n/a";
    return [vector.x, vector.y, vector.z]
        .map((value) => Number(value).toFixed(digits))
        .join(", ");
}

function appendDebugLine(parent, label, value) {
    const line = document.createElement("div");
    const title = document.createElement("strong");
    title.textContent = `${label}: `;
    line.append(title, document.createTextNode(value));
    parent.appendChild(line);
}

function appendBoundsDebug(parent, label, bounds) {
    appendDebugLine(parent, `${label} min`, formatVector(bounds.min));
    appendDebugLine(parent, `${label} max`, formatVector(bounds.max));
    appendDebugLine(parent, `${label} center`, formatVector(bounds.center));
    appendDebugLine(parent, `${label} size`, formatVector(bounds.size));
}

function appendWarning(parent, message) {
    const warning = document.createElement("p");
    warning.className = "fitting-warning";
    warning.setAttribute("role", "alert");
    warning.textContent = message;
    parent.appendChild(warning);
}

function createVectorEditor(parent, label, values, step, onChange) {
    const row = document.createElement("label");
    row.className = "debug-vector";

    const title = document.createElement("span");
    title.textContent = label;
    row.appendChild(title);

    ["X", "Y", "Z"].forEach((axis, index) => {
        const input = document.createElement("input");
        input.type = "number";
        input.step = String(step);
        input.value = Number(values[index]).toFixed(3);
        input.setAttribute("aria-label", `${label} ${axis}`);
        input.addEventListener("change", () => {
            const next = [0, 1, 2].map((i) =>
                Number(row.querySelectorAll("input")[i].value),
            );

            if (!next.every(Number.isFinite)) return;
            onChange(next);
        });
        row.appendChild(input);
    });

    parent.appendChild(row);
}

function createSelectEditor(parent, label, values, value, onChange) {
    const row = document.createElement("label");
    row.className = "debug-vector";
    const title = document.createElement("span");
    title.textContent = label;
    const select = document.createElement("select");
    select.setAttribute("aria-label", label);
    for (const [optionValue, optionLabel] of values) {
        const option = document.createElement("option");
        option.value = optionValue;
        option.textContent = optionLabel;
        select.appendChild(option);
    }
    select.value = value;
    select.addEventListener("change", () => onChange(select.value));
    row.append(title, select);
    parent.appendChild(row);
}

function appendProductFitEditors(
    parent,
    fitConfig,
    category,
    labelPrefix = "",
) {
    const apply = () => applyProductConfig(category);
    createVectorEditor(
        parent,
        `${labelPrefix}Position offset (m)`,
        fitConfig.positionOffset,
        0.005,
        (value) => {
            fitConfig.positionOffset = value;
            apply();
        },
    );
    createVectorEditor(
        parent,
        `${labelPrefix}Rotation offset (deg)`,
        fitConfig.rotationOffset,
        1,
        (value) => {
            fitConfig.rotationOffset = value;
            apply();
        },
    );
    createVectorEditor(
        parent,
        `${labelPrefix}Scale multiplier`,
        fitConfig.scaleMultiplier,
        0.01,
        (value) => {
            if (value.some((number) => number <= 0)) return;
            fitConfig.scaleMultiplier = value;
            apply();
        },
    );
    createSelectEditor(
        parent,
        `${labelPrefix}Normalization pivot`,
        [
            ["bounds-center", "Bounds center"],
            ["ground", "Ground"],
            ["none", "None"],
        ],
        fitConfig.normalization.pivot,
        (value) => {
            fitConfig.normalization.pivot = value;
            apply();
        },
    );
    createSelectEditor(
        parent,
        `${labelPrefix}Normalization scale`,
        [
            ["axis", "Per axis"],
            ["uniform-contain", "Uniform contain"],
        ],
        fitConfig.normalization.scale,
        (value) => {
            fitConfig.normalization.scale = value;
            apply();
        },
    );
}

function applyProductConfig(category) {
    const productId = CATEGORY_BY_NAME[category];
    const model = clothing[category];
    const metadata = productFitMetadata.get(category);

    if (!model || !metadata) return;

    isRotating = false;
    fittingStage.rotation.y = 0;
    fittingStage.updateWorldMatrix(true, true);
    updateAnchors();
    updateAnchorHelpers();
    let report;
    if (metadata.isShoePair) {
        report = fitLoadedShoePair(
            model,
            metadata.productId,
            metadata,
            metadata.warnings,
        );
    } else {
        const target = getTargetForCategory(category);
        const autoFitEnabled = isLandmarkAutoFitEnabledForProduct(productId);
        if (autoFitEnabled) {
            const landmarkResult = fitModelFromLandmarksIfAvailable(
                model,
                target,
                metadata.productId || productId,
                category,
                metadata.rawBounds,
            );
            const selection = selectLandmarkFit(landmarkResult, () =>
                fitModelToTarget(
                    model,
                    target,
                    metadata.productId || productId,
                    category,
                    metadata.rawBounds,
                ),
            );
            report = selection.report;
            if (selection.method === "legacy-bounds") {
                report.fitMethod = selection.method;
                report.autoFitFallbackReason = selection.reason;
                report.landmarkDiagnostic = landmarkResult.diagnostic || null;
                report.autoFitAttempt = {
                    valid: false,
                    reason: selection.reason,
                };
            }
        } else {
            report = fitModelToTarget(
                model,
                target,
                metadata.productId || productId,
                category,
                metadata.rawBounds,
            );
            report.fitMethod = "legacy-bounds";
        }
    }
    report.warnings = metadata.warnings || [];
    if (metadata.sourceUrl) report.sourceUrl = metadata.sourceUrl;
    productFitMetadata.set(category, report);
    updateProductHelpers(category, report.actualBounds);
    updateDebugPanel();
}

function updateProductHelpers(category, bounds) {
    let helpers = productHelpers.get(category);

    if (!helpers) {
        helpers = {
            axes: new THREE.AxesHelper(0.2),
            bounds: new THREE.Box3Helper(bounds.box.clone(), 0xffbb33),
        };
        helpers.axes.name = `LHW ${category} axes`;
        helpers.bounds.name = `LHW ${category} bounds`;
        scene.add(helpers.axes, helpers.bounds);
        productHelpers.set(category, helpers);
    }

    helpers.bounds.box.copy(bounds.box);
    helpers.bounds.updateMatrixWorld(true);

    const model = clothing[category];
    if (model) {
        model.updateWorldMatrix(true, true);
        model.getWorldPosition(helpers.axes.position);
        model.getWorldQuaternion(helpers.axes.quaternion);
    }

    const isSelected = debugSelection === category;
    helpers.axes.visible = isSelected && debugVisibility.axes;
    helpers.bounds.visible = isSelected && debugVisibility.bounds;
}

function refreshAllGarments() {
    for (const category of Object.keys(clothing)) {
        if (clothing[category] && productFitMetadata.has(category)) {
            applyProductConfig(category);
        }
    }
}

function updateDebugPanel() {
    if (!debugPanel) return;

    updateAvatarHelpers();
    debugPanel.replaceChildren();

    const heading = document.createElement("h2");
    heading.textContent = "Debug căn chỉnh 3D";
    debugPanel.appendChild(heading);

    const selectionLabel = document.createElement("label");
    selectionLabel.textContent = "Đối tượng ";
    const selection = document.createElement("select");
    [
        ["avatar", "Avatar"],
        ["top", "Top 13"],
        ["bottom", "Bottom 17"],
        ["shoes", "Shoes 22"],
    ].forEach(([value, label]) => {
        const option = document.createElement("option");
        option.value = value;
        option.textContent = label;
        selection.appendChild(option);
    });
    selection.value = debugSelection;
    selection.addEventListener("change", () => {
        debugSelection = selection.value;
        for (const category of Object.keys(clothing)) {
            const report = productFitMetadata.get(category);
            if (report) updateProductHelpers(category, report.actualBounds);
        }
        updateDebugPanel();
    });
    selectionLabel.appendChild(selection);
    debugPanel.appendChild(selectionLabel);
    appendDebugDisplayControls(debugPanel);

    if (debugSelection === "avatar" && avatar) {
        avatar.updateWorldMatrix(true, true);
        const bounds = computeModelBounds(avatar);
        appendDebugLine(
            debugPanel,
            "Avatar height",
            `${avatarHeight.toFixed(3)} m`,
        );
        appendDebugLine(
            debugPanel,
            "World center",
            formatVector(bounds.center),
        );
        appendDebugLine(debugPanel, "World size", formatVector(bounds.size));
        appendDebugLine(
            debugPanel,
            "Root position",
            formatVector(avatar.position),
        );
        appendDebugLine(
            debugPanel,
            "Root rotation (deg)",
            formatVector(
                new THREE.Vector3(
                    THREE.MathUtils.radToDeg(avatar.rotation.x),
                    THREE.MathUtils.radToDeg(avatar.rotation.y),
                    THREE.MathUtils.radToDeg(avatar.rotation.z),
                ),
            ),
        );
        appendDebugLine(debugPanel, "Root scale", formatVector(avatar.scale));
        appendDebugLine(
            debugPanel,
            "Pose preset",
            applyingFittingPose ? "Fitting pose" : "Original",
        );

        const anchors = document.createElement("div");
        anchors.className = "debug-anchors";
        for (const name of [
            "pelvis",
            "chest",
            "shoulderLeft",
            "shoulderRight",
            "ankleLeft",
            "ankleRight",
            "toeLeft",
            "toeRight",
        ]) {
            appendDebugLine(anchors, name, formatVector(avatarAnchors[name]));
        }
        debugPanel.appendChild(anchors);
        appendPoseButtons(debugPanel);
        return;
    }

    const category = debugSelection;
    const report = productFitMetadata.get(category);
    if (!report) {
        const productId = config.outfit?.[category];
        if (productId === null || productId === undefined || productId === "") {
            appendDebugLine(debugPanel, "Trạng thái", "Chưa chọn sản phẩm.");
            return;
        }

        const assets = getProductAssets(productId);
        const warnings = getProductWarnings(productId, assets);
        appendDebugLine(debugPanel, "Product ID", productId);
        appendDebugLine(debugPanel, "Asset URL", assets.modelUrl);
        appendDebugLine(
            debugPanel,
            "Trạng thái tải model",
            category === "shoes" && config.features?.renderShoes3D !== true
                ? "Bỏ qua theo cấu hình MVP; không gửi request GLB."
                : assets.render3D
                  ? "Chưa tải hoặc chưa có model đang hoạt động."
                  : "Không render asset theo chính sách chất lượng.",
        );
        appendDebugLine(
            debugPanel,
            "Chất lượng asset",
            assets.qualityStatus === "known-incomplete-geometry"
                ? "Đã xác nhận có geometry chưa hoàn chỉnh."
                : assets.qualityStatus === "pending-review"
                  ? "Asset 3D đang được hoàn thiện."
                  : "Chưa được xác minh độc lập.",
        );
        appendDebugLine(
            debugPanel,
            "Độ vừa / che phủ",
            "Chưa xác nhận bằng kiểm tra trực quan.",
        );
        for (const warning of warnings) appendWarning(debugPanel, warning);
        return;
    }

    fittingStage.updateWorldMatrix(true, false);
    const actual = computeModelBounds(clothing[category]);
    const liveTargetCenter = report.targetLocalCenter
        .clone()
        .applyMatrix4(fittingStage.matrixWorld);
    const halfTargetSize = report.target.size.clone().multiplyScalar(0.5);
    const liveTargetBox = new THREE.Box3(
        report.targetLocalCenter.clone().sub(halfTargetSize),
        report.targetLocalCenter.clone().add(halfTargetSize),
    ).applyMatrix4(fittingStage.matrixWorld);
    const liveTargetSize = liveTargetBox.getSize(new THREE.Vector3());
    const targetDelta = actual.center.clone().sub(liveTargetCenter);
    const root = report.rootTransform;
    appendDebugLine(debugPanel, "Product ID", report.productId);
    appendDebugLine(
        debugPanel,
        "Asset URL(s)",
        (report.sourceUrls || [{ url: report.sourceUrl }])
            .map((asset) => asset.url)
            .filter(Boolean)
            .join(" | "),
    );
    appendDebugLine(
        debugPanel,
        "Raw root position",
        formatVector(report.rawRootTransform.position),
    );
    appendDebugLine(
        debugPanel,
        "Raw root rotation (deg)",
        formatEulerDegrees(report.rawRootTransform.rotation),
    );
    appendDebugLine(
        debugPanel,
        "Raw root scale",
        formatVector(report.rawRootTransform.scale),
    );
    appendBoundsDebug(debugPanel, "Raw bounds", report.rawBounds);
    appendBoundsDebug(
        debugPanel,
        "Bounds after local rotation",
        report.orientedBounds,
    );
    appendDebugLine(
        debugPanel,
        "GLB mesh count",
        String(report.meshSummary.length),
    );
    for (const mesh of report.meshSummary) {
        appendDebugLine(
            debugPanel,
            `Mesh ${mesh.name}`,
            `${mesh.vertices} vertices; ${mesh.triangles} triangles; child rotation ${formatEulerDegrees(mesh.localRotation)}°`,
        );
        for (const material of mesh.materials) {
            appendDebugLine(
                debugPanel,
                `Material ${material.name}`,
                `${material.type}; side=${material.side === THREE.DoubleSide ? "DoubleSide" : material.side}; transparent=${material.transparent}; opacity=${material.opacity}; alphaTest=${material.alphaTest}; depthWrite=${material.depthWrite}; map=${material.hasMap}; alphaMap=${material.hasAlphaMap}; normalMap=${material.hasNormalMap}`,
            );
        }
    }
    appendBoundsDebug(debugPanel, "Normalized bounds", report.normalizedBounds);
    appendBoundsDebug(debugPanel, "Target bounds (world)", {
        min: liveTargetBox.min,
        max: liveTargetBox.max,
        center: liveTargetCenter,
        size: liveTargetSize,
    });
    appendDebugLine(
        debugPanel,
        "Fit method",
        report.fitMethod || "legacy-bounds",
    );
    if (report.autoFitFallbackReason) {
        appendDebugLine(
            debugPanel,
            "Auto-Fit fallback reason",
            report.autoFitFallbackReason,
        );
    }
    if (report.landmarkReport) {
        appendDebugLine(
            debugPanel,
            "Landmarks found / required",
            `${report.landmarkReport.found.length} / ${report.landmarkReport.required.length}`,
        );
        appendDebugLine(
            debugPanel,
            "Landmarks missing",
            report.landmarkReport.missing.join(", ") || "none",
        );
        appendDebugLine(
            debugPanel,
            "Landmark RMS error",
            `${report.landmarkReport.rmsError.toFixed(4)} m`,
        );
        appendDebugLine(
            debugPanel,
            "Solver landmark RMS before applying",
            `${report.landmarkReport.preFitRmsError.toFixed(4)} m`,
        );
        appendDebugLine(
            debugPanel,
            "Landmark transform space",
            report.landmarkReport.transform.coordinateSpace,
        );
        appendDebugLine(
            debugPanel,
            "Landmark solver scale",
            report.landmarkReport.transform.scale.toFixed(6),
        );
        appendDebugLine(
            debugPanel,
            "Landmark solver rotation (deg)",
            formatEulerDegrees(
                new THREE.Euler().setFromQuaternion(
                    report.landmarkReport.transform.rotation,
                ),
            ),
        );
        appendDebugLine(
            debugPanel,
            "Landmark solver rotation (quaternion)",
            report.landmarkReport.transform.rotation
                .toArray()
                .map((value) => value.toFixed(6))
                .join(", "),
        );
        appendDebugLine(
            debugPanel,
            "Landmark solver translation (stage-local)",
            `${formatVector(report.landmarkReport.transform.translation)} m`,
        );
        appendDebugLine(
            debugPanel,
            "Estimated avatar anchors",
            report.landmarkReport.estimatedAvatarAnchors.join(", ") || "none",
        );
        for (const landmark of report.landmarkReport.pairs) {
            appendDebugLine(
                debugPanel,
                `Landmark ${landmark.name}`,
                `post-fit ${landmark.error.toFixed(4)} m; solver residual ${landmark.solverError.toFixed(4)} m${landmark.estimated ? " (avatar anchor estimated)" : ""}`,
            );
        }
    } else if (report.landmarkDiagnostic) {
        appendDebugLine(
            debugPanel,
            "Garment landmark nodes found",
            report.landmarkDiagnostic.required
                .filter(
                    (name) =>
                        !report.landmarkDiagnostic.missingGarment.includes(
                            name,
                        ),
                )
                .join(", ") || "none",
        );
        appendDebugLine(
            debugPanel,
            "Complete landmark pairs found",
            report.landmarkDiagnostic.found.join(", ") || "none",
        );
        appendDebugLine(
            debugPanel,
            "Missing garment landmarks",
            report.landmarkDiagnostic.missingGarment.join(", ") || "none",
        );
        appendDebugLine(
            debugPanel,
            "Missing avatar anchors",
            report.landmarkDiagnostic.missingAvatar.join(", ") || "none",
        );
        appendDebugLine(
            debugPanel,
            "Missing required landmark pairs",
            report.landmarkDiagnostic.missing.join(", ") || "none",
        );
        if (report.landmarkDiagnostic.solver) {
            const solver = report.landmarkDiagnostic.solver;
            appendDebugLine(
                debugPanel,
                "Rejected landmark solver output",
                [
                    Number.isFinite(solver.scale)
                        ? `scale=${solver.scale.toFixed(6)}`
                        : null,
                    Number.isFinite(solver.rmsError)
                        ? `RMS=${solver.rmsError.toFixed(4)} m`
                        : null,
                ]
                    .filter(Boolean)
                    .join("; ") || "solver did not return a usable transform",
            );
            if (solver.rotation) {
                const rotation = new THREE.Quaternion(...solver.rotation);
                appendDebugLine(
                    debugPanel,
                    "Rejected solver rotation (deg)",
                    formatEulerDegrees(
                        new THREE.Euler().setFromQuaternion(rotation),
                    ),
                );
            }
            if (solver.translation) {
                appendDebugLine(
                    debugPanel,
                    "Rejected solver translation (stage-local)",
                    `${formatVector(new THREE.Vector3(...solver.translation))} m`,
                );
            }
            (solver.errors || []).forEach((error, index) => {
                appendDebugLine(
                    debugPanel,
                    `Rejected solver residual ${report.landmarkDiagnostic.required[index] || index + 1}`,
                    `${error.toFixed(4)} m`,
                );
            });
        }
    }
    if (report.fitValidation) {
        appendDebugLine(
            debugPanel,
            "Fit validation",
            report.fitValidation.valid
                ? report.landmarkReport
                    ? `passed; landmark RMS limit ${report.fitValidation.maxRmsError.toFixed(4)} m`
                    : "passed bounds checks only; visual fit is not validated"
                : `failed: ${report.fitValidation.reason}`,
        );
        appendDebugLine(
            debugPanel,
            "Applied scale factor",
            formatVector(report.scaleFactor),
        );
    }
    if (report.autoFitAttempt) {
        appendDebugLine(
            debugPanel,
            "Landmark solver",
            `not applied: ${report.autoFitAttempt.reason}`,
        );
    }
    appendBoundsDebug(debugPanel, "Actual world bounds", actual);
    appendDebugLine(
        debugPanel,
        "Actual-target center delta",
        formatVector(targetDelta),
    );
    appendDebugLine(
        debugPanel,
        "Root position (stage-local)",
        formatVector(root.position),
    );
    const worldRootPosition = clothing[category].getWorldPosition(
        new THREE.Vector3(),
    );
    appendDebugLine(
        debugPanel,
        "Root world position",
        formatVector(worldRootPosition),
    );
    appendDebugLine(
        debugPanel,
        "Root rotation (deg)",
        formatEulerDegrees(root.rotation),
    );
    appendDebugLine(debugPanel, "Root scale", formatVector(root.scale));
    appendDebugLine(
        debugPanel,
        "Fit order",
        report.fitMethod === "landmarks"
            ? "restore source → solve similarity transform from landmarks → apply root transform"
            : "restore source → local rotation → configured normalization → scale → world translation",
    );
    appendDebugLine(
        debugPanel,
        "Normalization rule",
        `pivot=${report.normalization.pivot}; scale=${report.normalization.scale}`,
    );
    appendDebugLine(debugPanel, "Imported child transforms", "preserved");
    if (report.fitMethod !== "landmarks") {
        appendDebugLine(
            debugPanel,
            "Rotation offset space",
            "local root, degrees, before normalization/scale",
        );
        appendDebugLine(debugPanel, "Position offset space", "world, meters");
    }
    for (const warning of report.warnings || []) {
        appendWarning(debugPanel, warning);
    }

    const configForProduct = report.config;
    if (report.fitMethod === "landmarks") {
        appendDebugLine(
            debugPanel,
            "Manual fit presets",
            "Kept for compatibility; landmark fit is driven by authored garment landmarks.",
        );
    } else {
        appendProductFitEditors(debugPanel, configForProduct, category);
    }
    if (report.isShoePair) {
        for (const side of ["left", "right"]) {
            appendDebugLine(
                debugPanel,
                `${side} shoe fit`,
                "Separate GLB asset",
            );
            appendProductFitEditors(
                debugPanel,
                configForProduct.parts[side],
                category,
                `${side} `,
            );
        }
    }

    const actions = document.createElement("div");
    actions.className = "debug-actions";
    const reset = document.createElement("button");
    reset.type = "button";
    reset.textContent = "Reset preset";
    reset.addEventListener("click", () => {
        const defaultConfig = PRODUCT_FIT_DEFAULTS[report.productId] || {
            category: report.category,
            positionOffset: [0, 0, 0],
            rotationOffset: [0, 0, 0],
            scaleMultiplier: [1, 1, 1],
        };
        PRODUCT_FIT_CONFIG[report.productId] =
            mergeProductFitConfig(defaultConfig);
        applyProductConfig(category);
    });
    const exportButton = document.createElement("button");
    exportButton.type = "button";
    exportButton.textContent = "Export JSON";
    exportButton.addEventListener("click", exportFitConfig);
    actions.append(reset, exportButton);
    debugPanel.appendChild(actions);
}

function appendDebugDisplayControls(parent) {
    const viewActions = document.createElement("div");
    viewActions.className = "debug-actions";
    [
        ["front", "Mặt trước"],
        ["45", "Góc 45°"],
        ["side", "Bên hông"],
        ["back", "Mặt sau"],
    ].forEach(([view, label]) => {
        const button = document.createElement("button");
        button.type = "button";
        button.textContent = label;
        button.addEventListener("click", () => setCameraView(view));
        viewActions.appendChild(button);
    });
    parent.appendChild(viewActions);

    const toggles = document.createElement("div");
    toggles.className = "debug-actions";
    [
        ["bounds", "Bounding box"],
        ["axes", "Axes"],
        ["anchors", "Anchors"],
    ].forEach(([key, label]) => {
        const wrapper = document.createElement("label");
        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.checked = debugVisibility[key];
        checkbox.addEventListener("change", () => {
            debugVisibility[key] = checkbox.checked;
            updateAnchorHelpers();
            updateAvatarHelpers();
            for (const category of Object.keys(clothing)) {
                const report = productFitMetadata.get(category);
                if (report) updateProductHelpers(category, report.actualBounds);
            }
        });
        wrapper.append(checkbox, document.createTextNode(` ${label}`));
        toggles.appendChild(wrapper);
    });
    parent.appendChild(toggles);
}

function setCameraView(view) {
    const target = new THREE.Vector3(0, avatarHeight * 0.49, 0);
    const horizontalDistance = avatarHeight * 1.85;
    const verticalOffset = avatarHeight * 0.12;
    const diagonalDistance = horizontalDistance / Math.sqrt(2);
    const positions = {
        front: [0, verticalOffset, horizontalDistance],
        45: [diagonalDistance, verticalOffset, diagonalDistance],
        side: [horizontalDistance, verticalOffset, 0],
        back: [0, verticalOffset, -horizontalDistance],
    };
    const offset = positions[view];

    if (!offset) {
        throw new Error(`Góc nhìn không hợp lệ: ${view}`);
    }

    camera.position.copy(target).add(new THREE.Vector3(...offset));
    controls.target.copy(target);
    controls.update();
}

function appendPoseButtons(parent) {
    const actions = document.createElement("div");
    actions.className = "debug-actions";
    const pose = document.createElement("button");
    pose.type = "button";
    pose.textContent = "Fitting pose";
    pose.addEventListener("click", applyFittingPose);
    const reset = document.createElement("button");
    reset.type = "button";
    reset.textContent = "Reset pose";
    reset.addEventListener("click", resetAvatarPose);
    actions.append(pose, reset);
    parent.appendChild(actions);
}

function formatEulerDegrees(euler) {
    return formatVector(
        new THREE.Vector3(
            THREE.MathUtils.radToDeg(euler.x),
            THREE.MathUtils.radToDeg(euler.y),
            THREE.MathUtils.radToDeg(euler.z),
        ),
    );
}

function exportFitConfig() {
    const presets = {};
    for (const [productId, productConfig] of Object.entries(
        PRODUCT_FIT_CONFIG,
    )) {
        presets[productId] = {
            ...productConfig,
            positionOffset: [...productConfig.positionOffset],
            rotationOffset: [...productConfig.rotationOffset],
            scaleMultiplier: [...productConfig.scaleMultiplier],
            normalization: { ...productConfig.normalization },
            parts: Object.fromEntries(
                Object.entries(productConfig.parts || {}).map(
                    ([part, partConfig]) => [
                        part,
                        {
                            positionOffset: [...partConfig.positionOffset],
                            rotationOffset: [...partConfig.rotationOffset],
                            scaleMultiplier: [...partConfig.scaleMultiplier],
                            normalization: { ...partConfig.normalization },
                        },
                    ],
                ),
            ),
        };
    }

    const blob = new Blob([JSON.stringify(presets, null, 2)], {
        type: "application/json",
    });
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.download = "lhw-product-fit-presets.json";
    document.body.appendChild(link);
    link.click();
    link.remove();
    window.setTimeout(() => URL.revokeObjectURL(url), 1000);
}

function isLandmarkAutoFitEnabledForProduct(productId) {
    return (
        config.autoFit?.enabled === true &&
        config.autoFit?.strategy === "landmarks-first" &&
        Array.isArray(config.autoFit?.verifiedProductIds) &&
        config.autoFit.verifiedProductIds.some(
            (verifiedId) => String(verifiedId) === String(productId),
        )
    );
}

function getProductAssets(productId) {
    const productKey = String(productId);
    const configured = config.productAssets?.[productKey] || {};
    // Prefer the authored GLB only for products explicitly enabled for a landmark-fit test.
    // Product 13 has a verified authored export; other products should declare their own URL.
    const defaultLandmarkedUrl = productKey === "13"
        ? "/models/products/13/product.landmarked-v2.glb"
        : null;
    const landmarkedModelUrl = configured.landmarkedModelUrl || defaultLandmarkedUrl;
    const useLandmarkedAsset =
        isLandmarkAutoFitEnabledForProduct(productKey) && Boolean(landmarkedModelUrl);

    return {
        modelUrl:
            (useLandmarkedAsset ? landmarkedModelUrl : null) ||
            configured.modelUrl ||
            `/models/products/${encodeURIComponent(productId)}/product.glb`,
        leftShoeUrl: configured.leftShoeUrl || null,
        rightShoeUrl: configured.rightShoeUrl || null,
        render3D: configured.render3D !== false,
        qualityStatus: configured.qualityStatus || "not-reviewed",
        warnings: configured.warnings || [],
    };
}

function getProductWarnings(productId, assets) {
    const warnings =
        assets.warnings || config.assetWarnings?.[String(productId)] || [];
    return Array.isArray(warnings) ? [...warnings] : [String(warnings)];
}

async function loadShoePair(category, productId, assets, warnings) {
    const productKey = String(productId);
    const pair = new THREE.Group();
    pair.name = `Product ${productKey} left/right shoes`;
    const partDefinitions = [
        ["left", assets.leftShoeUrl],
        ["right", assets.rightShoeUrl],
    ];
    const parts = [];

    try {
        for (const [side, url] of partDefinitions) {
            const model = await loadGLB(url);
            model.name = `Product ${productKey} ${side} shoe asset`;
            const sourceBounds = computeModelBounds(model);
            productBaseTransforms.set(`${productKey}:${side}`, {
                position: model.position.clone(),
                quaternion: model.quaternion.clone(),
                scale: model.scale.clone(),
            });
            pair.add(model);
            parts.push({ side, model, sourceBounds, url, report: null });
        }

        fittingStage.add(pair);
        clothing[category] = pair;
        for (const part of parts) {
            part.report = fitModelToTarget(
                part.model,
                getTargetForShoeFoot(part.side),
                productKey,
                category,
                part.sourceBounds,
                part.side,
            );
        }
        warnings.push(
            "Giày trái/phải được fit độc lập theo anchor; kiểm tra hướng mũi trong GLB và chỉnh rotationOffset từng bên nếu trục nguồn khác trục +Z.",
        );
        const report = makeShoePairReport(pair, productKey, parts, warnings);
        productFitMetadata.set(category, report);
        updateProductHelpers(category, report.actualBounds);
        updateDebugPanel();
        return report;
    } catch (error) {
        fittingStage.remove(pair);
        if (clothing[category] === pair) clothing[category] = null;
        for (const part of parts) {
            part.model.traverse((object) => {
                if (!object.isMesh) return;
                object.geometry?.dispose();
                const materials = Array.isArray(object.material)
                    ? object.material
                    : [object.material];
                materials.forEach((material) => material?.dispose());
            });
            productBaseTransforms.delete(`${productKey}:${part.side}`);
        }
        throw error;
    }
}

async function loadGarment(category, productId) {
    removeClothing(category);

    if (productId === null || productId === undefined || productId === "") {
        console.info(`[LHW Fitting] Bỏ qua ${category}: chưa chọn sản phẩm.`);
        return { category, ok: true, skipped: true, loadState: "not-selected" };
    }

    if (category === "shoes" && config.features?.renderShoes3D !== true) {
        console.info(
            `[LHW Fitting] Giày ID ${productId} đã chọn; render 3D tạm thời tắt.`,
        );
        return {
            category,
            productId,
            ok: true,
            skipped: true,
            renderDisabled: true,
            loadState: "not-rendered",
            qualityStatus: "pending-review",
            warnings: [
                "Asset 3D đang được hoàn thiện; chưa hỗ trợ thử giày 3D.",
            ],
        };
    }

    const assets = getProductAssets(productId);
    const warnings = getProductWarnings(productId, assets);
    if (!assets.render3D) {
        console.info(
            `[LHW Fitting] Bỏ qua ${category}, ID ${productId}: asset chưa được duyệt để render.`,
        );
        return {
            category,
            productId,
            ok: true,
            skipped: true,
            assetPending: true,
            loadState: "not-rendered",
            qualityStatus: assets.qualityStatus,
            warnings,
        };
    }

    const hasLeftShoe = Boolean(assets.leftShoeUrl);
    const hasRightShoe = Boolean(assets.rightShoeUrl);
    const useSeparateShoes =
        category === "shoes" && hasLeftShoe && hasRightShoe;

    if (category === "shoes" && hasLeftShoe !== hasRightShoe) {
        warnings.push(
            "Cần cấu hình đồng thời leftShoeUrl và rightShoeUrl; hiện dùng asset đôi giày modelUrl.",
        );
    }
    if (category === "shoes" && !useSeparateShoes) {
        warnings.push(
            "Đang dùng GLB đôi giày dạng một asset; không thể căn chỉnh từng chiếc độc lập.",
        );
    }

    setStatus(`Đang tải ${category} — sản phẩm ${productId}...`);

    try {
        if (useSeparateShoes) {
            const report = await loadShoePair(
                category,
                productId,
                assets,
                warnings,
            );
            return {
                category,
                productId,
                ok: true,
                warnings,
                report,
                loadState: "loaded",
                qualityStatus: warnings.length
                    ? "warning"
                    : assets.qualityStatus,
                fitStatus: "not-visually-verified",
            };
        }

        const url = assets.modelUrl;
        console.log(`[LHW Fitting] Đang tải ${category}:`, url);

        const model = await loadGLB(url);
        const productKey = String(productId);
        productBaseTransforms.set(productKey, {
            position: model.position.clone(),
            quaternion: model.quaternion.clone(),
            scale: model.scale.clone(),
        });
        fittingStage.add(model);
        model.updateWorldMatrix(true, true);
        const sourceBounds = computeModelBounds(model);

        const target = getTargetForCategory(category);
        clothing[category] = model;

        let report;

        const autoFitEnabled = isLandmarkAutoFitEnabledForProduct(productId);
        let landmarkResult = null;

        if (autoFitEnabled) {
            landmarkResult = fitModelFromLandmarksIfAvailable(
                model,
                target,
                productId,
                category,
                sourceBounds,
            );
            const selection = selectLandmarkFit(landmarkResult, () => {
                console.info(
                    `[LHW Auto-Fit] ID ${productId}: ${landmarkResult?.reason || "landmarks-unavailable"}, chuyển sang fitting cũ.`,
                );
                if (config.autoFit?.fallback !== "legacy") {
                    throw new Error(
                        `Auto-Fit không thể căn chỉnh sản phẩm ${productId}: ${landmarkResult?.reason || "landmarks-unavailable"}`,
                    );
                }

                return fitModelToTarget(
                    model,
                    target,
                    productId,
                    category,
                    sourceBounds,
                );
            });
            report = selection.report;
            if (selection.method === "legacy-bounds") {
                report.fitMethod = selection.method;
                report.autoFitFallbackReason = selection.reason;
            }
        } else {
            report = fitModelToTarget(
                model,
                target,
                productId,
                category,
                sourceBounds,
            );

            report.fitMethod = "legacy-bounds";
        }
        if (autoFitEnabled && !landmarkResult?.ok) {
            report.landmarkDiagnostic = landmarkResult?.diagnostic || null;
            report.autoFitAttempt = {
                valid: false,
                reason: landmarkResult?.reason || "landmarks-unavailable",
            };
        }
        report.sourceUrl = url;
        report.warnings = warnings;
        productFitMetadata.set(category, report);
        updateProductHelpers(category, report.actualBounds);
        updateDebugPanel();

        console.log(`[LHW Fitting] Đã tải ${category}:`, {
            productId,
            url,
            rawRootTransform: report.rawRootTransform,
            rawBounds: report.rawBounds,
            normalizedBounds: report.normalizedBounds,
            target: report.target,
            actualBounds: report.actualBounds,
            centerError: report.centerError,
            modelTransform: report.rootTransform,
        });

        return {
            category,
            productId,
            ok: true,
            warnings,
            report,
            loadState: "loaded",
            qualityStatus: warnings.length ? "warning" : assets.qualityStatus,
            fitStatus: "not-visually-verified",
        };
    } catch (error) {
        removeClothing(category);
        console.error(
            `[LHW Fitting] Lỗi tải ${category}, ID ${productId}:`,
            error,
        );

        return {
            category,
            productId,
            ok: false,
            error: error.message,
            loadState: "failed",
            qualityStatus: assets.qualityStatus,
            fitStatus: "not-assessed",
        };
    }
}

function getGarmentLandmark(model, name) {
    const node = model.getObjectByName(name);

    if (!node) {
        return null;
    }

    model.updateWorldMatrix(true, true);

    return node.getWorldPosition(new THREE.Vector3());
}

function getGarmentLandmarks(model, category) {
    const names =
        config.autoFit?.categories?.[category]?.requiredLandmarks || [];

    if (!names) {
        return {
            points: {},
            missing: [],
        };
    }

    const points = {};
    const missing = [];

    for (const name of names) {
        const point = getGarmentLandmark(model, name);

        if (point) {
            points[name] = point;
        } else {
            missing.push(name);
        }
    }

    return { points, missing };
}

function restoreProductBaseTransform(model, productId, part = null) {
    const key = part ? `${productId}:${part}` : String(productId);
    const baseTransform = productBaseTransforms.get(key);
    if (!baseTransform) {
        return null;
    }

    model.position.copy(baseTransform.position);
    model.quaternion.copy(baseTransform.quaternion);
    model.scale.copy(baseTransform.scale);
    model.updateWorldMatrix(true, true);
    return baseTransform;
}

function getAvatarSurfacePointAtY(x, y, side) {
    if (!avatar || !Number.isFinite(x) || !Number.isFinite(y)) return null;

    avatar.updateWorldMatrix(true, true);
    const bounds = new THREE.Box3().setFromObject(avatar);
    if (bounds.isEmpty()) return null;

    const depth = bounds.max.z - bounds.min.z;
    if (!Number.isFinite(depth) || depth <= 1e-5) return null;

    const margin = Math.max(depth * 0.25, avatarHeight * 0.08, 0.05);
    const fromFront = side === "front";
    const origin = new THREE.Vector3(
        x,
        y,
        fromFront ? bounds.max.z + margin : bounds.min.z - margin,
    );
    const direction = new THREE.Vector3(0, 0, fromFront ? -1 : 1);
    const raycaster = new THREE.Raycaster(
        origin,
        direction,
        0,
        depth + margin * 2,
    );
    const hits = raycaster.intersectObject(avatar, true);
    const hit = hits.find(
        (intersection) =>
            intersection.object?.isMesh &&
            Number.isFinite(intersection.point?.x) &&
            Number.isFinite(intersection.point?.y) &&
            Number.isFinite(intersection.point?.z),
    );
    return hit ? hit.point.clone() : null;
}

function getAvatarLandmarks(category, garmentPoints = {}) {
    const points = {};
    const estimated = new Set();
    const putAnchor = (name, anchorName) => {
        const point = avatarAnchors[anchorName];
        if (point) points[name] = point.clone();
    };
    const interpolate = (start, end, amount) => start.clone().lerp(end, amount);

    if (category === "top") {
        putAnchor("LHW_Neck", "neck");
        putAnchor("LHW_Shoulder_L", "shoulderLeft");
        putAnchor("LHW_Shoulder_R", "shoulderRight");

        const pelvis = avatarAnchors.pelvis;
        const chest = avatarAnchors.chest;
        const neck = avatarAnchors.neck;
        const shoulderLeft = avatarAnchors.shoulderLeft;
        const shoulderRight = avatarAnchors.shoulderRight;
        const garmentNeck = garmentPoints.LHW_Neck;
        const garmentHem = garmentPoints.LHW_Hem;
        const garmentShoulderLeft = garmentPoints.LHW_Shoulder_L;
        const garmentShoulderRight = garmentPoints.LHW_Shoulder_R;

        if (pelvis && chest) {
            points.LHW_Hem = interpolate(pelvis, chest, 0.12);
            estimated.add("LHW_Hem");
        }

        // Infer front/back torso points from the authored garment landmark proportions,
        // then raycast the avatar surface at those heights. This avoids guessed fixed Z offsets.
        const avatarHem = points.LHW_Hem;
        const sourceVerticalSpan = garmentNeck && garmentHem
            ? garmentNeck.y - garmentHem.y
            : 0;
        const sourceShoulderSpan = garmentShoulderLeft && garmentShoulderRight
            ? garmentShoulderRight.x - garmentShoulderLeft.x
            : 0;
        const targetShoulderSpan = shoulderLeft && shoulderRight
            ? shoulderRight.x - shoulderLeft.x
            : 0;
        const canMapHeight =
            Boolean(avatarHem && neck && garmentNeck && garmentHem) &&
            Number.isFinite(sourceVerticalSpan) &&
            Math.abs(sourceVerticalSpan) > 1e-5 &&
            Math.abs(neck.y - avatarHem.y) > 1e-5;
        const canMapWidth =
            Boolean(shoulderLeft && shoulderRight && garmentShoulderLeft && garmentShoulderRight) &&
            Math.abs(sourceShoulderSpan) > 1e-5 &&
            Math.abs(targetShoulderSpan) > 1e-5;

        const inferTorsoSurfacePoint = (landmarkName, side) => {
            const garmentPoint = garmentPoints[landmarkName];
            if (!garmentPoint || !canMapHeight || !canMapWidth) return;

            const heightRatio = (garmentPoint.y - garmentHem.y) / sourceVerticalSpan;
            const widthRatio =
                (garmentPoint.x - garmentShoulderLeft.x) / sourceShoulderSpan;
            if (
                !Number.isFinite(heightRatio) ||
                !Number.isFinite(widthRatio) ||
                heightRatio < -0.02 ||
                heightRatio > 1.02 ||
                widthRatio < -0.02 ||
                widthRatio > 1.02
            ) {
                return;
            }

            const targetY = avatarHem.y + heightRatio * (neck.y - avatarHem.y);
            const targetX = shoulderLeft.x + widthRatio * targetShoulderSpan;
            const surfacePoint = getAvatarSurfacePointAtY(targetX, targetY, side);
            if (surfacePoint) {
                points[landmarkName] = surfacePoint;
                estimated.add(landmarkName);
            }
        };

        inferTorsoSurfacePoint("LHW_Chest_Front", "front");
        inferTorsoSurfacePoint("LHW_Back_Center", "back");
    } else if (category === "bottom") {
        const pelvis = avatarAnchors.pelvis;
        const spine = avatarAnchors.spine;
        const upperLegLeft = avatarAnchors.upperLegLeft;
        const upperLegRight = avatarAnchors.upperLegRight;
        const kneeLeft = avatarAnchors.kneeLeft;
        const kneeRight = avatarAnchors.kneeRight;

        if (pelvis && spine) {
            points.LHW_Waist = interpolate(pelvis, spine, 0.75);
            estimated.add("LHW_Waist");
        }
        if (upperLegLeft && upperLegRight) {
            points.LHW_Crotch = upperLegLeft
                .clone()
                .add(upperLegRight)
                .multiplyScalar(0.5);
            estimated.add("LHW_Crotch");
        }
        putAnchor("LHW_Knee_L", "kneeLeft");
        putAnchor("LHW_Knee_R", "kneeRight");
        putAnchor("LHW_Hem_L", "ankleLeft");
        putAnchor("LHW_Hem_R", "ankleRight");
        // LHW_Waist_Front remains intentionally unsupported until a matching avatar surface
        // point is validated; the solver will reject Auto-Fit rather than guess its position.
    }

    return { points, estimated };
}

function isUsableBounds(bounds) {
    if (!bounds || bounds.box.isEmpty()) return false;

    const values = [
        bounds.min.x,
        bounds.min.y,
        bounds.min.z,
        bounds.max.x,
        bounds.max.y,
        bounds.max.z,
        bounds.size.x,
        bounds.size.y,
        bounds.size.z,
    ];
    return (
        values.every(Number.isFinite) &&
        bounds.size.x > 1e-6 &&
        bounds.size.y > 1e-6 &&
        bounds.size.z > 1e-6
    );
}

function solveLandmarkSimilarity(sourcePoints, targetPoints, validation) {
    const result = solveLandmarkSimilarityArrays(
        sourcePoints.map((point) => point.toArray()),
        targetPoints.map((point) => point.toArray()),
        validation,
    );
    if (!result.ok) {
        return result;
    }

    return {
        ...result,
        rotation: new THREE.Quaternion(
            result.rotation[0],
            result.rotation[1],
            result.rotation[2],
            result.rotation[3],
        ),
        translation: new THREE.Vector3(...result.translation),
    };
}

function getLandmarkSolverDiagnostic(fit) {
    const toArray = (value) =>
        Array.isArray(value) ? [...value] : value?.toArray?.() || null;
    const diagnostic = {};

    if (Number.isFinite(fit.scale)) diagnostic.scale = fit.scale;
    const rotation = toArray(fit.rotation);
    if (rotation) diagnostic.rotation = rotation;
    const translation = toArray(fit.translation);
    if (translation) diagnostic.translation = translation;
    if (Number.isFinite(fit.rmsError)) diagnostic.rmsError = fit.rmsError;
    if (Array.isArray(fit.errors)) diagnostic.errors = [...fit.errors];

    return Object.keys(diagnostic).length ? diagnostic : null;
}

function getMeshSummary(model) {
    const summary = [];
    model.traverse((object) => {
        if (!object.isMesh) return;

        const vertexCount = object.geometry.attributes.position?.count || 0;
        const indexCount = object.geometry.index?.count || 0;
        summary.push({
            name: object.name || "(unnamed)",
            vertices: vertexCount,
            indices: indexCount,
            triangles: Math.floor((indexCount || vertexCount) / 3),
            localPosition: object.position.clone(),
            localRotation: object.rotation.clone(),
            localScale: object.scale.clone(),
            materials: (Array.isArray(object.material)
                ? object.material
                : [object.material]
            )
                .filter(Boolean)
                .map((material) => ({
                    name: material.name || "(unnamed)",
                    type: material.type,
                    side: material.side,
                    transparent: material.transparent,
                    opacity: material.opacity,
                    alphaTest: material.alphaTest,
                    depthWrite: material.depthWrite,
                    hasMap: Boolean(material.map),
                    hasAlphaMap: Boolean(material.alphaMap),
                    hasNormalMap: Boolean(material.normalMap),
                })),
        });
    });
    return summary;
}

function fitModelFromLandmarksIfAvailable(
    model,
    target,
    productId,
    category,
    sourceBounds,
) {
    const productKey = String(productId);
    const required =
        config.autoFit?.categories?.[category]?.requiredLandmarks || [];
    if (!required.length) {
        return { ok: false, reason: "category-landmarks-not-configured" };
    }

    const baseTransform = restoreProductBaseTransform(model, productKey);
    if (!baseTransform) {
        return { ok: false, reason: "source-transform-unavailable" };
    }

    const garment = getGarmentLandmarks(model, category);
    const body = getAvatarLandmarks(category, garment.points);
    const missingGarment = required.filter((name) => !garment.points[name]);
    const missingAvatar = required.filter((name) => !body.points[name]);
    const missing = [...new Set([...missingGarment, ...missingAvatar])];
    const found = required.filter(
        (name) => garment.points[name] && body.points[name],
    );
    const landmarkDiagnostic = {
        required,
        found,
        missing,
        missingGarment,
        missingAvatar,
    };
    if (!isUsableBounds(sourceBounds)) {
        return {
            ok: false,
            reason: "invalid-or-degenerate-garment-bounds",
            diagnostic: landmarkDiagnostic,
        };
    }
    if (missing.length) {
        return {
            ok: false,
            reason: `missing-landmarks:${missing.join(",")}`,
            diagnostic: landmarkDiagnostic,
        };
    }
    const geometryValidation = validateLandmarkGeometry(
        category,
        new Map(
            required.map((name) => [
                name,
                garment.points[name].toArray(),
            ]),
        ),
        {
            min: sourceBounds.min.toArray(),
            max: sourceBounds.max.toArray(),
            size: sourceBounds.size.toArray(),
        },
    );
    if (!geometryValidation.valid) {
        return {
            ok: false,
            reason: `invalid-garment-landmark-geometry:${geometryValidation.reason}`,
            diagnostic: {
                ...landmarkDiagnostic,
                geometryValidation,
            },
        };
    }

    const parent = model.parent;
    if (!parent) {
        return { ok: false, reason: "garment-parent-unavailable" };
    }
    fittingStage.updateWorldMatrix(true, false);
    parent.updateWorldMatrix(true, false);
    model.updateWorldMatrix(true, true);
    const stageWorld = fittingStage.matrixWorld.clone();
    const inverseStageWorld = stageWorld.clone().invert();
    const sourcePoints = required.map((name) =>
        garment.points[name].clone().applyMatrix4(inverseStageWorld),
    );
    const targetPoints = required.map((name) =>
        body.points[name].clone().applyMatrix4(inverseStageWorld),
    );
    const maximumScale = config.autoFit?.validation?.maximumScale ?? 50;
    const minimumScale = config.autoFit?.validation?.minimumScale ?? 0.02;
    const maximumRms =
        avatarHeight *
        (config.autoFit?.validation?.maximumRmsRelativeToAvatarHeight ?? 0.08);
    if (
        !Number.isFinite(minimumScale) ||
        !Number.isFinite(maximumScale) ||
        !Number.isFinite(maximumRms) ||
        minimumScale <= 0 ||
        maximumScale < minimumScale ||
        maximumRms <= 0
    ) {
        return {
            ok: false,
            reason: "invalid-auto-fit-validation-config",
            diagnostic: landmarkDiagnostic,
        };
    }
    const fit = solveLandmarkSimilarity(sourcePoints, targetPoints, {
        minimumScale,
        maximumScale,
        maximumRmsError: maximumRms,
    });
    const solverDiagnostic = getLandmarkSolverDiagnostic(fit);
    if (!fit.ok) {
        return {
            ok: false,
            reason: fit.reason,
            diagnostic: {
                ...landmarkDiagnostic,
                solver: solverDiagnostic,
            },
        };
    }
    landmarkDiagnostic.solver = solverDiagnostic;

    const fitMatrix = new THREE.Matrix4().compose(
        fit.translation,
        fit.rotation,
        new THREE.Vector3(fit.scale, fit.scale, fit.scale),
    );
    const orientedBounds = computeModelBounds(model);
    const originalStageMatrix = inverseStageWorld.multiply(
        model.matrixWorld.clone(),
    );
    const fittedWorldMatrix = stageWorld
        .clone()
        .multiply(fitMatrix)
        .multiply(originalStageMatrix);
    const fittedLocalMatrix = parent.matrixWorld
        .clone()
        .invert()
        .multiply(fittedWorldMatrix);
    const fittedPosition = new THREE.Vector3();
    const fittedQuaternion = new THREE.Quaternion();
    const fittedScale = new THREE.Vector3();
    fittedLocalMatrix.decompose(fittedPosition, fittedQuaternion, fittedScale);
    const recomposedLocalMatrix = new THREE.Matrix4().compose(
        fittedPosition,
        fittedQuaternion,
        fittedScale,
    );
    const matrixDeviation = Math.max(
        ...fittedLocalMatrix.elements.map((value, index) =>
            Math.abs(value - recomposedLocalMatrix.elements[index]),
        ),
    );
    if (!Number.isFinite(matrixDeviation) || matrixDeviation > 1e-5) {
        return {
            ok: false,
            reason: "parent-transform-requires-shear",
            diagnostic: landmarkDiagnostic,
        };
    }
    model.position.copy(fittedPosition);
    model.quaternion.copy(fittedQuaternion);
    model.scale.copy(fittedScale);
    model.updateWorldMatrix(true, true);

    const actualBounds = computeModelBounds(model);
    if (!isUsableBounds(actualBounds)) {
        return {
            ok: false,
            reason: "invalid-bounds-after-landmark-fit",
            diagnostic: landmarkDiagnostic,
        };
    }

    const actualLandmarkErrors = required.map((name) => {
        const actual = getGarmentLandmark(model, name);
        return actual ? actual.distanceTo(body.points[name]) : Infinity;
    });
    const postFitRmsError = Math.sqrt(
        actualLandmarkErrors.reduce((sum, error) => sum + error * error, 0) /
            actualLandmarkErrors.length,
    );
    if (!Number.isFinite(postFitRmsError) || postFitRmsError > maximumRms) {
        return {
            ok: false,
            reason: "post-fit-landmark-validation-failed",
            diagnostic: {
                required,
                found,
                missing,
                missingGarment,
                missingAvatar,
                preFitRmsError: fit.rmsError,
                postFitRmsError,
                maximumRms,
                solver: solverDiagnostic,
            },
        };
    }

    const pairs = required.map((name, index) => ({
        name,
        error: actualLandmarkErrors[index],
        solverError: fit.errors[index],
        estimated: body.estimated.has(name),
    }));
    const landmarkReport = {
        required,
        found,
        missing,
        pairs,
        rmsError: postFitRmsError,
        preFitRmsError: fit.rmsError,
        estimatedAvatarAnchors: [...body.estimated],
        transform: {
            coordinateSpace: "fitting-stage",
            scale: fit.scale,
            rotation: fit.rotation.clone(),
            translation: fit.translation.clone(),
        },
    };
    const configForProduct = getProductFitConfig(productKey, category);
    const meshSummary = getMeshSummary(model);
    const targetLocalCenter = fittingStage.worldToLocal(target.center.clone());
    return {
        ok: true,
        report: {
            productId: productKey,
            category,
            config: configForProduct,
            rawRootTransform: {
                position: baseTransform.position.clone(),
                rotation: new THREE.Euler().setFromQuaternion(
                    baseTransform.quaternion,
                ),
                quaternion: baseTransform.quaternion.clone(),
                scale: baseTransform.scale.clone(),
            },
            rawBounds: sourceBounds,
            orientedBounds,
            meshSummary,
            normalizedBounds: sourceBounds,
            target: {
                center: target.center.clone(),
                size: target.size.clone(),
            },
            targetLocalCenter: fittingStage.worldToLocal(target.center.clone()),
            desiredLocalCenter: targetLocalCenter.clone(),
            actualBounds,
            centerError: actualBounds.center.clone().sub(target.center),
            normalization: { pivot: "landmarks", scale: "uniform" },
            scaleFactor: new THREE.Vector3(fit.scale, fit.scale, fit.scale),
            rootTransform: {
                position: model.position.clone(),
                rotation: model.rotation.clone(),
                quaternion: model.quaternion.clone(),
                scale: model.scale.clone(),
            },
            fitMethod: "landmarks",
            landmarkReport,
            fitValidation: {
                valid: true,
                maxRmsError: maximumRms,
                preFitRmsError: fit.rmsError,
                scaleRange: [minimumScale, maximumScale],
                preFitBounds: sourceBounds,
                postFitBounds: actualBounds,
            },
            geometryAnalysis: {
                meshCount: meshSummary.length,
                garmentLandmarksFound: found,
                garmentLandmarksMissing: missingGarment,
                inferredLandmarks: [],
            },
        },
    };
}

function appendOutfitStatusItem(parent, title, fields, state) {
    const item = document.createElement("div");
    item.className = "fitting-status-item";
    item.dataset.state = state;

    const heading = document.createElement("strong");
    heading.textContent = title;
    item.appendChild(heading);

    for (const [label, value] of fields) {
        const detail = document.createElement("div");
        detail.className = "fitting-status-note";
        detail.textContent = `${label}: ${value}`;
        item.appendChild(detail);
    }

    parent.appendChild(item);
}

function renderOutfitStatus(results) {
    status.replaceChildren();
    const heading = document.createElement("h2");
    heading.className = "fitting-status-heading";
    heading.textContent = "Trạng thái phòng thử đồ 3D (bản thử nghiệm)";
    status.appendChild(heading);

    appendOutfitStatusItem(
        status,
        "Avatar",
        [
            ["Tải model", avatar ? "Đã tải" : "Tải thất bại"],
            ["Pose", avatar ? "Đã áp dụng trong viewer" : "Chưa sẵn sàng"],
            ["Độ vừa trang phục", "Không áp dụng"],
        ],
        avatar ? "ready" : "error",
    );

    const labels = { top: "Áo", bottom: "Quần", shoes: "Giày" };
    for (const result of results) {
        const title = `${labels[result.category]}${result.productId ? ` (ID ${result.productId})` : ""}`;
        let loadState = "Chưa chọn sản phẩm";
        let assetState = "Chưa có asset được chọn";
        let fitState = "Không áp dụng";
        let state = "pending";

        if (result.renderDisabled || result.assetPending) {
            loadState = "Chưa render; không tải GLB";
            assetState = "Asset 3D đang được hoàn thiện";
            fitState = "Chưa thử / chưa xác nhận";
        } else if (result.skipped) {
            loadState = "Chưa chọn sản phẩm";
        } else if (!result.ok) {
            loadState = `Tải thất bại: ${result.error}`;
            assetState = "Không thể đánh giá do lỗi tải";
            fitState = "Chưa thử";
            state = "error";
        } else {
            loadState = "Đã tải model";
            assetState = result.warnings?.length
                ? "Có cảnh báo chất lượng; không được xác nhận hợp lệ"
                : "Chưa được xác minh độc lập";
            fitState =
                "Chưa xác nhận độ vừa / độ che phủ bằng quan sát trực quan";
            state = result.warnings?.length ? "warning" : "ready";
        }

        appendOutfitStatusItem(
            status,
            title,
            [
                ["Tải model", loadState],
                ["Chất lượng asset", assetState],
                [
                    "Phương pháp căn chỉnh",
                    result.report?.fitMethod === "landmarks"
                        ? `Landmarks (${result.report.landmarkReport.found.length} cặp)`
                        : result.report?.fitMethod === "legacy-bounds"
                          ? `Fallback bounds${result.report.autoFitFallbackReason ? `: ${result.report.autoFitFallbackReason}` : ""}`
                          : "Không áp dụng",
                ],
                ["Độ vừa / che phủ", fitState],
            ],
            state,
        );
    }

    const note = document.createElement("p");
    note.className = "fitting-warning";
    note.textContent =
        "Đây là bản thử đồ 3D thử nghiệm. Model đã tải hoặc bounds khớp mục tiêu không đồng nghĩa trang phục fit chính xác.";
    status.appendChild(note);
}

function catalogCategoryLabel(value) {
    return CATALOG_CATEGORIES.find((category) => category.value === value)?.label || "Phụ kiện khác";
}

function inferCatalogCategory(item) {
    const given = String(item.category || "").trim().toLowerCase();
    if (CATALOG_CATEGORY_VALUES.has(given)) return given;

    const productId = String(item.productId ?? item.id ?? "");
    if (String(config.outfit?.top ?? "") === productId) return "top";
    if (String(config.outfit?.bottom ?? "") === productId) return "bottom";
    if (String(config.outfit?.shoes ?? "") === productId) return "shoes";

    const text = `${item.label || ""} ${item.path || ""} ${item.url || ""}`.toLowerCase();
    if (/(glasses|eyeglass|sunglass|kinh|spectacle)/i.test(text)) return "glasses";
    if (/(hat|cap|beanie|helmet|mu\b|non\b|headwear)/i.test(text)) return "hat";
    if (/(necklace|necklace|pendant|scarf|tie|khăn|day-chuyen|vong-co)/i.test(text)) {
        return /(scarf|tie|khan)/i.test(text) ? "scarf" : "necklace";
    }
    if (/(bag|backpack|handbag|tote|purse|tui|balo)/i.test(text)) return "bag";
    if (/(watch|bracelet|wrist|dong-ho|vong-tay)/i.test(text)) return "wrist";
    if (/(shoe|sneaker|boot|sandal|loafer|giay)/i.test(text)) return "shoes";
    if (/(pant|trouser|jean|shorts|skirt|bottom|quan|vay)/i.test(text)) return "bottom";
    if (/(shirt|t-shirt|tee|top|blouse|hoodie|jacket|coat|sweater|ao\b|polo)/i.test(text)) return "top";
    return "generic";
}

function getCatalogSourceItems() {
    let source = Array.isArray(config.productCatalog) ? config.productCatalog : [];
    if (!source.length) {
        source = Object.entries(config.productAssets || {}).map(([productId, assets]) => ({
            id: String(productId),
            productId: String(productId),
            label: assets.label || assets.name || `Sản phẩm #${productId}`,
            path: assets.modelUrl || `/models/products/${productId}/product.glb`,
            url: assets.modelUrl || `/models/products/${productId}/product.glb`,
            category: String(config.outfit?.top ?? "") === String(productId)
                ? "top"
                : String(config.outfit?.bottom ?? "") === String(productId)
                  ? "bottom"
                  : String(config.outfit?.shoes ?? "") === String(productId)
                    ? "shoes"
                    : "generic",
        }));
    }

    const byUrl = new Map();
    source.forEach((raw, index) => {
        const isShoePair = Boolean(raw.leftShoeUrl && raw.rightShoeUrl);
        const url = String(raw.url || raw.modelUrl || raw.path || "").trim();
        if (!url || (!isShoePair && !/\.(glb|gltf)(?:[?#].*)?$/i.test(url))) return;
        if (!isShoePair && /landmarked|\.bak\.|backup|\/avatar(?:s)?\//i.test(url)) return;

        const item = {
            id: String(raw.id ?? raw.productId ?? `asset-${index + 1}`),
            productId: raw.productId === null || raw.productId === undefined
                ? (raw.id ?? null)
                : raw.productId,
            label: String(raw.label || raw.name || raw.filename || (isShoePair ? "Giày (đôi)" : url.split("/").pop())),
            path: String(raw.path || url),
            url,
            imageUrl: String(raw.imageUrl || raw.thumbnailUrl || raw.image || "").trim() || null,
            leftShoeUrl: isShoePair ? String(raw.leftShoeUrl) : null,
            rightShoeUrl: isShoePair ? String(raw.rightShoeUrl) : null,
            category: String(raw.category || "").trim().toLowerCase(),
        };
        item.category = inferCatalogCategory(item);
        if (!byUrl.has(url)) byUrl.set(url, item);
    });
    return [...byUrl.values()];
}

const catalogSourceItems = getCatalogSourceItems();

function makeElement(tag, className, text) {
    const element = document.createElement(tag);
    if (className) element.className = className;
    if (text !== undefined && text !== null) element.textContent = String(text);
    return element;
}

function renderProductCatalog() {
    if (!catalogItemsContainer) return;
    catalogItemsContainer.replaceChildren();

    const query = String(catalogSearchInput?.value || "").trim().toLowerCase();
    const typeFilter = String(catalogCategoryFilter?.value || "all");
    const items = catalogSourceItems.filter((item) => {
        const selectedCategory = catalogCategoryOverrides.get(item.url) || item.category;
        const haystack = `${item.label} ${item.path} ${item.url} ${item.productId || ""}`.toLowerCase();
        return (!query || haystack.includes(query)) &&
            (typeFilter === "all" || selectedCategory === typeFilter);
    });

    if (!items.length) {
        catalogItemsContainer.appendChild(makeElement(
            "p",
            "catalog-empty",
            catalogSourceItems.length
                ? "Không có model phù hợp với bộ lọc hiện tại."
                : "Chưa tìm thấy file GLB/GLTF. Hãy kiểm tra thư mục public/models.",
        ));
        return;
    }

    const addedUrls = new Set([...catalogSceneItems.values()].map((entry) => entry.url));
    for (const item of items) {
        const card = makeElement("article", "catalog-item");
        const media = makeElement("div", `catalog-item-media${item.imageUrl ? "" : " catalog-item-media--empty"}`);
        media.setAttribute("aria-label", item.imageUrl ? `Ảnh ${item.label}` : `Chưa có ảnh cho ${item.label}`);
        if (item.imageUrl) {
            const image = document.createElement("img");
            image.src = item.imageUrl;
            image.alt = item.label;
            image.loading = "lazy";
            image.decoding = "async";
            image.addEventListener("error", () => {
                media.classList.add("catalog-item-media--empty");
                media.replaceChildren(
                    makeElement("strong", "catalog-item-placeholder-mark", "3D"),
                    makeElement("span", "catalog-item-placeholder-note", "Ảnh chưa khả dụng"),
                );
            }, { once: true });
            media.appendChild(image);
        } else {
            media.append(
                makeElement("strong", "catalog-item-placeholder-mark", "3D"),
                makeElement("span", "catalog-item-placeholder-note", "Chưa có ảnh sản phẩm"),
            );
        }

        const content = makeElement("div", "catalog-item-content");
        const title = makeElement("strong", "catalog-item-title", item.label);
        const path = makeElement("small", "catalog-item-path", item.path);
        const typeLabel = makeElement("label", "catalog-item-type-label", "Loại sản phẩm");
        const typeSelect = document.createElement("select");
        typeSelect.className = "catalog-item-type";
        typeSelect.setAttribute("aria-label", `Phân loại ${item.label}`);

        CATALOG_CATEGORIES.forEach((category) => {
            const option = document.createElement("option");
            option.value = category.value;
            option.textContent = category.label;
            typeSelect.appendChild(option);
        });
        typeSelect.value = catalogCategoryOverrides.get(item.url) || item.category;
        typeSelect.addEventListener("change", () => {
            catalogCategoryOverrides.set(item.url, typeSelect.value);
            item.category = typeSelect.value;
            renderProductCatalog();
        });
        typeLabel.appendChild(typeSelect);

        const addButton = makeElement(
            "button",
            "catalog-add-button",
            addedUrls.has(item.url) ? "Đã thêm" : "+ Thêm vào phối đồ",
        );
        addButton.type = "button";
        addButton.disabled = addedUrls.has(item.url);
        addButton.addEventListener("click", async () => {
            addButton.disabled = true;
            addButton.textContent = "Đang tải 3D…";
            try {
                await addCatalogModel(item, typeSelect.value);
            } catch (error) {
                console.error("[LHW Studio] Không thể thêm model:", error);
                setStatus(`Không thêm được ${item.label}: ${error.message || error}`);
                addButton.disabled = false;
                addButton.textContent = "+ Thêm vào phối đồ";
            }
        });

        content.append(title, path, typeLabel, addButton);
        card.append(media, content);
        catalogItemsContainer.appendChild(card);
    }
}
function getBoneWorldPositionByName(pattern, fallback) {
    const bone = Object.values(avatarBones).find((candidate) => pattern.test(candidate.name));
    if (!bone) return fallback.clone();
    return bone.getWorldPosition(new THREE.Vector3());
}

function getCatalogTarget(category, item = null) {
    if (category === "top" || category === "bottom" || category === "shoes") {
        return getTargetForCategory(category);
    }

    const h = Math.max(avatarHeight || 1.765, 0.1);
    const neck = avatarAnchors.neck?.clone() || new THREE.Vector3(0, h * 0.84, 0);
    const shouldersY = ((avatarAnchors.shoulderLeft?.y ?? h * 0.82) +
        (avatarAnchors.shoulderRight?.y ?? h * 0.82)) / 2;
    const chest = avatarAnchors.chest?.clone() || new THREE.Vector3(0, h * 0.72, 0);
    const head = getBoneWorldPositionByName(/head(?!top)/i, new THREE.Vector3(0, h * 0.92, 0));
    const leftHand = avatarAnchors.handLeft?.clone() || new THREE.Vector3(-h * 0.35, h * 0.62, 0);

    // When the avatar is hidden, bags and unclassified objects should be staged
    // beside the outfit instead of being placed over the shirt/trousers. Give
    // each added piece its own slot so multiple accessories do not stack.
    const sideCategories = new Set(["bag", "accessory", "generic"]);
    const sideCount = [...catalogSceneItems.values()].filter((entry) => sideCategories.has(entry.category)).length;
    const side = sideCount % 2 === 0 ? 1 : -1;
    const row = Math.floor(sideCount / 2);
    const sideX = side * h * (0.36 + Math.min(row, 2) * 0.11);
    const sideY = h * (0.53 - Math.min(row, 3) * 0.14);
    const sideZ = 0.03 + Math.min(row, 3) * 0.025;

    const targets = {
        hat: {
            center: head.clone().add(new THREE.Vector3(0, h * 0.075, 0)),
            size: new THREE.Vector3(h * 0.23, h * 0.13, h * 0.22),
        },
        glasses: {
            center: head.clone().add(new THREE.Vector3(0, h * 0.015, h * 0.07)),
            size: new THREE.Vector3(h * 0.17, h * 0.055, h * 0.055),
        },
        necklace: {
            center: neck.clone().add(new THREE.Vector3(0, -h * 0.035, h * 0.09)),
            size: new THREE.Vector3(h * 0.17, h * 0.085, h * 0.08),
        },
        scarf: {
            center: neck.clone().add(new THREE.Vector3(0, -h * 0.055, h * 0.10)),
            size: new THREE.Vector3(h * 0.20, h * 0.14, h * 0.09),
        },
        bag: {
            // Separate display lane: avoid a handbag/bag being normalized over the top mesh.
            center: new THREE.Vector3(sideX, sideY, sideZ),
            size: new THREE.Vector3(h * 0.25, h * 0.27, h * 0.17),
        },
        wrist: {
            center: leftHand.clone().add(new THREE.Vector3(0, -h * 0.01, h * 0.02)),
            size: new THREE.Vector3(h * 0.075, h * 0.055, h * 0.07),
        },
        accessory: {
            center: new THREE.Vector3(sideX, sideY, sideZ),
            size: new THREE.Vector3(h * 0.17, h * 0.17, h * 0.17),
        },
        generic: {
            center: new THREE.Vector3(sideX, sideY, sideZ),
            size: new THREE.Vector3(h * 0.22, h * 0.22, h * 0.22),
        },
    };
    return targets[category] || {
        center: new THREE.Vector3(sideX, shouldersY * 0.5, sideZ),
        size: new THREE.Vector3(h * 0.20, h * 0.20, h * 0.20),
    };
}

function disposeCatalogModel(model) {
    if (!model) return;
    const geometries = new Set();
    const materials = new Set();
    const textures = new Set();
    model.traverse((object) => {
        if (object.geometry) geometries.add(object.geometry);
        const materialList = Array.isArray(object.material)
            ? object.material
            : object.material ? [object.material] : [];
        materialList.forEach((material) => {
            materials.add(material);
            for (const value of Object.values(material)) {
                if (value?.isTexture) textures.add(value);
            }
        });
    });
    geometries.forEach((geometry) => geometry.dispose());
    materials.forEach((material) => material.dispose());
    textures.forEach((texture) => texture.dispose());
}

function removeCatalogSceneItem(sceneItemId, shouldRender = true) {
    const entry = catalogSceneItems.get(sceneItemId);
    if (!entry) return;
    fittingStage.remove(entry.model);
    disposeCatalogModel(entry.model);
    productBaseTransforms.delete(entry.fitKey);
    if (entry.isShoePair) {
        productBaseTransforms.delete(`${entry.fitKey}:left`);
        productBaseTransforms.delete(`${entry.fitKey}:right`);
    }
    delete PRODUCT_FIT_CONFIG[entry.fitKey];
    catalogSceneItems.delete(sceneItemId);
    if (shouldRender) {
        renderCatalogSceneItems();
        renderProductCatalog();
        if (config.viewer?.catalogMode === true) frameCatalogScene();
    }
}

function renderCatalogSceneItems() {
    if (!catalogSceneItemsContainer) return;
    catalogSceneItemsContainer.replaceChildren();
    if (!catalogSceneItems.size) {
        catalogSceneItemsContainer.appendChild(makeElement(
            "p", "catalog-empty", "Chưa có sản phẩm nào trong phối đồ. Chọn model ở phía trên để thêm vào scene.",
        ));
        return;
    }

    for (const [sceneItemId, entry] of catalogSceneItems) {
        const row = makeElement("div", "scene-item");
        const info = makeElement("div", "scene-item-info");
        info.append(
            makeElement("strong", "scene-item-title", entry.label),
            makeElement("small", "scene-item-meta", catalogCategoryLabel(entry.category)),
        );
        const removeButton = makeElement("button", "scene-item-remove", "Bỏ");
        removeButton.type = "button";
        removeButton.addEventListener("click", () => removeCatalogSceneItem(sceneItemId));
        row.append(info, removeButton);
        catalogSceneItemsContainer.appendChild(row);
    }
}

function orientShoeModelAlongFoot(model, side) {
    const ankleWorld = avatarAnchors[side === "left" ? "ankleLeft" : "ankleRight"];
    const toeWorld = avatarAnchors[side === "left" ? "toeLeft" : "toeRight"];
    if (!ankleWorld || !toeWorld) {
        throw new Error(`Không tìm thấy hướng bàn chân ${side} để căn giày.`);
    }

    // Work in fittingStage-local coordinates because shoes become children of that stage.
    fittingStage.updateWorldMatrix(true, false);
    const ankle = fittingStage.worldToLocal(ankleWorld.clone());
    const toe = fittingStage.worldToLocal(toeWorld.clone());
    const footDirection = toe.sub(ankle);
    if (footDirection.lengthSq() < 1e-8) {
        footDirection.set(0, 0, 1);
    } else {
        footDirection.normalize();
    }

    model.updateWorldMatrix(true, true);
    const originalBounds = computeModelBounds(model);
    const size = originalBounds.size;
    const axes = [
        { name: "x", size: size.x, vector: new THREE.Vector3(1, 0, 0) },
        { name: "y", size: size.y, vector: new THREE.Vector3(0, 1, 0) },
        { name: "z", size: size.z, vector: new THREE.Vector3(0, 0, 1) },
    ].sort((a, b) => b.size - a.size);

    // Most shoe exports have their length along X, Y, or Z depending on the authoring tool.
    // Align the longest model axis to the avatar ankle-to-toe direction before fitting.
    const longestAxis = axes[0];
    const correction = new THREE.Quaternion().setFromUnitVectors(
        longestAxis.vector,
        footDirection,
    );
    model.quaternion.premultiply(correction);
    model.updateWorldMatrix(true, true);

    return {
        originalSize: size.toArray(),
        longestAxis: longestAxis.name,
        footDirection: footDirection.toArray(),
        correctionQuaternion: correction.toArray(),
    };
}

async function addCatalogShoePair(item) {
    const sceneItemId = `mix-${++catalogSequence}`;
    const fitKey = `catalog-fit-${catalogSequence}`;
    const group = new THREE.Group();
    group.name = `LHW shoe pair ${item.label}`;
    const parts = [];
    const sourceProductKey = String(item.productId ?? item.id ?? "");
    const existingFit = mergeProductFitConfig(
        mergeProductFitConfig(
            PRODUCT_FIT_CATEGORY_DEFAULTS.shoes || {
                ...BASIC_FIT_CONFIG,
                category: "shoes",
                normalization: { pivot: "bounds-center", scale: "uniform-contain" },
            },
            PRODUCT_FIT_CONFIG[sourceProductKey] || {},
        ),
        PRODUCT_FIT_ID_OVERRIDES[sourceProductKey] || {},
    );

    // Never distort an individual shoe independently on X/Y/Z. Keep aspect ratio and fit each foot separately.
    PRODUCT_FIT_CONFIG[fitKey] = mergeProductFitConfig(existingFit, {
        category: "shoes",
        positionOffset: [0, 0, 0],
        rotationOffset: [0, 0, 0],
        scaleMultiplier: [1, 1, 1],
        normalization: { pivot: "bounds-center", scale: "uniform-contain" },
        parts: {
            left: {
                positionOffset: [0, 0, 0],
                rotationOffset: [...(existingFit.parts?.left?.rotationOffset || [0, 0, 0])],
                scaleMultiplier: [...(existingFit.parts?.left?.scaleMultiplier || [1, 1, 1])],
                normalization: { pivot: "bounds-center", scale: "uniform-contain" },
            },
            right: {
                positionOffset: [0, 0, 0],
                rotationOffset: [...(existingFit.parts?.right?.rotationOffset || [0, 0, 0])],
                scaleMultiplier: [...(existingFit.parts?.right?.scaleMultiplier || [1, 1, 1])],
                normalization: { pivot: "bounds-center", scale: "uniform-contain" },
            },
        },
    });

    try {
        for (const [side, url] of [["left", item.leftShoeUrl], ["right", item.rightShoeUrl]]) {
            const shoe = await loadGLB(url);
            shoe.name = `${item.label} — ${side === "left" ? "trái" : "phải"}`;
            const orientation = orientShoeModelAlongFoot(shoe, side);
            const sourceBounds = computeModelBounds(shoe);
            // Store the auto-oriented transform as the baseline so fitting does not reset it.
            productBaseTransforms.set(`${fitKey}:${side}`, {
                position: shoe.position.clone(),
                quaternion: shoe.quaternion.clone(),
                scale: shoe.scale.clone(),
            });
            group.add(shoe);
            parts.push({ side, url, model: shoe, sourceBounds, orientation, report: null });
        }

        fittingStage.add(group);
        group.updateWorldMatrix(true, true);
        for (const part of parts) {
            part.report = fitModelToTarget(
                part.model,
                getTargetForShoeFoot(part.side),
                fitKey,
                "shoes",
                part.sourceBounds,
                part.side,
            );

            // A uniform fit may leave a small vertical gap because the target box is
            // intentionally generous. Set the lowest point to floor Y=0 for natural placement.
            const fittedBounds = computeModelBounds(part.model);
            translateRootByWorldDelta(
                part.model,
                new THREE.Vector3(0, -fittedBounds.min.y, 0),
            );
            part.model.updateWorldMatrix(true, true);
            part.report.actualBounds = computeModelBounds(part.model);
            part.report.groundingOffset = -fittedBounds.min.y;
        }

        const sceneEntry = {
            sceneItemId,
            fitKey,
            productId: item.productId,
            label: item.label,
            url: item.url,
            path: item.path,
            category: "shoes",
            model: group,
            parts,
            isShoePair: true,
            report: {
                fitMethod: "foot-anchors + uniform-contain",
                parts: parts.map((part) => ({
                    side: part.side,
                    orientation: part.orientation,
                    target: part.report.target,
                    actualBounds: part.report.actualBounds,
                    groundingOffset: part.report.groundingOffset,
                })),
            },
        };

        // One shoe-pair slot: replacing it removes the prior pair without touching other accessories.
        for (const [otherId, otherEntry] of [...catalogSceneItems.entries()]) {
            if (otherEntry.category === "shoes") removeCatalogSceneItem(otherId, false);
        }
        catalogSceneItems.set(sceneItemId, sceneEntry);
        renderCatalogSceneItems();
        renderProductCatalog();
        frameCatalogScene();
        setStatus(`Đã thêm ${item.label}. Hai chiếc được căn riêng theo bàn chân trái/phải và giữ nguyên tỉ lệ.`);
        console.info("[LHW Studio] Shoe pair fit:", sceneEntry.report);
        return sceneEntry;
    } catch (error) {
        fittingStage.remove(group);
        disposeCatalogModel(group);
        for (const part of parts) productBaseTransforms.delete(`${fitKey}:${part.side}`);
        delete PRODUCT_FIT_CONFIG[fitKey];
        throw error;
    }
}

async function addCatalogModel(item, category) {
    if (!avatar) throw new Error("Avatar ẩn dùng làm mốc kích thước chưa sẵn sàng.");
    const bodyCategories = new Set(["top", "bottom", "shoes"]);
    const slotCategory = bodyCategories.has(category) ? category : null;
    const existingEntry = [...catalogSceneItems.values()].find((entry) => entry.url === item.url);
    if (existingEntry) {
        setStatus(`${item.label} đã có trong phối đồ.`);
        return;
    }

    if (category === "shoes" && item.leftShoeUrl && item.rightShoeUrl) {
        setStatus(`Đang tải đôi giày: ${item.label}…`);
        return addCatalogShoePair(item);
    }

    setStatus(`Đang tải model 3D: ${item.label}…`);
    const model = await loadGLB(item.url);
    const sceneItemId = `mix-${++catalogSequence}`;
    const fitKey = `catalog-fit-${catalogSequence}`;
    const sourceProductKey = String(item.productId ?? item.id ?? "");
    const categoryDefaults = PRODUCT_FIT_CATEGORY_DEFAULTS[category] || {};
    const legacyOrExplicitFit = PRODUCT_FIT_CONFIG[sourceProductKey] || {};
    const idOverride = PRODUCT_FIT_ID_OVERRIDES[sourceProductKey] || {};
    const categoryFallback = {
        ...BASIC_FIT_CONFIG,
        category,
        normalization: {
            pivot: "bounds-center",
            scale: category === "shoes" ? "uniform-contain" :
                (bodyCategories.has(category) ? "axis" : "uniform-contain"),
        },
    };
    const sourceFit = mergeProductFitConfig(
        mergeProductFitConfig(
            mergeProductFitConfig(categoryFallback, categoryDefaults),
            legacyOrExplicitFit,
        ),
        idOverride,
    );
    PRODUCT_FIT_CONFIG[fitKey] = mergeProductFitConfig(sourceFit, {
        category,
        positionOffset: [...(item.positionOffset || sourceFit.positionOffset || [0, 0, 0])],
        rotationOffset: [...(item.rotationOffset || sourceFit.rotationOffset || [0, 0, 0])],
        scaleMultiplier: [...(item.scaleMultiplier || sourceFit.scaleMultiplier || [1, 1, 1])],
        normalization: {
            ...(sourceFit.normalization || {}),
            pivot: "bounds-center",
            scale: category === "shoes" ? "uniform-contain" : (bodyCategories.has(category) ? (sourceFit.normalization?.scale || "axis") : "uniform-contain"),
        },
    });

    try {
        model.name = `LHW Mix ${item.label}`;
        fittingStage.add(model);
        const sourceBounds = computeModelBounds(model);
        productBaseTransforms.set(fitKey, {
            position: model.position.clone(),
            quaternion: model.quaternion.clone(),
            scale: model.scale.clone(),
        });
        const target = getCatalogTarget(category, item);
        const report = fitModelToTarget(model, target, fitKey, category, sourceBounds);

        // Only one main garment per body slot; accessories can be layered together.
        if (slotCategory) {
            for (const [otherId, otherEntry] of [...catalogSceneItems.entries()]) {
                if (otherEntry.category === slotCategory) removeCatalogSceneItem(otherId, false);
            }
        }

        catalogSceneItems.set(sceneItemId, {
            sceneItemId,
            fitKey,
            productId: item.productId,
            label: item.label,
            url: item.url,
            path: item.path,
            category,
            model,
            report,
        });

        renderCatalogSceneItems();
        renderProductCatalog();
        frameCatalogScene();
        setStatus(`Đã thêm ${item.label} vào phối đồ 3D. Đang có ${catalogSceneItems.size} mô hình.`);
        console.log("[LHW Studio] Catalog model fitted:", {
            label: item.label,
            url: item.url,
            category,
            target,
            actualBounds: report.actualBounds,
            scale: model.scale.toArray(),
        });
    } catch (error) {
        fittingStage.remove(model);
        disposeCatalogModel(model);
        productBaseTransforms.delete(fitKey);
        delete PRODUCT_FIT_CONFIG[fitKey];
        throw error;
    }
}

function frameCatalogScene({ animate = false } = {}) {
    if (!catalogSceneItems.size) {
        setCameraView("front");
        return;
    }

    fittingStage.updateWorldMatrix(true, true);
    const bounds = new THREE.Box3();
    for (const entry of catalogSceneItems.values()) {
        if (entry.model) bounds.union(new THREE.Box3().setFromObject(entry.model));
    }
    if (bounds.isEmpty()) return;

    const sphere = bounds.getBoundingSphere(new THREE.Sphere());
    const target = sphere.center.clone();
    const aspect = Math.max(viewer.clientWidth / Math.max(viewer.clientHeight, 1), 0.35);
    const verticalFov = THREE.MathUtils.degToRad(camera.fov);
    const horizontalFov = 2 * Math.atan(Math.tan(verticalFov / 2) * aspect);
    const limitingFov = Math.max(THREE.MathUtils.degToRad(12), Math.min(verticalFov, horizontalFov));
    const radius = Math.max(sphere.radius, avatarHeight * 0.18);
    const distance = (radius / Math.sin(limitingFov / 2)) * 1.22;
    const direction = new THREE.Vector3(0.08, 0.10, 1).normalize();

    controls.target.copy(target);
    camera.position.copy(target).addScaledVector(direction, distance);
    camera.near = Math.max(0.01, distance / 1000);
    camera.far = Math.max(100, distance * 10);
    camera.updateProjectionMatrix();
    controls.update();
}

function clearCatalogScene() {
    for (const sceneItemId of [...catalogSceneItems.keys()]) {
        removeCatalogSceneItem(sceneItemId, false);
    }
    renderCatalogSceneItems();
    renderProductCatalog();
    setCameraView("front");
    setStatus("Đã xóa toàn bộ mô hình khỏi phối đồ 3D.");
}

async function loadOutfit() {
    if (outfitLoadInProgress) return;
    outfitLoadInProgress = true;
    const reloadButton = document.getElementById("reloadOutfit");
    if (reloadButton) reloadButton.disabled = true;

    try {
        if (!avatar) {
            setStatus("Chưa tải được avatar.");
            return;
        }

        const categories = ["top", "bottom", "shoes"];
        const results = [];

        for (const category of categories) {
            results.push(await loadGarment(category, config.outfit[category]));
        }

        renderOutfitStatus(results);
        updateDebugPanel();
    } finally {
        outfitLoadInProgress = false;
        if (reloadButton) reloadButton.disabled = false;
    }
}

document.getElementById("rotateAvatar").addEventListener("click", () => {
    isRotating = !isRotating;
});

document.getElementById("reloadOutfit").addEventListener("click", () => {
    isRotating = false;
    fittingStage.rotation.y = 0;
    fittingStage.updateWorldMatrix(true, true);
    updateAnchors();
    if (config.viewer?.catalogMode === true) {
        clearCatalogScene();
    } else {
        loadOutfit();
    }
});

document.getElementById("resetCamera").addEventListener("click", () => {
    if (config.viewer?.catalogMode === true) frameCatalogScene();
    else setCameraView("front");
});

if (catalogSearchInput) {
    catalogSearchInput.addEventListener("input", renderProductCatalog);
}
if (catalogCategoryFilter) {
    catalogCategoryFilter.addEventListener("change", renderProductCatalog);
}
if (clearCatalogItemsButton) {
    clearCatalogItemsButton.addEventListener("click", clearCatalogScene);
}

function resizeRenderer() {
    const width = viewer.clientWidth;
    const height = viewer.clientHeight;

    if (!width || !height) return;

    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
}

const resizeObserver = new ResizeObserver(resizeRenderer);
resizeObserver.observe(viewer);

function animate(timestamp = 0) {
    requestAnimationFrame(animate);

    if (isRotating) {
        fittingStage.rotation.y += 0.005;
        fittingStage.updateWorldMatrix(true, true);
        updateAnchors();
        updateAnchorHelpers();

        if (timestamp - lastLiveDebugUpdate >= 250) {
            lastLiveDebugUpdate = timestamp;
            for (const [category, report] of productFitMetadata) {
                updateProductHelpers(
                    category,
                    computeModelBounds(clothing[category]),
                );
            }
            updateAvatarHelpers();
            if (!debugPanel.contains(document.activeElement)) {
                updateDebugPanel();
            }
        }
    }

    controls.update();
    renderer.render(scene, camera);
}

async function start() {
    try {
        await loadAvatar();
        if (config.viewer?.catalogMode === true) {
            // Avatar is used only as an invisible reference for garment placement.
            if (avatar) avatar.visible = false;
            const reloadButton = document.getElementById("reloadOutfit");
            if (reloadButton) reloadButton.textContent = "Xóa phối đồ";
            const rotateButton = document.getElementById("rotateAvatar");
            if (rotateButton) rotateButton.textContent = "Bật/tắt xoay mô hình";
            if (debugPanel) debugPanel.hidden = true;
            renderProductCatalog();
            renderCatalogSceneItems();
            setStatus(`Đã ẩn avatar. Tìm thấy ${catalogSourceItems.length} file 3D có thể thêm vào phối đồ.`);
        } else {
            await loadOutfit();
        }
    } catch (error) {
        console.error(error);
        setStatus(`Lỗi khởi tạo: ${error.message}`);
    }
}

window.LHWFittingDebug = {
    get avatar() {
        return avatar;
    },

    get clothing() {
        return clothing;
    },

    get fitConfig() {
        return PRODUCT_FIT_CONFIG;
    },

    get fitMetadata() {
        return productFitMetadata;
    },

    get anchors() {
        return avatarAnchors;
    },

    get scene() {
        return scene;
    },

    get fittingStage() {
        return fittingStage;
    },

    get catalogItems() {
        return [...catalogSceneItems.values()].map(({ model, ...entry }) => entry);
    },

    addCatalogItem(url, category = "generic", label = url) {
        const existing = catalogSourceItems.find((item) => item.url === url) || {
            id: `console-${catalogSequence + 1}`,
            productId: null,
            label,
            path: url,
            url,
            category,
        };
        return addCatalogModel(existing, category);
    },

    clearCatalogItems: clearCatalogScene,
    setCameraView,

    get debugVisibility() {
        return { ...debugVisibility };
    },

    setSelection(selection) {
        debugSelection = selection;
        updateDebugPanel();
    },

    applyFittingPose,
    resetAvatarPose,

    getFitReport(category) {
        const report = productFitMetadata.get(category);
        const model = clothing[category];
        if (!report || !model) return null;

        model.updateWorldMatrix(true, true);
        fittingStage.updateWorldMatrix(true, false);

        const actual = computeModelBounds(model);
        const targetCenter = report.targetLocalCenter
            .clone()
            .applyMatrix4(fittingStage.matrixWorld);
        const targetBox = new THREE.Box3(
            report.targetLocalCenter
                .clone()
                .sub(report.target.size.clone().multiplyScalar(0.5)),
            report.targetLocalCenter
                .clone()
                .add(report.target.size.clone().multiplyScalar(0.5)),
        ).applyMatrix4(fittingStage.matrixWorld);
        const worldPosition = model.getWorldPosition(new THREE.Vector3());
        const worldQuaternion = model.getWorldQuaternion(
            new THREE.Quaternion(),
        );
        const vector = (value) => value.toArray().map((n) => +n.toFixed(6));
        const box = (value) => ({
            min: vector(value.min),
            max: vector(value.max),
            center: vector(value.center),
            size: vector(value.size),
        });

        return {
            productId: report.productId,
            category: report.category,
            fitMethod: report.fitMethod || "legacy-bounds",
            autoFitFallbackReason: report.autoFitFallbackReason || null,
            landmarkReport: report.landmarkReport
                ? {
                      ...report.landmarkReport,
                      pairs: report.landmarkReport.pairs.map((pair) => ({
                          ...pair,
                      })),
                      transform: report.landmarkReport.transform
                          ? {
                                coordinateSpace:
                                    report.landmarkReport.transform
                                        .coordinateSpace,
                                scale: report.landmarkReport.transform.scale,
                                rotation:
                                    report.landmarkReport.transform.rotation
                                        .toArray()
                                        .map((n) => +n.toFixed(6)),
                                translation: vector(
                                    report.landmarkReport.transform.translation,
                                ),
                            }
                          : null,
                  }
                : null,
            geometryAnalysis: report.geometryAnalysis || null,
            landmarkDiagnostic: report.landmarkDiagnostic || null,
            autoFitAttempt: report.autoFitAttempt || null,
            fitValidation: report.fitValidation
                ? {
                      valid: report.fitValidation.valid,
                      method: report.fitValidation.method || null,
                      reason: report.fitValidation.reason || null,
                      note: report.fitValidation.note || null,
                      maxRmsError: report.fitValidation.maxRmsError ?? null,
                      preFitRmsError:
                          report.fitValidation.preFitRmsError ?? null,
                      scaleRange: report.fitValidation.scaleRange
                          ? [...report.fitValidation.scaleRange]
                          : null,
                      preFitBounds: report.fitValidation.preFitBounds
                          ? box(report.fitValidation.preFitBounds)
                          : null,
                      postFitBounds: report.fitValidation.postFitBounds
                          ? box(report.fitValidation.postFitBounds)
                          : null,
                  }
                : null,
            scaleFactor: report.scaleFactor ? vector(report.scaleFactor) : null,
            sourceRoot: {
                position: vector(report.rawRootTransform.position),
                quaternion: report.rawRootTransform.quaternion
                    .toArray()
                    .map((n) => +n.toFixed(6)),
                scale: vector(report.rawRootTransform.scale),
            },
            root: {
                position: vector(model.position),
                worldPosition: vector(worldPosition),
                rotation: [
                    model.rotation.x,
                    model.rotation.y,
                    model.rotation.z,
                ].map((n) => +n.toFixed(6)),
                worldQuaternion: worldQuaternion
                    .toArray()
                    .map((n) => +n.toFixed(6)),
                scale: vector(model.scale),
            },
            rawBounds: box(report.rawBounds),
            meshSummary: report.meshSummary.map((mesh) => ({
                name: mesh.name,
                vertices: mesh.vertices,
                indices: mesh.indices,
                triangles: mesh.triangles,
                localPosition: vector(mesh.localPosition),
                localRotation: [
                    mesh.localRotation.x,
                    mesh.localRotation.y,
                    mesh.localRotation.z,
                ].map((n) => +n.toFixed(6)),
                localScale: vector(mesh.localScale),
                materials: mesh.materials.map((material) => ({ ...material })),
            })),
            normalizedBounds: box(report.normalizedBounds),
            target: {
                center: vector(targetCenter),
                size: vector(targetBox.getSize(new THREE.Vector3())),
            },
            actual: box(actual),
            centerDelta: vector(actual.center.clone().sub(targetCenter)),
            config: {
                positionOffset: [...report.config.positionOffset],
                rotationOffset: [...report.config.rotationOffset],
                scaleMultiplier: [...report.config.scaleMultiplier],
            },
        };
    },

    getSceneSummary() {
        const meshCount = (model) => {
            if (!model) return 0;
            let count = 0;
            model.traverse((object) => {
                if (object.isMesh) count += 1;
            });
            return count;
        };

        return {
            stageChildren: fittingStage.children.map((child) => ({
                name: child.name || child.type,
                type: child.type,
            })),
            clothingModels: Object.fromEntries(
                Object.entries(clothing).map(([category, model]) => [
                    category,
                    meshCount(model),
                ]),
            ),
            productModelCount: Object.values(clothing).filter(Boolean).length,
            rotations: Object.fromEntries(
                Object.entries(clothing).map(([category, model]) => [
                    category,
                    model
                        ? [model.rotation.x, model.rotation.y, model.rotation.z]
                        : null,
                ]),
            ),
        };
    },

    getPoseReport() {
        const report = {};
        const names = [
            "shoulderLeft",
            "upperArmLeft",
            "forearmLeft",
            "handLeft",
            "shoulderRight",
            "upperArmRight",
            "forearmRight",
            "handRight",
        ];

        avatar?.updateWorldMatrix(true, true);
        for (const name of names) {
            const bone = findBone(name);
            if (!bone) {
                report[name] = null;
                continue;
            }
            const worldPosition = bone.getWorldPosition(new THREE.Vector3());
            report[name] = {
                bone: bone.name,
                parent: bone.parent?.name || null,
                localPosition: bone.position.toArray(),
                localQuaternion: bone.quaternion.toArray(),
                worldPosition: worldPosition.toArray(),
            };
        }
        return { fittingPose: applyingFittingPose, joints: report };
    },

    inspectProduct(category = "shoes") {
        const model = clothing[category];

        if (!model) {
            console.warn(
                `Chưa có mô hình ${category}. Kiểm tra xem GLB đã tải thành công chưa.`,
            );
            return null;
        }

        model.updateWorldMatrix(true, true);

        const rows = [];

        model.traverse((object) => {
            if (!object.isMesh && !object.isGroup) return;

            const position = new THREE.Vector3();
            object.getWorldPosition(position);

            let bounds = null;

            if (object.isMesh) {
                const box = new THREE.Box3().setFromObject(object);
                const size = box.getSize(new THREE.Vector3());
                const center = box.getCenter(new THREE.Vector3());
                bounds = {
                    center: center.toArray().map((n) => +n.toFixed(3)),
                    size: size.toArray().map((n) => +n.toFixed(3)),
                    min: box.min.toArray().map((n) => +n.toFixed(3)),
                    max: box.max.toArray().map((n) => +n.toFixed(3)),
                };
            }

            rows.push({
                type: object.isMesh ? "Mesh" : "Group",
                name: object.name || "(unnamed)",
                parent: object.parent?.name || "(root)",
                visible: object.visible,
                x: Number(position.x.toFixed(3)),
                y: Number(position.y.toFixed(3)),
                z: Number(position.z.toFixed(3)),
                bounds,
            });
        });

        console.log(`LHW Product inspection: ${category}`);
        console.log("Root position:", model.position);
        console.log("Root rotation:", model.rotation);
        console.log("Root scale:", model.scale);
        console.table(rows);

        return rows;
    },
};

animate();
start();
