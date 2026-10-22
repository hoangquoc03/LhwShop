import os
import sys

import bpy
from mathutils import Vector


if "--" not in sys.argv:
    raise SystemExit("Usage: blender --background --python render_shoe_candidates.py -- <output-dir>")

output_dir = sys.argv[sys.argv.index("--") + 1]
os.makedirs(output_dir, exist_ok=True)

root = os.path.abspath(os.path.join(os.path.dirname(__file__), ".."))
assets = {
    "original-pair": os.path.join(root, "public", "models", "products", "22", "product.glb"),
    "left-candidate": os.path.join(root, "public", "models", "products", "22", "left-shoe.glb"),
    "right-candidate": os.path.join(root, "public", "models", "products", "22", "right-shoe.glb"),
}

views = {
    "front": Vector((0, 0, 1)),
    "back": Vector((0, 0, -1)),
    "side": Vector((1, 0, 0)),
    "45": Vector((1, 0, 1)),
    "top": Vector((0, 1, 0)),
}


def clear_scene():
    bpy.ops.object.select_all(action="SELECT")
    bpy.ops.object.delete(use_global=False)


def add_camera(center, direction, extent):
    data = bpy.data.cameras.new("Inspection camera")
    camera = bpy.data.objects.new("Inspection camera", data)
    bpy.context.collection.objects.link(camera)
    camera.location = center + direction.normalized() * max(extent * 2.6, 0.5)
    camera.rotation_euler = (center - camera.location).to_track_quat("-Z", "Y").to_euler()
    data.type = "ORTHO"
    data.ortho_scale = max(extent * 1.5, 0.2)
    bpy.context.scene.camera = camera
    return camera


for asset_name, filepath in assets.items():
    clear_scene()
    bpy.ops.import_scene.gltf(filepath=filepath)
    meshes = [obj for obj in bpy.context.scene.objects if obj.type == "MESH"]
    if not meshes:
        raise RuntimeError(f"No mesh found in {filepath}")

    points = [
        obj.matrix_world @ vertex.co
        for obj in meshes
        for vertex in obj.data.vertices
    ]
    minimum = Vector(tuple(min(point[axis] for point in points) for axis in range(3)))
    maximum = Vector(tuple(max(point[axis] for point in points) for axis in range(3)))
    center = (minimum + maximum) * 0.5
    extent = max(maximum - minimum)

    scene = bpy.context.scene
    scene.render.engine = "BLENDER_EEVEE"
    scene.render.resolution_x = 900
    scene.render.resolution_y = 700
    scene.render.resolution_percentage = 100
    scene.render.image_settings.file_format = "PNG"
    scene.render.film_transparent = False
    scene.world.color = (0.08, 0.08, 0.08)

    key_data = bpy.data.lights.new("Inspection key", "AREA")
    key = bpy.data.objects.new("Inspection key", key_data)
    bpy.context.collection.objects.link(key)
    key.location = center + Vector((extent, extent * 1.2, extent * 1.5))
    key_data.energy = 1800
    key_data.size = extent

    fill_data = bpy.data.lights.new("Inspection fill", "AREA")
    fill = bpy.data.objects.new("Inspection fill", fill_data)
    bpy.context.collection.objects.link(fill)
    fill.location = center + Vector((-extent, extent * 0.3, -extent))
    fill_data.energy = 900
    fill_data.size = extent

    print(f"{asset_name}: meshes={len(meshes)}, center={tuple(center)}, size={tuple(maximum - minimum)}")
    for view_name, direction in views.items():
        camera = add_camera(center, direction, extent)
        scene.render.filepath = os.path.join(output_dir, f"{asset_name}-{view_name}.png")
        bpy.ops.render.render(write_still=True)
        bpy.data.objects.remove(camera, do_unlink=True)

    bpy.data.objects.remove(key, do_unlink=True)
    bpy.data.objects.remove(fill, do_unlink=True)

print(f"Rendered candidates and original into {output_dir}")
