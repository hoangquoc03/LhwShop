"""Re-export an already-authored LHW Blender scene with explicit landmark selection.

Run with Blender opening the saved .blend work file, for example:
  blender.exe "...\\product-13-YYYYMMDD-HHMMSS.blend" --background --python "...\\lhw_export_existing_landmarks.py"

This script does not import the original product and does not overwrite any GLB.
It writes product.landmarked-v2.glb, then checks the exported GLB JSON node names.
"""

import json
import math
import struct
import sys
from pathlib import Path

import bpy

ROOT = Path(__file__).resolve().parent.parent
LANDMARKS = {
    "top": [
        "LHW_Neck",
        "LHW_Shoulder_L",
        "LHW_Shoulder_R",
        "LHW_Hem",
        "LHW_Chest_Front",
        "LHW_Back_Center",
    ],
    "bottom": [
        "LHW_Waist",
        "LHW_Crotch",
        "LHW_Knee_L",
        "LHW_Knee_R",
        "LHW_Hem_L",
        "LHW_Hem_R",
        "LHW_Waist_Front",
    ],
}


def read_glb_json(glb_path: Path) -> dict:
    """Read the JSON chunk from a GLB 2.0 file without third-party packages."""
    with glb_path.open("rb") as stream:
        header = stream.read(12)
        if len(header) != 12:
            raise RuntimeError("Exported file is too small to be a GLB.")
        magic, version, total_length = struct.unpack("<4sII", header)
        if magic != b"glTF" or version != 2:
            raise RuntimeError("Exported file does not have a valid GLB 2.0 header.")
        actual_size = glb_path.stat().st_size
        if total_length != actual_size:
            raise RuntimeError(
                f"GLB header length ({total_length}) differs from file size ({actual_size})."
            )
        bytes_read = 12
        while bytes_read + 8 <= total_length:
            chunk_header = stream.read(8)
            if len(chunk_header) != 8:
                break
            chunk_length, chunk_type = struct.unpack("<II", chunk_header)
            chunk_data = stream.read(chunk_length)
            if len(chunk_data) != chunk_length:
                raise RuntimeError("GLB chunk ended unexpectedly.")
            bytes_read += 8 + chunk_length
            if chunk_type == 0x4E4F534A:  # JSON
                try:
                    return json.loads(chunk_data.decode("utf-8").rstrip(" \t\r\n\x00"))
                except (UnicodeDecodeError, json.JSONDecodeError) as exc:
                    raise RuntimeError(f"Could not parse the GLB JSON chunk: {exc}") from exc
        raise RuntimeError("No JSON chunk was found in the exported GLB.")


def main() -> None:
    scene = bpy.context.scene
    required_scene_keys = (
        "lhw_product_id",
        "lhw_category",
        "lhw_source_collection",
        "lhw_marker_collection",
    )
    missing_scene_keys = [key for key in required_scene_keys if key not in scene]
    if missing_scene_keys:
        raise RuntimeError(
            "The opened .blend is not a saved LHW landmark-authoring scene. Missing scene keys: "
            + ", ".join(missing_scene_keys)
        )

    product_id = str(scene["lhw_product_id"])
    category = str(scene["lhw_category"])
    if category not in LANDMARKS:
        raise RuntimeError(f"Unsupported product category in saved scene: {category!r}")
    required = LANDMARKS[category]

    source_collection = bpy.data.collections.get(scene["lhw_source_collection"])
    marker_collection = bpy.data.collections.get(scene["lhw_marker_collection"])
    if source_collection is None or marker_collection is None:
        raise RuntimeError("The saved scene is missing the source or landmark collection.")

    meshes = [obj for obj in source_collection.objects if obj.type == "MESH"]
    if not meshes:
        raise RuntimeError("No directly linked garment mesh was found in the source collection.")

    markers_by_name = {}
    for obj in list(marker_collection.objects):
        if obj.get("lhw_landmark_marker") or obj.name in required:
            markers_by_name.setdefault(obj.name, []).append(obj)

    missing = [name for name in required if len(markers_by_name.get(name, [])) == 0]
    duplicates = [name for name in required if len(markers_by_name.get(name, [])) > 1]
    if missing or duplicates:
        raise RuntimeError(
            f"Saved .blend is not ready for export. Missing={missing or 'none'}; "
            f"duplicates={duplicates or 'none'}."
        )

    for name in required:
        point = markers_by_name[name][0].matrix_world.translation
        if not all(math.isfinite(float(value)) for value in point):
            raise RuntimeError(f"Landmark {name} has a non-finite world position.")

    # Explicitly include direct garment meshes AND direct landmark marker objects.
    # Do not rely on recursive collection selection when exporting selected objects.
    marker_objects = [markers_by_name[name][0] for name in required]
    selected = list(dict.fromkeys(meshes + marker_objects))
    view_layer = bpy.context.view_layer
    view_layer_names = {obj.name for obj in view_layer.objects}
    not_in_view_layer = [obj.name for obj in selected if obj.name not in view_layer_names]
    if not_in_view_layer:
        raise RuntimeError(
            "These required export objects are not in the active view layer: "
            + ", ".join(not_in_view_layer)
        )

    product_dir = ROOT / "public" / "models" / "products" / product_id
    output_path = product_dir / "product.landmarked-v2.glb"
    source_path = product_dir / "product.glb"
    if not source_path.is_file():
        raise RuntimeError(f"Original GLB was not found: {source_path}")
    if output_path.resolve() == source_path.resolve():
        raise RuntimeError("Refusing to overwrite the original product.glb.")
    if output_path.exists():
        raise FileExistsError(
            f"Output already exists; script will not overwrite it: {output_path}"
        )

    for obj in list(view_layer.objects):
        obj.select_set(False)
    for obj in selected:
        obj.select_set(True)
    view_layer.objects.active = meshes[0]

    print("[LHW Landmark Re-Export] Explicit export objects:")
    for obj in selected:
        print(f"  - {obj.name!r} ({obj.type})")
    print(f"[LHW Landmark Re-Export] Output: {output_path}")

    product_dir.mkdir(parents=True, exist_ok=True)
    result = bpy.ops.export_scene.gltf(
        filepath=str(output_path),
        export_format="GLB",
        use_selection=True,
        export_apply=False,
        export_texcoords=True,
        export_normals=True,
        export_materials="EXPORT",
        export_image_format="AUTO",
        export_cameras=False,
        export_lights=False,
        export_extras=True,
    )
    if "FINISHED" not in result or not output_path.is_file():
        raise RuntimeError("Blender glTF exporter did not finish or produced no file.")

    glb_json = read_glb_json(output_path)
    exported_names = {
        node.get("name") for node in glb_json.get("nodes", []) if isinstance(node, dict)
    }
    missing_exported = [name for name in required if name not in exported_names]
    print(f"[LHW Landmark Re-Export] Exported nodes: {len(glb_json.get('nodes', []))}")
    print(f"[LHW Landmark Re-Export] Landmarks in GLB: {len(required) - len(missing_exported)}/{len(required)}")
    print(f"[LHW Landmark Re-Export] GLB file: {output_path} ({output_path.stat().st_size} bytes)")
    if missing_exported:
        raise RuntimeError(
            "Export completed but the GLB is still missing landmark node(s): "
            + ", ".join(missing_exported)
            + ". Do not enable Auto-Fit. Preserve this file for debugging."
        )
    print("[LHW Landmark Re-Export] PASS: all required landmark node names are in the GLB.")


try:
    main()
except Exception as exc:
    print(f"[LHW Landmark Re-Export] ERROR: {exc}", file=sys.stderr)
    raise
