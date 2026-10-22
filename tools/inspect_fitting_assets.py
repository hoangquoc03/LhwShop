import json
import os
from array import array

import bpy
import bmesh
from mathutils import Vector


ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), ".."))
OUTPUT = os.path.join(os.environ.get("TEMP", ROOT), "lhw-fitting-asset-inspection")
os.makedirs(OUTPUT, exist_ok=True)


def clear_scene():
    bpy.ops.object.select_all(action="SELECT")
    bpy.ops.object.delete(use_global=False)


def bounds_for_points(points):
    points = list(points)
    if not points:
        return None
    minimum = [min(point[i] for point in points) for i in range(3)]
    maximum = [max(point[i] for point in points) for i in range(3)]
    return {
        "min": minimum,
        "max": maximum,
        "center": [(minimum[i] + maximum[i]) / 2 for i in range(3)],
        "size": [maximum[i] - minimum[i] for i in range(3)],
    }


def material_report(material):
    images = []
    if material.use_nodes and material.node_tree:
        for node in material.node_tree.nodes:
            if node.type == "TEX_IMAGE" and node.image:
                images.append({
                    "name": node.image.name,
                    "channels": node.image.channels,
                    "has_alpha_channel": node.image.channels == 4,
                    "source": node.image.source,
                })
    return {
        "name": material.name,
        "blend_method": getattr(material, "surface_render_method", None),
        "use_transparency": material.use_transparency if hasattr(material, "use_transparency") else None,
        "alpha": material.diffuse_color[3],
        "alpha_threshold": getattr(material, "alpha_threshold", None),
        "use_backface_culling": getattr(material, "use_backface_culling", None),
        "images": images,
    }


def face_components(mesh, obj):
    parent = array("i", range(len(mesh.vertices)))
    rank = bytearray(len(mesh.vertices))

    def find(index):
        while parent[index] != index:
            parent[index] = parent[parent[index]]
            index = parent[index]
        return index

    for edge in mesh.edges:
        left = find(edge.vertices[0])
        right = find(edge.vertices[1])
        if left == right:
            continue
        if rank[left] < rank[right]:
            left, right = right, left
        parent[right] = left
        if rank[left] == rank[right]:
            rank[left] += 1

    records = {}
    for polygon in mesh.polygons:
        root = find(polygon.vertices[0])
        record = records.get(root)
        if record is None:
            record = {"faces": 0, "vertices": 0, "minimum": None, "maximum": None}
            records[root] = record
        record["faces"] += 1

    for index, vertex in enumerate(mesh.vertices):
        root = find(index)
        record = records.get(root)
        if record is None:
            continue
        point = obj.matrix_world @ vertex.co
        coordinates = tuple(point)
        if record["minimum"] is None:
            record["minimum"] = list(coordinates)
            record["maximum"] = list(coordinates)
        else:
            for axis in range(3):
                record["minimum"][axis] = min(record["minimum"][axis], coordinates[axis])
                record["maximum"][axis] = max(record["maximum"][axis], coordinates[axis])
        record["vertices"] += 1

    components = [{
        "faces": record["faces"],
        "vertices": record["vertices"],
        "bounds": {
            "min": record["minimum"],
            "max": record["maximum"],
            "center": [(record["minimum"][i] + record["maximum"][i]) / 2 for i in range(3)],
            "size": [record["maximum"][i] - record["minimum"][i] for i in range(3)],
        },
    } for record in records.values()]
    components.sort(key=lambda component: component["faces"], reverse=True)
    return components


def boundary_edge_count(mesh):
    bm = bmesh.new()
    bm.from_mesh(mesh)
    count = sum(edge.is_boundary for edge in bm.edges)
    bm.free()
    return count


def set_camera(direction, center, extent, name):
    camera_data = bpy.data.cameras.new(name)
    camera = bpy.data.objects.new(name, camera_data)
    bpy.context.collection.objects.link(camera)
    camera.location = center + direction.normalized() * max(extent * 2.6, 1.0)
    camera.rotation_euler = (center - camera.location).to_track_quat("-Z", "Y").to_euler()
    camera.data.type = "ORTHO"
    camera.data.ortho_scale = max(extent * 1.5, 0.5)
    bpy.context.scene.camera = camera
    return camera


