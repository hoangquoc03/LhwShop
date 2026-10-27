"""Interactive, non-destructive landmark authoring for LHW product GLBs."""

import argparse
import math
import sys
from datetime import datetime
from pathlib import Path

import bpy
from bpy.props import StringProperty
from bpy_extras import view3d_utils


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


def script_arguments():
    argv = sys.argv[sys.argv.index("--") + 1 :] if "--" in sys.argv else []
    parser = argparse.ArgumentParser()
    parser.add_argument("--product-id", choices=("13", "17"), default="13")
    return parser.parse_args(argv)


def report_error(message):
    print(f"[LHW Landmark Authoring] ERROR: {message}", file=sys.stderr)


class LHW_OT_place_landmark(bpy.types.Operator):
    bl_idname = "lhw.place_landmark"
    bl_label = "Place landmark on garment"
    bl_options = {"REGISTER", "UNDO"}

    landmark_name: StringProperty()

    def invoke(self, context, event):
        if context.area.type != "VIEW_3D":
            self.report({"ERROR"}, "Start placement from a 3D View.")
            return {"CANCELLED"}
        self.area = context.area
        self.region = next(
            (region for region in context.area.regions if region.type == "WINDOW"),
            None,
        )
        self.region_data = context.area.spaces.active.region_3d
        if self.region is None or self.region_data is None:
            self.report({"ERROR"}, "The 3D View window region is unavailable.")
            return {"CANCELLED"}
        self.mesh_names = set(
            obj.name
            for obj in bpy.data.collections[
                context.scene["lhw_source_collection"]
            ].all_objects
            if obj.type == "MESH"
        )
        if not self.mesh_names:
            self.report({"ERROR"}, "The imported garment has no mesh objects.")
            return {"CANCELLED"}
        context.window_manager.modal_handler_add(self)
        self.report(
            {"INFO"},
            f"Click the garment surface to place {self.landmark_name}; Esc cancels.",
        )
        return {"RUNNING_MODAL"}

    def modal(self, context, event):
        if event.type in {"ESC", "RIGHTMOUSE"}:
            return {"CANCELLED"}
        if event.type != "LEFTMOUSE" or event.value != "PRESS":
            return {"PASS_THROUGH"}
        if context.area != self.area:
            return {"PASS_THROUGH"}

        coordinate = (
            event.mouse_x - self.region.x,
            event.mouse_y - self.region.y,
        )
        origin = view3d_utils.region_2d_to_origin_3d(
            self.region, self.region_data, coordinate
        )
        direction = view3d_utils.region_2d_to_vector_3d(
            self.region, self.region_data, coordinate
        )
        point = self.raycast_garment(context, origin, direction)
        if point is None:
            self.report({"WARNING"}, "Click a visible surface of the imported garment.")
            return {"RUNNING_MODAL"}

        marker_collection = bpy.data.collections[
            context.scene["lhw_marker_collection"]
        ]
        marker = bpy.data.objects.get(self.landmark_name)
        if marker is None:
            marker = bpy.data.objects.new(self.landmark_name, None)
            marker.empty_display_type = "SPHERE"
            marker.empty_display_size = 0.02
            marker["lhw_landmark_marker"] = True
            marker_collection.objects.link(marker)
        elif marker.name not in marker_collection.objects:
            self.report({"ERROR"}, f"{self.landmark_name} already exists outside the marker collection.")
            return {"CANCELLED"}

        marker.location = point
        marker.rotation_euler = (0.0, 0.0, 0.0)
        marker.scale = (1.0, 1.0, 1.0)
        context.view_layer.update()
        self.report({"INFO"}, f"Placed {self.landmark_name} on the clicked mesh surface.")
        return {"FINISHED"}

    def raycast_garment(self, context, origin, direction):
        depsgraph = context.evaluated_depsgraph_get()
        closest_point = None
        closest_distance = math.inf
        for name in self.mesh_names:
            original = bpy.data.objects.get(name)
            if original is None:
                continue
            evaluated = original.evaluated_get(depsgraph)
            inverse = evaluated.matrix_world.inverted_safe()
            local_origin = inverse @ origin
            local_direction = (inverse.to_3x3() @ direction).normalized()
            # Blender's Object.ray_cast() returns:
            # (result/hit: bool, location: Vector, normal: Vector, index: int).
            # Keep this order: placing `hit` last makes _location a bool and
            # causes Matrix @ bool to raise a TypeError.
            hit, hit_location, _normal, _index = evaluated.ray_cast(
                local_origin, local_direction
            )
            if not hit:
                continue
            if not all(math.isfinite(float(value)) for value in hit_location):
                continue
            world_point = evaluated.matrix_world @ hit_location
            ray_distance = (world_point - origin).dot(direction)
            if 0 <= ray_distance < closest_distance:
                closest_point = world_point
                closest_distance = ray_distance
        return closest_point


class LHW_OT_place_next_landmark(bpy.types.Operator):
    bl_idname = "lhw.place_next_landmark"
    bl_label = "Place next missing landmark"

    def execute(self, context):
        scene = context.scene
        names = LANDMARKS[scene["lhw_category"]]
        marker_collection = bpy.data.collections[scene["lhw_marker_collection"]]
        present = {obj.name for obj in marker_collection.objects}
        next_name = next((name for name in names if name not in present), None)
        if next_name is None:
            self.report({"INFO"}, "All configured landmarks have markers. Use each name button to re-place one.")
            return {"FINISHED"}
        bpy.ops.lhw.place_landmark("INVOKE_DEFAULT", landmark_name=next_name)
        return {"FINISHED"}


