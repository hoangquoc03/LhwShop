import bpy, os, sys, bmesh
from mathutils import Vector

# argv: blender --background --python script -- <filepath>
argv = sys.argv
if "--" in argv:
    idx = argv.index("--") + 1
    filepath = argv[idx]
else:
    print('Usage: blender --background --python inspect_single_glb.py -- <path>')
    sys.exit(1)

print('Inspecting', filepath)

bpy.ops.wm.read_homefile(use_empty=True)
try:
    bpy.ops.import_scene.gltf(filepath=filepath)
except Exception as e:
    print('Import failed:', e)
    sys.exit(2)

meshes = [o for o in bpy.context.scene.objects if o.type=='MESH']
if not meshes:
    print('No mesh objects')
    sys.exit(3)

summary = []
all_x = []
for obj in meshes:
    mesh = obj.data
    verts = len(mesh.vertices)
    faces = len(mesh.polygons)
    mats = len(mesh.materials)
    # world bounds
    world_verts = [obj.matrix_world @ v.co for v in mesh.vertices]
    xs = [v.x for v in world_verts]
    ys = [v.y for v in world_verts]
    zs = [v.z for v in world_verts]
    minv = Vector((min(xs), min(ys), min(zs)))
    maxv = Vector((max(xs), max(ys), max(zs)))
    center = (minv+maxv)/2
    size = maxv-minv
    all_x.extend(xs)
    # compute boundary edges via bmesh (edges with < 2 linked faces)
    bpy.context.view_layer.objects.active = obj
    bpy.ops.object.mode_set(mode='EDIT')
    bm = bmesh.from_edit_mesh(mesh)
    boundary_edges = sum(1 for e in bm.edges if len(e.link_faces) < 2)
    # component count: count loose parts by selecting islands (approx via vert connectivity)
    # We'll approximate component count by counting linked vertex groups via face connectivity
    visited = set()
    comp_count = 0
    for f in bm.faces:
        if f.index in visited:
            continue
        # BFS
        stack = [f]
        visited.add(f.index)
        while stack:
            cur = stack.pop()
            for e in cur.edges:
                for nf in e.link_faces:
                    if nf.index not in visited:
                        visited.add(nf.index)
                        stack.append(nf)
        comp_count += 1
    bpy.ops.object.mode_set(mode='OBJECT')
    uv_layers = [layer.name for layer in mesh.uv_layers]
    material_info = []
    for material in mesh.materials:
        images = []
        if material and material.use_nodes and material.node_tree:
            images = [
                node.image.name
                for node in material.node_tree.nodes
                if node.type == "TEX_IMAGE" and node.image
            ]
        material_info.append({
            'name': material.name if material else None,
            'images': images,
            'diffuse_color': tuple(material.diffuse_color) if material else None,
        })
    summary.append({
        'object': obj.name,
        'verts': verts,
        'faces': faces,
        'mats': mats,
        'uvLayers': uv_layers,
        'materials': material_info,
        'center': (center.x, center.y, center.z),
        'size': (size.x, size.y, size.z),
        'boundaryEdges': boundary_edges,
        'components': comp_count,
    })

print('Meshes found:', len(meshes))
for s in summary:
    print(s)

print('Overall X stats: min, max, mid')
print(min(all_x), max(all_x), (min(all_x)+max(all_x))/2)

# quick axis occupancy check
neg = sum(1 for x in all_x if x < 0)
pos = sum(1 for x in all_x if x > 0)
print('Vertices negative-X:', neg, 'positive-X:', pos)

print('Done')