def render_views(objects, model_bounds, product_id):
    center = Vector(model_bounds["center"])
    extent = max(model_bounds["size"])
    scene = bpy.context.scene
    scene.render.engine = "BLENDER_EEVEE"
    scene.render.resolution_x = 800
    scene.render.resolution_y = 800
    scene.render.resolution_percentage = 100
    scene.render.image_settings.file_format = "PNG"
    scene.render.film_transparent = False
    scene.world.color = (0.08, 0.08, 0.08)

    key_data = bpy.data.lights.new("Inspection key", "AREA")
    key = bpy.data.objects.new("Inspection key", key_data)
    bpy.context.collection.objects.link(key)
    key.location = center + Vector((extent, extent * 1.2, extent * 1.5))
    key.data.energy = 1800
    key.data.shape = "DISK"
    key.data.size = extent

    fill_data = bpy.data.lights.new("Inspection fill", "AREA")
    fill = bpy.data.objects.new("Inspection fill", fill_data)
    bpy.context.collection.objects.link(fill)
    fill.location = center + Vector((-extent, extent * 0.3, -extent))
    fill.data.energy = 900
    fill.data.size = extent

    views = {
        "front": Vector((0, -1, 0)),
        "back": Vector((0, 1, 0)),
        "side": Vector((1, 0, 0)),
        "45": Vector((1, -1, 0)),
    }
    paths = {}
    for view_name, direction in views.items():
        camera = set_camera(direction, center, extent, f"Inspection camera {view_name}")
        scene.render.filepath = os.path.join(OUTPUT, f"product-{product_id}-{view_name}.png")
        bpy.ops.render.render(write_still=True)
        paths[view_name] = scene.render.filepath
        bpy.data.objects.remove(camera, do_unlink=True)
    for light in (key, fill):
        bpy.data.objects.remove(light, do_unlink=True)
    return paths


report = {}
for product_id in ("13", "17"):
    clear_scene()
    bpy.ops.outliner.orphans_purge(do_recursive=True)
    filepath = os.path.join(ROOT, "public", "models", "products", product_id, "product.glb")
    bpy.ops.import_scene.gltf(filepath=filepath)
    objects = [obj for obj in bpy.context.scene.objects if obj.type == "MESH"]
    meshes = []
    all_points = []
    for obj in objects:
        mesh = obj.data
        world_points = [obj.matrix_world @ vertex.co for vertex in mesh.vertices]
        all_points.extend(tuple(point) for point in world_points)
        meshes.append({
            "object": obj.name,
            "vertices": len(mesh.vertices),
            "faces": len(mesh.polygons),
            "triangles": sum(max(len(polygon.vertices) - 2, 0) for polygon in mesh.polygons),
            "uv_layers": [layer.name for layer in mesh.uv_layers],
            "attributes": [
                {"name": attribute.name, "domain": attribute.domain, "type": attribute.data_type}
                for attribute in mesh.attributes
            ],
            "bounds": bounds_for_points([tuple(point) for point in world_points]),
            "world_location": list(obj.matrix_world.translation),
            "world_rotation_euler": list(obj.matrix_world.to_euler()),
            "world_scale": list(obj.matrix_world.to_scale()),
            "boundary_edges": boundary_edge_count(mesh),
            "connected_face_components": face_components(mesh, obj),
            "materials": [material_report(material) for material in mesh.materials if material],
        })
    bounds = bounds_for_points(all_points)
    report[product_id] = {
        "source": filepath,
        "mesh_count": len(objects),
        "bounds": bounds,
        "meshes": meshes,
        "renders": render_views(objects, bounds, product_id),
    }

with open(os.path.join(OUTPUT, "report.json"), "w", encoding="utf-8") as output:
    json.dump(report, output, indent=2)
print(json.dumps({"output": OUTPUT, "products": {
    product_id: {
        "mesh_count": data["mesh_count"],
        "bounds": data["bounds"],
        "meshes": [{
            "name": mesh["object"],
            "vertices": mesh["vertices"],
            "faces": mesh["faces"],
            "triangles": mesh["triangles"],
            "uv_layers": mesh["uv_layers"],
            "attributes": mesh["attributes"],
            "boundary_edges": mesh["boundary_edges"],
            "components": mesh["connected_face_components"],
            "materials": mesh["materials"],
        } for mesh in data["meshes"]],
        "renders": data["renders"],
    } for product_id, data in report.items()
}}, indent=2))
