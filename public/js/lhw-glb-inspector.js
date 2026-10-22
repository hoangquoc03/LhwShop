import * as THREE from "three";
import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";
import {
    classifyGLBLoadError,
    createGLBFailureReport,
    inspectGLBData,
} from "./lhw-glb-inspector-core.js";

function objectPath(object) {
    const segments = [];
    for (let current = object; current; current = current.parent) {
        if (current.name) segments.unshift(current.name);
        else segments.unshift(`<${current.type}>`);
    }
    return `/${segments.join("/")}`;
}

function boundsRecord(object) {
    const bounds = new THREE.Box3().setFromObject(object);
    if (bounds.isEmpty()) return null;
    return {
        min: bounds.min.toArray(),
        max: bounds.max.toArray(),
    };
}

function nodeRecord(object) {
    const localPosition = object.position.toArray();
    const worldPosition = object
        .getWorldPosition(new THREE.Vector3())
        .toArray();
    const localQuaternion = object.quaternion.toArray();
    const localScale = object.scale.toArray();
    const parent = object.parent
        ? {
              name: object.parent.name || null,
              path: objectPath(object.parent),
              localPosition: object.parent.position.toArray(),
              localQuaternion: object.parent.quaternion.toArray(),
              localScale: object.parent.scale.toArray(),
              worldQuaternion: object.parent
                  .getWorldQuaternion(new THREE.Quaternion())
                  .toArray(),
              worldScale: object.parent
                  .getWorldScale(new THREE.Vector3())
                  .toArray(),
              worldPosition: object.parent
                  .getWorldPosition(new THREE.Vector3())
                  .toArray(),
              localMatrix: object.parent.matrix.toArray(),
              worldMatrix: object.parent.matrixWorld.toArray(),
          }
        : null;
    return {
        name: object.name || "",
        type: object.type,
        path: objectPath(object),
        parent,
        isObject3D: object.isObject3D === true,
        localPosition,
        localQuaternion,
        localScale,
        worldQuaternion: object
            .getWorldQuaternion(new THREE.Quaternion())
            .toArray(),
        worldScale: object.getWorldScale(new THREE.Vector3()).toArray(),
        worldPosition,
        localMatrix: object.matrix.toArray(),
        worldMatrix: object.matrixWorld.toArray(),
    };
}

function collectInspectionData(scene) {
    scene.updateMatrixWorld(true);
    const nodes = [];
    const meshes = [];
    const resources = {
        geometries: new Set(),
        materials: new Set(),
        textures: new Set(),
    };

    scene.traverse((object) => {
        nodes.push(nodeRecord(object));
        if (!object.isMesh) return;

        meshes.push({
            name: object.name || "",
            path: objectPath(object),
            bounds: boundsRecord(object),
        });
        if (object.geometry) resources.geometries.add(object.geometry);
        for (const material of Array.isArray(object.material)
            ? object.material
            : [object.material]) {
            if (!material) continue;
            resources.materials.add(material);
            for (const value of Object.values(material)) {
                if (value?.isTexture) resources.textures.add(value);
            }
        }
    });

    return {
        nodes,
        meshes,
        bounds: boundsRecord(scene),
        resources,
    };
}

function disposeResources(resources) {
    resources.geometries.forEach((geometry) => geometry.dispose());
    resources.materials.forEach((material) => material.dispose());
    resources.textures.forEach((texture) => texture.dispose());
}

export async function inspectGLB({
    url,
    productId = null,
    category,
    expectedLandmarksByCategory = {},
    fittingStage = null,
    unitToMeters = null,
    loader = new GLTFLoader(),
}) {
    let resources = null;
    let parsedUrl;
    try {
        parsedUrl = new URL(url, window.location.href);
        if (!["http:", "https:"].includes(parsedUrl.protocol)) {
            throw new Error("Only HTTP and HTTPS GLB URLs are supported.");
        }
    } catch (error) {
        return createGLBFailureReport(url, error, {
            productId,
            category,
            expectedLandmarksByCategory,
            code: "glb-input-invalid",
            failureStage: "input",
        });
    }

    let gltf;
    try {
        gltf = await new Promise((resolve, reject) => {
            loader.load(parsedUrl.href, resolve, undefined, reject);
        });
    } catch (error) {
        const code = classifyGLBLoadError(error);
        return createGLBFailureReport(url, error, {
            productId,
            category,
            expectedLandmarksByCategory,
            code,
            failureStage: code === "glb-parse-failed" ? "parse" : "load",
        });
    }

    try {
        const scene = gltf.scene;
        if (!scene?.isObject3D) {
            return createGLBFailureReport(
                url,
                new Error("GLTF has no valid scene."),
                {
                    productId,
                    category,
                    expectedLandmarksByCategory,
                    code: "glb-parse-failed",
                    failureStage: "parse",
                },
            );
        }
        const data = collectInspectionData(scene);
        resources = data.resources;
        let fittingStageInverseMatrix = null;
        let fittingStageWorldMatrix = null;
        if (fittingStage?.isObject3D) {
            fittingStage.updateWorldMatrix(true, false);
            fittingStageWorldMatrix = fittingStage.matrixWorld.toArray();
            fittingStageInverseMatrix = fittingStage.matrixWorld
                .clone()
                .invert()
                .toArray();
        }
        const report = inspectGLBData({
            url: parsedUrl.href,
            productId,
            category,
            expectedLandmarksByCategory,
            nodes: data.nodes,
            meshes: data.meshes,
            bounds: data.bounds,
            fittingStageInverseMatrix,
            fittingStageWorldMatrix,
            unitToMeters,
            assetMetadata: gltf.parser?.json?.asset || null,
        });

        return report;
    } catch (error) {
        return createGLBFailureReport(url, error, {
            productId,
            category,
            expectedLandmarksByCategory,
            code: "inspection-failed",
            failureStage: "inspection",
        });
    } finally {
        if (resources) disposeResources(resources);
    }
}