class LHW_OT_export_landmarked_glb(bpy.types.Operator):
    bl_idname = "lhw.export_landmarked_glb"
    bl_label = "Export separate landmarked GLB"

    def execute(self, context):
        scene = context.scene
        marker_collection = bpy.data.collections[scene["lhw_marker_collection"]]
        source_collection = bpy.data.collections[scene["lhw_source_collection"]]
        required = LANDMARKS[scene["lhw_category"]]
        markers_by_name = {}
        for obj in marker_collection.objects:
            markers_by_name.setdefault(obj.name, []).append(obj)
        missing = [name for name in required if name not in markers_by_name]
        duplicates = [
            name for name in required if len(markers_by_name.get(name, [])) > 1
        ]
        if missing or duplicates:
            self.report(
                {"ERROR"},
                f"Cannot export: missing={missing or 'none'}; duplicate={duplicates or 'none'}.",
            )
            return {"CANCELLED"}

        output_path = Path(scene["lhw_output_path"]).resolve()
        source_path = Path(scene["lhw_source_path"]).resolve()
        if output_path == source_path:
            self.report({"ERROR"}, "Output path must differ from the original GLB.")
            return {"CANCELLED"}
        if output_path.exists():
            self.report(
                {"ERROR"},
                f"Output already exists; choose a new path instead of overwriting: {output_path}",
            )
            return {"CANCELLED"}

        for name in required:
            position = markers_by_name[name][0].matrix_world.translation
            if not all(math.isfinite(value) for value in position):
                self.report({"ERROR"}, f"{name} has a non-finite world position.")
                return {"CANCELLED"}

        output_path.parent.mkdir(parents=True, exist_ok=True)
        selected = list(source_collection.all_objects)
        bpy.ops.object.select_all(action="DESELECT")
        for obj in selected:
            obj.select_set(True)
        if selected:
            context.view_layer.objects.active = selected[0]

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
            self.report({"ERROR"}, "Blender did not produce the requested GLB.")
            return {"CANCELLED"}

        work_directory = ROOT / "tools" / "landmark-work"
        work_directory.mkdir(parents=True, exist_ok=True)
        work_path = work_directory / (
            f"product-{scene['lhw_product_id']}-"
            f"{datetime.now().strftime('%Y%m%d-%H%M%S-%f')}.blend"
        )
        bpy.ops.wm.save_as_mainfile(filepath=str(work_path))
        self.report(
            {"INFO"},
            f"Exported copy to {output_path}. Inspect it with /glb-inspector before enabling landmark Auto-Fit.",
        )
        return {"FINISHED"}


class LHW_PT_landmark_authoring(bpy.types.Panel):
    bl_label = "LHW Landmark Authoring"
    bl_idname = "LHW_PT_landmark_authoring"
    bl_space_type = "VIEW_3D"
    bl_region_type = "UI"
    bl_category = "LHW"

    def draw(self, context):
        layout = self.layout
        scene = context.scene
        layout.label(text=f"Product {scene['lhw_product_id']} - {scene['lhw_category']}")
        layout.label(text="Click the mesh surface; no coordinates are guessed.")
        layout.operator("lhw.place_next_landmark", icon="EMPTY_AXIS")
        for name in LANDMARKS[scene["lhw_category"]]:
            layout.operator(
                "lhw.place_landmark",
                text=f"Place / re-place {name}",
                icon="EMPTY_SINGLE_ARROW",
            ).landmark_name = name
        layout.separator()
        layout.prop(scene, '["lhw_output_path"]', text="Output GLB")
        layout.operator("lhw.export_landmarked_glb", icon="EXPORT")


CLASSES = (
    LHW_OT_place_landmark,
    LHW_OT_place_next_landmark,
    LHW_OT_export_landmarked_glb,
    LHW_PT_landmark_authoring,
)


def start_authoring():
    arguments = script_arguments()
    product_id = arguments.product_id
    category = "top" if product_id == "13" else "bottom"
    product_directory = ROOT / "public" / "models" / "products" / product_id
    source_path = product_directory / "product.glb"
    output_path = product_directory / "product.landmarked.glb"
    if not source_path.is_file():
        raise FileNotFoundError(f"Original product GLB was not found: {source_path}")

    before = set(bpy.data.objects)
    bpy.ops.import_scene.gltf(filepath=str(source_path))
    imported = [obj for obj in bpy.data.objects if obj not in before]
    if not any(obj.type == "MESH" for obj in imported):
        raise RuntimeError("GLB import produced no garment mesh objects.")

    source_collection = bpy.data.collections.new(
        f"LHW_PRODUCT_{product_id}_SOURCE_COPY"
    )
    bpy.context.scene.collection.children.link(source_collection)
    for obj in imported:
        for collection in list(obj.users_collection):
            collection.objects.unlink(obj)
        source_collection.objects.link(obj)

    marker_collection = bpy.data.collections.new(
        f"LHW_PRODUCT_{product_id}_LANDMARKS"
    )
    source_collection.children.link(marker_collection)
    scene = bpy.context.scene
    scene["lhw_product_id"] = product_id
    scene["lhw_category"] = category
    scene["lhw_source_path"] = str(source_path)
    scene["lhw_source_collection"] = source_collection.name
    scene["lhw_marker_collection"] = marker_collection.name
    scene["lhw_output_path"] = str(output_path)

    for cls in CLASSES:
        bpy.utils.register_class(cls)
    print(
        "[LHW Landmark Authoring] Imported original as a working copy. "
        "Place each named marker by clicking the garment mesh in the 3D View."
    )


try:
    start_authoring()
except Exception as error:
    report_error(error)
    raise
