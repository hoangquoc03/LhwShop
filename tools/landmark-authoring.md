# LHW garment landmark authoring

This workflow creates separate landmarked GLBs for product 13 (top) and
product 17 (bottom). It never writes to either `product.glb` source. Landmark
coordinates are only created from a user's viewport click on the garment mesh;
the script does not infer positions from bounds or choose default coordinates.

## 1. Open a working copy in Blender

Use Blender 3.6+ with the glTF 2.0 Import/Export add-on enabled. From the
repository root, start one product at a time:

```powershell
blender --python tools\blender_landmark_authoring.py -- --product-id 13
blender --python tools\blender_landmark_authoring.py -- --product-id 17
```

If `blender` is not on `PATH`, replace it with the full path to `blender.exe`.
The script imports the selected source GLB into Blender and separates its
imported objects into a named source-copy collection. It does not modify the
source file. The default exports are:

- `public\models\products\13\product.landmarked.glb`
- `public\models\products\17\product.landmarked.glb`

Existing output files are never overwritten. Choose a new output filename in
the Blender panel if a prior output already exists.

## 2. Place every marker on the mesh

In the Blender 3D View, open the **N-panel > LHW** tab. Use **Place next missing
landmark**, or click a named **Place / re-place** button. Then click the
corresponding location on a visible garment surface. Press `Esc` to cancel a
placement. Empty markers do not add mesh geometry; their origins are the
landmark coordinates.

Place these names deliberately:

| Product | Required marker | Surface/meaning |
|---|---|---|
| 13 top | `LHW_Neck` | Neckline center |
| 13 top | `LHW_Shoulder_L`, `LHW_Shoulder_R` | Left and right shoulder points |
| 13 top | `LHW_Hem` | Hem center |
| 13 top | `LHW_Chest_Front` | Center of the front chest surface |
| 13 top | `LHW_Back_Center` | Center of the back surface |
| 17 bottom | `LHW_Waist` | Waistline reference point |
| 17 bottom | `LHW_Crotch` | Crotch junction |
| 17 bottom | `LHW_Knee_L`, `LHW_Knee_R` | Left and right knee points |
| 17 bottom | `LHW_Hem_L`, `LHW_Hem_R` | Left and right leg hems |
| 17 bottom | `LHW_Waist_Front` | Center of the front waistband surface |

The front/back markers document garment facing; the workflow does not assume a
GLB forward axis. Use the same garment-side interpretation for all left/right
markers. Do not place markers by copying bounds coordinates or use fitting
offsets to compensate for a misplaced marker.

## 3. Export and verify the exported GLB

Click **Export separate landmarked GLB**. The exporter selects only the
imported garment and the marker empties, retains normals, UVs and exported
materials/textures, and writes a `.blend` working session under
`tools\landmark-work\` for later edits. The original GLB remains untouched.

Start the Laravel app and open `/glb-inspector`. For the exported file, set the
URL to `/models/products/<id>/product.landmarked.glb`, clear **Product ID** so
it does not replace the custom URL, and choose `top` for ID 13 or `bottom` for
ID 17. Inspection uses Three.js `GLTFLoader` to reload that exported file and
reports each required node's name, hierarchy, local position, and GLB
world-space position. Do not consider an export verified unless all expected
names are unique and found, all coordinates are finite and within mesh bounds,
geometric checks pass, and Auto-Fit readiness is `ready`. The inspector's
geometric checks validate ordering and broad relative proportions; they do not
certify visual fit against the avatar.

The fitting room continues to use its existing legacy bounds fitter when
landmark checks fail. Landmark Auto-Fit stays disabled by default; add a
product ID to `verifiedProductIds` only after its authored output passes the
Inspector and corresponding avatar landmark pairs exist. Then validate the
resulting fit visually before considering the feature ready. The new
front/back garment markers do not imply matching avatar surface landmarks
exist. Do not describe landmark Auto-Fit as ready before those checks.

## Browser/runtime versus GLB failures

- `ERR_CONNECTION_REFUSED` before the Inspector page opens means the browser
  cannot reach the web server. Start Laragon or the Laravel server, then retry
  `/glb-inspector`.
- If the Inspector page opens, its network-error diagnostic probes the same
  Inspector route. If that route responds, the failure is specific to the GLB
  request (for example origin/CORS or a transient asset connection).
- An HTTP 403/404 is a server response for the GLB URL or permissions.
- A GLB parse error means data reached the loader but could not be decoded.
