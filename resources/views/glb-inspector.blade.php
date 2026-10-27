<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LHW GLB Landmark Inspector</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Arial, sans-serif;
            color: #18181b;
            background: #f4f4f5;
        }

        body {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1,
        h2,
        h3 {
            margin-top: 0;
        }

        form,
        .panel {
            display: grid;
            gap: 12px;
            margin: 16px 0;
            padding: 16px;
            border: 1px solid #d4d4d8;
            border-radius: 12px;
            background: #fff;
        }

        form {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            align-items: end;
        }

        label {
            display: grid;
            gap: 5px;
            font-size: 13px;
            font-weight: 600;
        }

        input,
        select,
        button {
            box-sizing: border-box;
            min-height: 40px;
            padding: 8px 10px;
            border: 1px solid #d4d4d8;
            border-radius: 7px;
            background: #fff;
            color: inherit;
        }

        button {
            cursor: pointer;
            font-weight: 600;
        }

        button:disabled {
            cursor: wait;
            opacity: 0.6;
        }

        .wide {
            grid-column: 1 / -1;
        }

        .muted {
            color: #52525b;
            font-size: 13px;
        }

        .error {
            color: #991b1b;
            background: #fef2f2;
            border-color: #fecaca;
        }

        .warning {
            color: #78350f;
            background: #fffbeb;
            border-color: #fde68a;
        }

        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .badge {
            padding: 6px 9px;
            border-radius: 999px;
            background: #f4f4f5;
            font-size: 13px;
        }

        .badge[data-state='found'] {
            color: #166534;
            background: #dcfce7;
        }

        .badge[data-state='missing'],
        .badge[data-state='invalid'] {
            color: #991b1b;
            background: #fee2e2;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #e4e4e7;
            text-align: left;
            vertical-align: top;
            overflow-wrap: anywhere;
        }

        th {
            white-space: nowrap;
            background: #fafafa;
        }

        code,
        pre {
            font-family: Consolas, monospace;
        }

        pre {
            max-height: 420px;
            overflow: auto;
            padding: 12px;
            border-radius: 8px;
            background: #18181b;
            color: #f4f4f5;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <h1>LHW AI Fashion Studio — GLB Landmark Inspector</h1>
    <p class="muted">
        Công cụ chỉ đọc bản GLB tải riêng. Không sửa asset, cấu hình sản
        phẩm hoặc fitting room đang chạy.
        <a href="{{ route('fitting-room') }}">Quay lại fitting room</a>
    </p>
    <p class="panel warning">
        Nếu trình duyệt báo <code>ERR_CONNECTION_REFUSED</code> ngay khi mở
        trang, máy chủ Laravel/Laragon chưa kết nối được; lúc đó GLB chưa được
        tải. Khi trang mở được, HTTP 404/403 là lỗi URL/quyền của GLB, còn lỗi
        parse là nội dung phản hồi không phải GLB hợp lệ.
    </p>

    <form id="inspectForm">
        <label class="wide">
            URL GLB
            <input id="glbUrl" name="url" type="text" value="/models/products/13/product.glb"
                placeholder="/models/products/13/product.glb" required />
        </label>
        <label>
            Product ID (tùy chọn)
            <input id="productId" name="productId" inputmode="numeric" value="13" placeholder="13" />
        </label>
        <label>
            Category
            <select id="category" name="category">
                <option value="top">top</option>
                <option value="bottom">bottom</option>
                <option value="shoes">shoes</option>
            </select>
        </label>
        <label>
            Quy đổi đơn vị sang mét (tùy chọn)
            <input id="unitToMeters" name="unitToMeters" type="number" min="0" step="any"
                placeholder="Để trống nếu chưa biết" />
        </label>
        <button id="inspectButton" type="submit">Inspect GLB</button>
        <div class="wide muted" id="unitNotice">
            Tọa độ báo cáo giữ nguyên đơn vị GLB. Không thể xác định đơn vị
            vật lý chỉ từ kích thước bounds.
        </div>
    </form>

    <div id="state" class="panel" role="status" aria-live="polite">
        Chưa kiểm tra asset.
    </div>
    <section id="report" hidden></section>

    <script>
        window.LHW_GLB_INSPECTOR_CONFIG = {
            landmarks: @json(config('lhw_fitting.landmarks')),
        };
    </script>
    <script type="importmap">
            {
                "imports": {
                    "three": "https://cdn.jsdelivr.net/npm/three@0.180.0/build/three.module.js",
                    "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.180.0/examples/jsm/"
                }
            }
        </script>
    <script type="module">
        import {
            inspectGLB
        } from '/js/lhw-glb-inspector.js';
        import {
            createInspectionExport,
        } from '/js/lhw-glb-inspector-core.js';

        const form = document.getElementById('inspectForm');
        const button = document.getElementById('inspectButton');
        const state = document.getElementById('state');
        const reportSection = document.getElementById('report');
        const productIdInput = document.getElementById('productId');
        let lastReport = null;

        // The URL field is authoritative: never replace an explicitly entered
        // custom GLB path with the product's default product.glb URL.
        // Product ID is report metadata only; users may inspect versioned GLBs.

        function element(tag, text, className = '') {
            const node = document.createElement(tag);
            if (text !== undefined && text !== null)
                node.textContent = String(text);
            if (className) node.className = className;
            return node;
        }

        function table(headers, rows) {
            const wrapper = element('div', null, 'table-wrap');
            const tableElement = element('table');
            const head = element('thead');
            const headerRow = element('tr');
            headers.forEach((header) =>
                headerRow.appendChild(element('th', header)),
            );
            head.appendChild(headerRow);
            tableElement.appendChild(head);
            const body = element('tbody');
            rows.forEach((row) => {
                const rowElement = element('tr');
                row.forEach((value) => {
                    rowElement.appendChild(element('td', value ?? '—'));
                });
                body.appendChild(rowElement);
            });
            tableElement.appendChild(body);
            wrapper.appendChild(tableElement);
            return wrapper;
        }

        function vector(value) {
            return Array.isArray(value) ?
                value.map((part) => Number(part).toFixed(6)).join(', ') :
                'unavailable';
        }

        function landmarkValue(mark, formatter) {
            if (!mark.matches?.length) return formatter(mark);
            return mark.matches
                .map((match) => `${match.path}: ${formatter(match)}`)
                .join('\n');
        }

        function renderReport(report) {
            reportSection.replaceChildren();
            reportSection.hidden = false;

            const actions = element('div', null, 'panel');
            const download = element('button', 'Export JSON');
            download.type = 'button';
            download.addEventListener('click', () => {
                const blob = new Blob(
                    [
                        JSON.stringify(
                            createInspectionExport(lastReport || report),
                            null,
                            2,
                        ),
                    ], {
                        type: 'application/json',
                    },
                );
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `lhw-glb-inspection-${report.input.productId || 'asset'}.json`;
                link.hidden = true;
                document.body.appendChild(link);
                link.click();
                window.setTimeout(() => {
                    URL.revokeObjectURL(link.href);
                    link.remove();
                }, 1000);
            });
            actions.append(download);
            reportSection.append(actions);

            if (!report.status.inspectionCompleted) {
                const failure = element('section', null, 'panel error');
                failure.appendChild(element('h2', 'Inspection not completed'));
                failure.appendChild(element('p', report.status.note));
                if (report.errors[0]?.code === 'glb-http-error') {
                    failure.appendChild(
                        element(
                            'p',
                            'Máy chủ đã trả lời yêu cầu GLB nhưng từ chối hoặc không tìm thấy asset. Kiểm tra URL, mã HTTP và quyền đọc file; đây không phải lỗi parse GLB.',
                        ),
                    );
                } else if (report.errors[0]?.code === 'glb-parse-failed') {
                    failure.appendChild(
                        element(
                            'p',
                            'Yêu cầu đã tới bước nạp GLB nhưng dữ liệu không giải mã được. Kiểm tra file GLB/export; đây không phải lỗi máy chủ từ chối kết nối.',
                        ),
                    );
                } else if (report.errors[0]?.code === 'glb-network-error') {
                    const runtime = report.browserRuntime;
                    failure.appendChild(
                        element(
                            'p',
                            runtime?.reachable === false ?
                            `Browser runtime không truy cập được route Inspector (${runtime.message}). Đây là lỗi kết nối máy chủ, chưa thể kết luận có lỗi GLB.` :
                            runtime?.reachable === true ?
                            `Route Inspector vẫn phản hồi HTTP ${runtime.status}. Lỗi nằm ở request GLB (hoặc origin/CORS), không phải lỗi từ chối kết nối của Inspector.` :
                            'Không nhận được phản hồi mạng cho GLB. Kiểm tra trạng thái route Inspector và request GLB trong DevTools Network.',
                        ),
                    );
                }
                report.errors.forEach((error) =>
                    failure.appendChild(
                        element('p', `${error.code}: ${error.message}`),
                    ),
                );
                reportSection.append(failure);
                const raw = element('details', null, 'panel');
                raw.appendChild(element('summary', 'Full JSON report'));
                raw.appendChild(element('pre', JSON.stringify(report, null, 2)));
                reportSection.append(raw);
                return;
            }

            const summary = element('section', null, 'panel');
            summary.appendChild(element('h2', 'Inspection summary'));
            summary.appendChild(
                element(
                    'p',
                    `Structure: ${report.status.structuralValid ? 'valid' : 'invalid'}; ` +
                    `Transforms: ${report.status.transformDataValid ? 'valid' : 'invalid'}; ` +
                    `Landmarks configured: ${report.status.landmarksConfigured ? 'yes' : 'not-configured'}; ` +
                    `Landmark layout: ${report.status.landmarkLayoutValid === null ? 'not-applicable' : report.status.landmarkLayoutValid ? 'solver-usable' : `unusable (${report.status.landmarkLayoutReason || 'incomplete landmarks'})`}; ` +
                    `Landmark Auto-Fit eligible: ${report.status.eligibleForLandmarkAutoFit ? 'yes (not a fit guarantee)' : 'no'}`,
                ),
            );
            summary.appendChild(
                element(
                    'p',
                    `Auto-Fit readiness: ${report.autoFitReadiness.status}. ${report.autoFitReadiness.reason}`,
                ),
            );
            if (report.landmarkGeometry) {
                summary.appendChild(
                    element(
                        'p',
                        `Geometric checks: ${report.landmarkGeometry.valid ? 'passed' : 'failed'}. ` +
                        (report.landmarkGeometry.errors || [])
                        .map((error) => `${error.code}: ${error.message}`)
                        .join('; '),
                        report.landmarkGeometry.valid ? 'muted' : 'error',
                    ),
                );
            }
            const badges = element('div', null, 'summary');
            const counts = report.counts.landmarks;
            summary.appendChild(
                element(
                    'p',
                    report.status.inspectionCompleted ?
                    `Landmarks: ${counts.found} found of ${counts.expected} expected.` :
                    'Landmark scan was not performed because the GLB could not be loaded.',
                ),
            );
            [
                ['found', counts.found],
                ['missing', counts.missing],
                ['invalid', counts.invalid],
                ['duplicate', counts.duplicate],
            ].forEach(([label, count]) => {
                const badge = element(
                    'span',
                    `${label}: ${count}`,
                    'badge',
                );
                badge.dataset.state =
                    label === 'found' ?
                    'found' :
                    count ?
                    label === 'missing' ?
                    'missing' :
                    'invalid' :
                    '';
                badges.appendChild(badge);
            });
            summary.append(
                badges,
                element('p', report.status.note, 'muted'),
            );
            reportSection.append(summary);

            const coordinates = element('section', null, 'panel');
            coordinates.appendChild(
                element('h2', 'Coordinate spaces and units'),
            );
            coordinates.appendChild(
                table(
                    ['Space', 'Definition / status'],
                    [
                        ['Node local', report.coordinateSpaces.nodeLocal],
                        [
                            'GLB scene/world',
                            report.coordinateSpaces.glbSceneWorld,
                        ],
                        [
                            'Fitting-stage local',
                            report.coordinateSpaces.fittingStageLocal,
                        ],
                        [
                            'Reported coordinates',
                            report.units.reportedCoordinates,
                        ],
                        ['Physical unit', report.units.physicalUnit],
                        [
                            'Project convention',
                            report.units.projectConvention,
                        ],
                        [
                            'User scale to meters',
                            report.units.unitToMeters ?? 'not supplied',
                        ],
                        [
                            'Coordinate conversion',
                            report.units.unitToMeters ?
                            'Converted positions and bounds are available in the JSON report.' :
                            'No converted coordinates; enter a user-known scale to meters.',
                        ],
                        ['Hierarchy rule', report.hierarchyPolicy.note],
                    ],
                ),
            );
            reportSection.append(coordinates);

            const bounds = element('section', null, 'panel');
            bounds.appendChild(
                element('h2', 'Geometry and bounding boxes'),
            );
            bounds.appendChild(
                element(
                    'p',
                    `Nodes: ${report.counts.nodes}; meshes: ${report.counts.meshes}. ` +
                    `Overall bounds ${report.bounds.valid ? 'valid' : `invalid (${report.bounds.reason})`}. ` +
                    `Bounds are geometry extents only, not anatomical landmarks.`,
                ),
            );
            bounds.appendChild(
                table(
                    [
                        'Object',
                        'Min',
                        'Max',
                        'Center',
                        'Size (raw)',
                        'Bounds in meters (if configured)',
                        'Status',
                    ],
                    [
                        [
                            'Overall GLB scene',
                            vector(report.bounds.min),
                            vector(report.bounds.max),
                            vector(report.bounds.center),
                            vector(report.bounds.size),
                            vector(report.boundsMeters?.size),
                            report.bounds.valid ?
                            'valid' :
                            report.bounds.reason,
                        ],
                        ...report.meshBounds.map((mesh) => [
                            `${mesh.name} — ${mesh.path || ''}`,
                            vector(mesh.bounds.min),
                            vector(mesh.bounds.max),
                            vector(mesh.bounds.center),
                            vector(mesh.bounds.size),
                            vector(mesh.boundsMeters?.size),
                            mesh.bounds.valid ?
                            'valid' :
                            mesh.bounds.reason,
                        ]),
                    ],
                ),
            );
            reportSection.append(bounds);

            const landmarks = element('section', null, 'panel');
            landmarks.appendChild(
                element(
                    'h2',
                    report.status.landmarksConfigured ?
                    'Landmarks' :
                    'Landmarks — not-configured',
                ),
            );
            landmarks.appendChild(
                table(
                    [
                        'Name',
                        'Status',
                        'Node / path',
                        'Parent transform',
                        'Local position',
                        'Local rotation / scale',
                        'GLB world position',
                        'World rotation / scale',
                        'Fitting-stage local',
                        'Converted positions in meters (if configured)',
                        'Notes / suggestion',
                    ],
                    report.landmarks.map((mark) => [
                        mark.name,
                        mark.status,
                        mark.path ?
                        `${mark.type}: ${mark.path}` :
                        (mark.matches || [])
                        .map(
                            (match) =>
                            `${match.type}: ${match.path}`,
                        )
                        .join('\n') || '—',
                        landmarkValue(mark, (entry) =>
                            entry.parent ?
                            `${entry.parent.name || '(unnamed)'}\nlocal position=${vector(entry.parent.localPosition)}\nlocal quaternion=${vector(entry.parent.localQuaternion)}\nlocal scale=${vector(entry.parent.localScale)}\nworld quaternion=${vector(entry.parent.worldQuaternion)}\nworld scale=${vector(entry.parent.worldScale)}` :
                            'none',
                        ),
                        landmarkValue(mark, (entry) =>
                            vector(entry.localPosition),
                        ),
                        landmarkValue(
                            mark,
                            (entry) =>
                            `quaternion=${vector(entry.transform?.localQuaternion || entry.localQuaternion)}; scale=${vector(entry.transform?.localScale || entry.localScale)}`,
                        ),
                        landmarkValue(mark, (entry) =>
                            vector(entry.worldPosition),
                        ),
                        landmarkValue(
                            mark,
                            (entry) =>
                            `quaternion=${vector(entry.transform?.worldQuaternion || entry.worldQuaternion)}; scale=${vector(entry.transform?.worldScale || entry.worldScale)}`,
                        ),
                        landmarkValue(mark, (entry) =>
                            vector(entry.fittingStageLocalPosition),
                        ),
                        `local=${vector(mark.localPositionMeters)}; world=${vector(mark.worldPositionMeters)}; stage=${vector(mark.fittingStageLocalPositionMeters)}`,
                        [
                            mark.reason,
                            ...(mark.notes || []),
                            ...(mark.similarNames || []).map(
                                (match) =>
                                `Possible typo: ${match.name} (${match.path})`,
                            ),
                        ]
                        .filter(Boolean)
                        .join('; ') || '—',
                    ]),
                ),
            );
            reportSection.append(landmarks);

            const measurements = element('section', null, 'panel');
            measurements.appendChild(
                element('h2', 'Landmark-to-landmark measurements'),
            );
            measurements.appendChild(
                table(
                    [
                        'Measurement',
                        'Landmarks',
                        'Distance (raw)',
                        'Distance (m, if configured)',
                        'Unit',
                        'Status',
                    ],
                    report.measurements.map((measurement) => [
                        measurement.name,
                        measurement.landmarks.join(' ↔ '),
                        measurement.distance === null ?
                        'unavailable' :
                        Number(measurement.distance).toFixed(6),
                        measurement.distanceMeters === null ?
                        'not configured' :
                        Number(measurement.distanceMeters).toFixed(6),
                        measurement.unit,
                        measurement.valid ?
                        'valid measurement only' :
                        measurement.reason,
                    ]),
                ),
            );
            reportSection.append(measurements);

            const diagnostics = element('section', null, 'panel');
            diagnostics.appendChild(element('h2', 'Warnings and errors'));
            report.warnings.forEach((warning) =>
                diagnostics.appendChild(
                    element('div', warning, 'panel warning'),
                ),
            );
            report.errors.forEach((error) =>
                diagnostics.appendChild(
                    element(
                        'div',
                        `${error.code}: ${error.message}`,
                        'panel error',
                    ),
                ),
            );
            if (!report.warnings.length && !report.errors.length) {
                diagnostics.appendChild(
                    element(
                        'p',
                        'No structural warnings were produced. This does not certify garment fit.',
                        'muted',
                    ),
                );
            }
            reportSection.append(diagnostics);

            const raw = element('details', null, 'panel');
            raw.appendChild(element('summary', 'Full JSON report'));
            raw.appendChild(
                element('pre', JSON.stringify(report, null, 2)),
            );
            reportSection.append(raw);
        }

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            button.disabled = true;
            reportSection.hidden = true;
            state.className = 'panel';
            state.textContent = 'Đang tải và kiểm tra GLB…';
            const formData = new FormData(form);
            const unitValue = String(
                formData.get('unitToMeters') || '',
            ).trim();
            const unitToMeters = unitValue ? Number(unitValue) : null;
            try {
                const productId = String(formData.get('productId') || '').trim() || null;
                // Use exactly the URL entered by the user. Do not resolve it back
                // to /models/products/{id}/product.glb based on Product ID.
                const url = String(formData.get('url') || '').trim();
                if (!url) {
                    throw new Error('Vui lòng nhập URL GLB cần kiểm tra.');
                }
                lastReport = await inspectGLB({
                    url,
                    productId,
                    category: String(formData.get('category')),
                    expectedLandmarksByCategory: window.LHW_GLB_INSPECTOR_CONFIG.landmarks,
                    fittingStage: null,
                    unitToMeters,
                });
                const inspectionFailed = !lastReport.status.inspectionCompleted;
                state.className = inspectionFailed ?
                    'panel error' :
                    lastReport.status.structuralValid ?
                    'panel' :
                    'panel warning';
                state.textContent = inspectionFailed ?
                    `Inspection chưa hoàn tất (${lastReport.errors[0]?.code || 'unknown'}): ${lastReport.errors.map((error) => error.message).join('; ')}` :
                    `Inspection hoàn tất. ${
                              lastReport.status.eligibleForLandmarkAutoFit
                                  ? 'Landmarks đủ về cấu trúc; chưa xác minh fit với avatar.'
                                  : 'Asset chưa đủ điều kiện landmark-based Auto-Fit.'
                          }`;
                renderReport(lastReport);
            } catch (error) {
                lastReport = {
                    schemaVersion: 1,
                    input: {
                        url: String(formData.get('url') || '').trim(),
                        productId: String(formData.get('productId') || '').trim() || null,
                        category: String(formData.get('category')),
                    },
                    status: {
                        inspectionCompleted: false,
                        failureStage: 'input',
                        note: 'Input validation failed; the GLB was not loaded.',
                    },
                    errors: [{
                        code: 'glb-input-invalid',
                        message: error.message || String(error)
                    }],
                };
                state.className = 'panel error';
                state.textContent = `Lỗi Inspector: ${error.message || error}`;
                renderReport(lastReport);
            } finally {
                button.disabled = false;
            }
        });
    </script>
</body>

</html>
