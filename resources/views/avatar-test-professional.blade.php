<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">
    <title>LHW AI Fashion Studio — Avatar Diagnostics</title>

    <style>
        :root {
            --bg: #0b0d12;
            --panel: #121620;
            --panel-2: #171c27;
            --border: #293142;
            --text: #f4f6fb;
            --muted: #98a2b3;
            --accent: #8b9bff;
            --accent-2: #b6c0ff;
            --green: #45d6a2;
            --amber: #f5bc61;
            --red: #ff737e;
            --radius: 16px;
        }
        * { box-sizing: border-box; }
        html, body { margin: 0; min-height: 100%; background: var(--bg); color: var(--text); font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        body { min-height: 100vh; }
        button, input { font: inherit; }
        button { cursor: pointer; }
        .app-shell { min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { display: flex; align-items: center; justify-content: space-between; gap: 18px; padding: 17px 22px; border-bottom: 1px solid var(--border); background: rgba(18, 22, 32, .92); }
        .brand { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .brand-mark { width: 42px; height: 42px; display: grid; place-items: center; border-radius: 13px; color: #10131c; background: linear-gradient(135deg, var(--accent-2), var(--accent)); font-weight: 900; letter-spacing: -.04em; }
        .brand-title { font-size: 16px; font-weight: 760; letter-spacing: .01em; }
        .brand-subtitle { margin-top: 3px; color: var(--muted); font-size: 12px; }
        .topbar-right { display: flex; align-items: center; justify-content: flex-end; gap: 9px; flex-wrap: wrap; }
        .status-pill { display: inline-flex; align-items: center; gap: 8px; padding: 8px 11px; border: 1px solid var(--border); border-radius: 999px; background: #0e121a; color: var(--muted); font-size: 12px; white-space: nowrap; }
        .status-dot { width: 7px; height: 7px; display: inline-block; border-radius: 50%; background: var(--amber); }
        .status-pill[data-state="ready"] .status-dot { background: var(--green); }
        .status-pill[data-state="error"] .status-dot { background: var(--red); }
        .main { display: grid; grid-template-columns: 280px minmax(360px, 1fr) 330px; gap: 14px; padding: 16px; align-items: stretch; flex: 1; }
        .panel { min-width: 0; border: 1px solid var(--border); border-radius: var(--radius); background: var(--panel); overflow: hidden; }
        .panel-head { display: flex; justify-content: space-between; align-items: center; gap: 10px; padding: 15px 16px; border-bottom: 1px solid var(--border); }
        .panel-head h2 { margin: 0; font-size: 13px; letter-spacing: .08em; text-transform: uppercase; }
        .panel-body { padding: 14px; }
        .eyebrow { color: var(--muted); font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; }
        .muted { color: var(--muted); }
        .small { font-size: 12px; line-height: 1.55; }
        .metric-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 9px; }
        .metric { padding: 12px; border: 1px solid var(--border); border-radius: 12px; background: var(--panel-2); min-width: 0; }
        .metric-label { color: var(--muted); font-size: 11px; }
        .metric-value { margin-top: 6px; font-size: 23px; line-height: 1.1; font-weight: 750; letter-spacing: -.04em; overflow-wrap: anywhere; }
        .metric-unit { color: var(--muted); font-size: 11px; font-weight: 500; letter-spacing: 0; }
        .section-title { margin: 18px 0 9px; display: flex; align-items: center; justify-content: space-between; gap: 8px; font-size: 12px; font-weight: 730; }
        .info-list { display: grid; gap: 8px; }
        .info-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; padding: 9px 0; border-bottom: 1px solid rgba(41,49,66,.65); font-size: 12px; }
        .info-row:last-child { border-bottom: 0; }
        .info-row span:first-child { color: var(--muted); }
        .info-row strong { text-align: right; font-weight: 650; overflow-wrap: anywhere; }
        .btn-row { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 38px; padding: 9px 11px; border: 1px solid var(--border); border-radius: 10px; background: #1a2030; color: var(--text); font-size: 12px; font-weight: 680; transition: background .15s, border-color .15s, transform .15s; }
        .btn:hover { background: #222a3c; border-color: #46516a; }
        .btn:active { transform: translateY(1px); }
        .btn.primary { background: var(--accent); border-color: var(--accent); color: #10131c; }
        .btn.primary:hover { background: var(--accent-2); }
        .btn:focus-visible, input:focus-visible { outline: 2px solid var(--accent-2); outline-offset: 2px; }
        .btn.full { width: 100%; }
        .viewer-panel { display: flex; flex-direction: column; min-height: 680px; }
        .viewer-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 14px 16px; border-bottom: 1px solid var(--border); flex-wrap: wrap; }
        .viewer-title { font-size: 14px; font-weight: 730; }
        .viewer-hint { margin-top: 4px; color: var(--muted); font-size: 11px; }
        .viewer-actions { display: flex; align-items: center; gap: 7px; flex-wrap: wrap; }
        #viewer { position: relative; flex: 1; min-height: 520px; overflow: hidden; background: radial-gradient(ellipse at 50% 38%, #252d42 0%, #141a28 44%, #0c1018 100%); }
        #viewer canvas { display: block; width: 100%; height: 100%; outline: none; }
        .viewer-overlay { position: absolute; left: 14px; bottom: 14px; display: flex; gap: 7px; flex-wrap: wrap; pointer-events: none; }
        .viewer-tag { padding: 7px 9px; border: 1px solid rgba(152,162,179,.25); border-radius: 8px; background: rgba(8,11,17,.68); color: #cbd2df; font-size: 10px; backdrop-filter: blur(8px); }
        .viewer-tip { position: absolute; right: 14px; bottom: 14px; color: #aeb7c8; font-size: 10px; text-align: right; pointer-events: none; }
        .loading { position: absolute; inset: 0; display: grid; place-items: center; padding: 24px; text-align: center; background: rgba(9,12,19,.72); z-index: 3; }
        .loading-card { max-width: 310px; }
        .spinner { width: 30px; height: 30px; margin: 0 auto 13px; border: 3px solid #333b4c; border-top-color: var(--accent); border-radius: 50%; animation: spin .8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .progress-track { height: 5px; margin-top: 12px; border-radius: 99px; background: #30384a; overflow: hidden; }
        .progress-bar { width: 0; height: 100%; background: var(--accent); transition: width .15s; }
        .alert { margin-top: 12px; padding: 10px 11px; border: 1px solid #594a2f; border-radius: 10px; color: #f2d6a2; background: #2a2318; font-size: 11px; line-height: 1.55; }
        .right-panel { display: flex; flex-direction: column; min-height: 680px; }
        .tabs { display: flex; gap: 4px; padding: 10px 12px 0; border-bottom: 1px solid var(--border); }
        .tab { padding: 9px 10px; color: var(--muted); border: 0; border-bottom: 2px solid transparent; background: transparent; font-size: 12px; font-weight: 700; }
        .tab[aria-selected="true"] { color: var(--text); border-bottom-color: var(--accent); }
        .tab-content { min-height: 0; flex: 1; }
        .search { width: 100%; min-height: 38px; padding: 9px 11px; border: 1px solid var(--border); border-radius: 10px; color: var(--text); background: #0e121a; font-size: 12px; }
        .table-wrap { overflow: auto; max-height: 480px; border: 1px solid var(--border); border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        thead { position: sticky; top: 0; z-index: 1; background: #1a2030; }
        th, td { padding: 9px 8px; border-bottom: 1px solid rgba(41,49,66,.8); text-align: left; vertical-align: top; }
        th { color: var(--muted); font-weight: 700; }
        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: rgba(139,155,255,.055); }
        .code-name { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; overflow-wrap: anywhere; }
        .state { display: inline-flex; align-items: center; gap: 5px; font-size: 10px; font-weight: 700; }
        .state.ok { color: var(--green); }
        .state.missing { color: var(--amber); }
        .empty-state { padding: 22px 12px; text-align: center; color: var(--muted); font-size: 12px; }
        .footnote { padding: 11px 14px; border-top: 1px solid var(--border); color: var(--muted); font-size: 10px; line-height: 1.5; }
        .anchor-list { display: grid; gap: 6px; }
        .anchor-item { display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: 8px; align-items: center; padding: 10px; border: 1px solid var(--border); border-radius: 10px; background: var(--panel-2); }
        .anchor-name { font-size: 11px; font-weight: 750; }
        .anchor-bone { margin-top: 3px; color: var(--muted); font-size: 10px; overflow-wrap: anywhere; }
        .anchor-coords { color: #c4ccdb; font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 10px; text-align: right; line-height: 1.6; }
        .hidden { display: none !important; }
        .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
        @media (max-width: 1280px) { .main { grid-template-columns: 250px minmax(300px, 1fr); } .right-panel { grid-column: 1 / -1; min-height: 420px; } .right-panel .tab-content { min-height: 300px; } }
        @media (max-width: 760px) { .topbar { align-items: flex-start; flex-direction: column; padding: 14px; } .topbar-right { justify-content: flex-start; } .main { grid-template-columns: minmax(0,1fr); padding: 10px; gap: 10px; } .viewer-panel { grid-row: 1; min-height: 560px; } #viewer { min-height: 440px; } .right-panel { grid-column: auto; min-height: 460px; } .metric-grid { grid-template-columns: repeat(2,minmax(0,1fr)); } .left-panel { grid-row: 2; } }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: .01ms !important; transition-duration: .01ms !important; } }
    </style>

    <script type="importmap">
    {
      "imports": {
        "three": "https://cdn.jsdelivr.net/npm/three@0.170.0/build/three.module.js",
        "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.170.0/examples/jsm/"
      }
    }
    </script>
</head>
<body>
<div class="app-shell">
    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">LHW</div>
            <div>
                <div class="brand-title">LHW AI Fashion Studio</div>
                <div class="brand-subtitle">Avatar diagnostics · Skeleton &amp; landmark inspector</div>
            </div>
        </div>
        <div class="topbar-right">
            <div id="statusPill" class="status-pill" data-state="loading"><span class="status-dot"></span><span id="status">Đang khởi tạo Three.js…</span></div>
            <button class="btn" id="exportJsonBtn" type="button" disabled>Xuất JSON</button>
        </div>
    </header>

    <main class="main">
        <aside class="panel left-panel">
            <div class="panel-head"><h2>Tổng quan avatar</h2><span class="eyebrow">Diagnostics</span></div>
            <div class="panel-body">
                <div class="metric-grid">
                    <div class="metric"><div class="metric-label">Chiều cao</div><div class="metric-value" id="metricHeight">—</div><div class="metric-unit">world units</div></div>
                    <div class="metric"><div class="metric-label">Số xương</div><div class="metric-value" id="metricBones">—</div><div class="metric-unit">bones</div></div>
                    <div class="metric"><div class="metric-label">Anchors</div><div class="metric-value" id="metricAnchors">—</div><div class="metric-unit">điểm nhận diện</div></div>
                    <div class="metric"><div class="metric-label">Mesh cơ thể</div><div class="metric-value" id="metricMeshes">—</div><div class="metric-unit">skinned meshes</div></div>
                </div>

                <div class="section-title">Thông tin model</div>
                <div class="info-list">
                    <div class="info-row"><span>File</span><strong>avatar.glb</strong></div>
                    <div class="info-row"><span>Mesh chính</span><strong id="meshName">—</strong></div>
                    <div class="info-row"><span>Đỉnh mesh</span><strong id="vertexCount">—</strong></div>
                    <div class="info-row"><span>Chiều rộng</span><strong id="metricWidth">—</strong></div>
                    <div class="info-row"><span>Chiều sâu</span><strong id="metricDepth">—</strong></div>
                </div>

                <div class="section-title">Công cụ</div>
                <div class="btn-row">
                    <button id="toggleAvatarBtn" class="btn" type="button" disabled>Ẩn avatar</button>
                    <button id="resetCameraBtn" class="btn" type="button" disabled>Đặt lại góc nhìn</button>
                    <button id="refreshBtn" class="btn" type="button" disabled>Cập nhật số đo</button>
                    <button id="toggleAnchorsBtn" class="btn primary" type="button" disabled>Ẩn anchor</button>
                </div>

                <div class="alert">Số đo được tính trong hệ tọa độ Three.js sau khi đặt avatar xuống mặt sàn và căn giữa. Đây là kích thước bounding box, không phải số đo cơ thể theo may đo.</div>
            </div>
            <div class="footnote">Tệp avatar được tải từ <span class="code-name">public/models/avatar/avatar.glb</span>.</div>
        </aside>

        <section class="panel viewer-panel">
            <div class="viewer-head">
                <div>
                    <div class="viewer-title">3D Viewport</div>
                    <div class="viewer-hint">Kéo để xoay · Cuộn để zoom · Nhấn phải và kéo để pan</div>
                </div>
                <div class="viewer-actions">
                    <button id="frontViewBtn" class="btn" type="button" disabled>Mặt trước</button>
                    <button id="sideViewBtn" class="btn" type="button" disabled>Nghiêng</button>
                    <button id="backViewBtn" class="btn" type="button" disabled>Mặt sau</button>
                </div>
            </div>
            <div id="viewer">
                <div class="loading" id="loadingOverlay">
                    <div class="loading-card">
                        <div class="spinner" id="loadingSpinner"></div>
                        <div id="loadingTitle" style="font-weight:750">Đang tải avatar 3D</div>
                        <div id="loadingText" class="small muted" style="margin-top:6px">Đang tải model và phân tích hệ xương…</div>
                        <div class="progress-track"><div class="progress-bar" id="progressBar"></div></div>
                    </div>
                </div>
                <div class="viewer-overlay">
                    <span class="viewer-tag" id="viewerHeightTag">Height: —</span>
                    <span class="viewer-tag" id="viewerBoneTag">Bones: —</span>
                    <span class="viewer-tag">GLTF / Three.js</span>
                </div>
                <div class="viewer-tip">LHW · 3D Diagnostics</div>
            </div>
        </section>

        <aside class="panel right-panel">
            <div class="panel-head"><h2>Chi tiết kỹ thuật</h2><span class="eyebrow" id="detailCount">Chưa có dữ liệu</span></div>
            <div class="tabs" role="tablist" aria-label="Chi tiết avatar">
                <button class="tab" type="button" role="tab" id="anchorsTab" aria-selected="true" aria-controls="anchorsPane">Anchors</button>
                <button class="tab" type="button" role="tab" id="bonesTab" aria-selected="false" aria-controls="bonesPane">Skeleton</button>
            </div>
            <div class="tab-content panel-body" id="anchorsPane" role="tabpanel" aria-labelledby="anchorsTab">
                <div class="section-title" style="margin-top:0">Điểm mốc từ xương</div>
                <div id="anchorList" class="anchor-list"><div class="empty-state">Đang chờ avatar tải xong…</div></div>
            </div>
            <div class="tab-content panel-body hidden" id="bonesPane" role="tabpanel" aria-labelledby="bonesTab">
                <label class="sr-only" for="boneSearch">Tìm xương</label>
                <input id="boneSearch" class="search" type="search" placeholder="Tìm xương, ví dụ: Spine, LeftArm…" autocomplete="off">
                <div style="height:10px"></div>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th style="width:44px">#</th><th>Tên xương</th><th>Cha</th></tr></thead>
                        <tbody id="bonesTable"><tr><td colspan="3" class="empty-state">Đang chờ avatar tải xong…</td></tr></tbody>
                    </table>
                </div>
            </div>
            <div class="footnote">Dữ liệu anchor được đọc từ bone world position. Anchor không phải bề mặt cơ thể; muốn căn áo chính xác theo bề mặt cần thêm raycast hoặc landmark hình học.</div>
        </aside>
    </main>
</div>

<script type="module">
    import * as THREE from 'three';
    import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
    import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

    // Nếu file được đặt trong Laravel public, URL này sẽ đúng với public/models/avatar/avatar.glb.
    const AVATAR_URL = @json(asset('models/avatar/avatar.glb'));

    const $ = (id) => document.getElementById(id);
    const container = $('viewer');
    const statusEl = $('status');
    const statusPill = $('statusPill');
    const loadingOverlay = $('loadingOverlay');
    const progressBar = $('progressBar');

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x111722);

    const camera = new THREE.PerspectiveCamera(38, 1, 0.01, 200);
    camera.position.set(0, 1.5, 3.2);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.05;
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.domElement.setAttribute('aria-label', 'Khung xem avatar 3D');
    container.appendChild(renderer.domElement);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.065;
    controls.minDistance = 0.25;
    controls.maxDistance = 15;
    controls.target.set(0, 0.9, 0);

    scene.add(new THREE.HemisphereLight(0xeaf0ff, 0x545b6b, 2.1));
    const keyLight = new THREE.DirectionalLight(0xffffff, 2.6);
    keyLight.position.set(3, 5, 4);
    keyLight.castShadow = true;
    keyLight.shadow.mapSize.set(1024, 1024);
    scene.add(keyLight);
    const fillLight = new THREE.DirectionalLight(0xbac5ff, 1.1);
    fillLight.position.set(-4, 2.5, -3);
    scene.add(fillLight);

    const grid = new THREE.GridHelper(10, 40, 0x59647b, 0x30394b);
    grid.position.y = 0;
    scene.add(grid);

    const floor = new THREE.Mesh(
        new THREE.PlaneGeometry(200, 200),
        new THREE.ShadowMaterial({ opacity: 0.18 })
    );
    floor.rotation.x = -Math.PI / 2;
    floor.position.y = -0.004;
    floor.receiveShadow = true;
    scene.add(floor);

    let avatar = null;
    let avatarBones = {};
    let anchors = {};
    let avatarMetrics = null;
    let anchorMarkers = new THREE.Group();
    scene.add(anchorMarkers);
    let anchorsVisible = true;
    let initialCamera = null;
    let initialTarget = null;
    let skinnedMeshCount = 0;
    let totalVertices = 0;

    const boneMap = {
        pelvis: ['mixamorig1Hips','mixamorigHips','mixamorig:Hips','Hips','pelvis'],
        spine: ['mixamorig1Spine','mixamorigSpine','mixamorig:Spine','Spine','spine'],
        chest: ['mixamorig1Spine2','mixamorigSpine2','mixamorig:Spine2','Spine2','chest'],
        neck: ['mixamorig1Neck','mixamorigNeck','mixamorig:Neck','Neck','neck'],
        head: ['mixamorig1Head','mixamorigHead','mixamorig:Head','Head','head'],
        shoulderLeft: ['mixamorig1LeftShoulder','mixamorigLeftShoulder','mixamorig:LeftShoulder','LeftShoulder'],
        shoulderRight: ['mixamorig1RightShoulder','mixamorigRightShoulder','mixamorig:RightShoulder','RightShoulder'],
        upperArmLeft: ['mixamorig1LeftArm','mixamorigLeftArm','mixamorig:LeftArm','LeftArm'],
        upperArmRight: ['mixamorig1RightArm','mixamorigRightArm','mixamorig:RightArm','RightArm'],
        elbowLeft: ['mixamorig1LeftForeArm','mixamorigLeftForeArm','mixamorig:LeftForeArm','LeftForeArm'],
        elbowRight: ['mixamorig1RightForeArm','mixamorigRightForeArm','mixamorig:RightForeArm','RightForeArm'],
        wristLeft: ['mixamorig1LeftHand','mixamorigLeftHand','mixamorig:LeftHand','LeftHand'],
        wristRight: ['mixamorig1RightHand','mixamorigRightHand','mixamorig:RightHand','RightHand'],
        thighLeft: ['mixamorig1LeftUpLeg','mixamorigLeftUpLeg','mixamorig:LeftUpLeg','LeftUpLeg'],
        thighRight: ['mixamorig1RightUpLeg','mixamorigRightUpLeg','mixamorig:RightUpLeg','RightUpLeg'],
        kneeLeft: ['mixamorig1LeftLeg','mixamorigLeftLeg','mixamorig:LeftLeg','LeftLeg'],
        kneeRight: ['mixamorig1RightLeg','mixamorigRightLeg','mixamorig:RightLeg','RightLeg'],
        ankleLeft: ['mixamorig1LeftFoot','mixamorigLeftFoot','mixamorig:LeftFoot','LeftFoot'],
        ankleRight: ['mixamorig1RightFoot','mixamorigRightFoot','mixamorig:RightFoot','RightFoot'],
        toeLeft: ['mixamorig1LeftToeBase','mixamorigLeftToeBase','mixamorig:LeftToeBase','LeftToeBase'],
        toeRight: ['mixamorig1RightToeBase','mixamorigRightToeBase','mixamorig:RightToeBase','RightToeBase']
    };

    const anchorDisplayNames = {
        pelvis: 'Pelvis / Hông', spine: 'Spine / Cột sống', chest: 'Chest / Ngực', neck: 'Neck / Cổ', head: 'Head / Đầu',
        shoulderLeft: 'Vai trái', shoulderRight: 'Vai phải', upperArmLeft: 'Bắp tay trái', upperArmRight: 'Bắp tay phải',
        elbowLeft: 'Khuỷu tay trái', elbowRight: 'Khuỷu tay phải', wristLeft: 'Cổ tay trái', wristRight: 'Cổ tay phải',
        thighLeft: 'Đùi trái', thighRight: 'Đùi phải', kneeLeft: 'Gối trái', kneeRight: 'Gối phải',
        ankleLeft: 'Cổ chân trái', ankleRight: 'Cổ chân phải', toeLeft: 'Mũi chân trái', toeRight: 'Mũi chân phải'
    };

    function setStatus(message, state = 'loading') {
        statusEl.textContent = message;
        statusPill.dataset.state = state;
    }

    function normalizeBoneName(name) {
        return String(name || '').toLowerCase().replace(/[^a-z0-9]/g, '');
    }

    function findAvatarBones(model) {
        const bones = {};
        model.traverse((object) => { if (object.isBone) bones[object.name] = object; });
        avatarBones = bones;
        return bones;
    }

    function findBone(logicalName) {
        const candidates = boneMap[logicalName] ?? [];
        const entries = Object.entries(avatarBones);
        for (const candidate of candidates) {
            const normalizedCandidate = normalizeBoneName(candidate);
            const match = entries.find(([name]) => normalizeBoneName(name) === normalizedCandidate);
            if (match) return match[1];
        }
        return null;
    }

    function createAvatarAnchors() {
        const result = {};
        if (!avatar) return {};
        avatar.updateWorldMatrix(true, true);
        for (const logicalName of Object.keys(boneMap)) {
            const bone = findBone(logicalName);
            if (!bone) { result[logicalName] = null; continue; }
            const position = new THREE.Vector3();
            bone.getWorldPosition(position);
            result[logicalName] = { bone, position };
        }
        result.hip = result.pelvis ? { bone: result.pelvis.bone, position: result.pelvis.position.clone() } : null;
        result.footLeft = result.toeLeft ? { bone: result.toeLeft.bone, position: result.toeLeft.position.clone() } : null;
        result.footRight = result.toeRight ? { bone: result.toeRight.bone, position: result.toeRight.position.clone() } : null;
        anchors = result;
        return result;
    }

    function calculateAvatarMetrics(model) {
        model.updateWorldMatrix(true, true);
        const box = new THREE.Box3().setFromObject(model);
        const size = box.getSize(new THREE.Vector3());
        const center = box.getCenter(new THREE.Vector3());
        const distance = (a, b) => anchors[a]?.position && anchors[b]?.position
            ? anchors[a].position.distanceTo(anchors[b].position) : null;
        return {
            height: size.y, totalWidth: size.x, depth: size.z,
            center, min: box.min.clone(), max: box.max.clone(),
            shoulderBoneSpan: distance('shoulderLeft', 'shoulderRight'),
            hipBoneSpan: distance('thighLeft', 'thighRight'),
            ankleSpan: distance('ankleLeft', 'ankleRight'),
            unit: 'Three.js world units'
        };
    }

    function disposeGroup(group) {
        while (group.children.length) {
            const child = group.children[0];
            group.remove(child);
            child.geometry?.dispose?.();
            if (Array.isArray(child.material)) child.material.forEach(m => m.dispose?.());
            else child.material?.dispose?.();
        }
    }

    function updateAnchorMarkers() {
        disposeGroup(anchorMarkers);
        if (!anchorsVisible) return;
        const markerGeometry = new THREE.SphereGeometry(0.018, 12, 10);
        const markerMaterial = new THREE.MeshStandardMaterial({ color: 0x9eafff, emissive: 0x313f9a, emissiveIntensity: 0.35, roughness: 0.4 });
        const important = ['pelvis','chest','neck','shoulderLeft','shoulderRight','wristLeft','wristRight','kneeLeft','kneeRight','ankleLeft','ankleRight'];
        for (const name of important) {
            const anchor = anchors[name];
            if (!anchor?.position) continue;
            const marker = new THREE.Mesh(markerGeometry, markerMaterial);
            marker.position.copy(anchor.position);
            marker.name = `anchor-marker-${name}`;
            marker.renderOrder = 10;
            anchorMarkers.add(marker);
        }
    }

    function updateOverview() {
        if (!avatar || !avatarMetrics) return;
        const values = {
            metricHeight: `${avatarMetrics.height.toFixed(2)}`,
            metricBones: `${Object.keys(avatarBones).length}`,
            metricAnchors: `${Object.values(anchors).filter(Boolean).length}`,
            metricMeshes: `${skinnedMeshCount}`,
            meshName: getSkinnedMeshNames().join(', ') || 'Không tìm thấy',
            vertexCount: totalVertices.toLocaleString('vi-VN'),
            metricWidth: `${avatarMetrics.totalWidth.toFixed(2)} units`,
            metricDepth: `${avatarMetrics.depth.toFixed(2)} units`,
            viewerHeightTag: `Height: ${avatarMetrics.height.toFixed(2)}`,
            viewerBoneTag: `Bones: ${Object.keys(avatarBones).length}`,
            detailCount: `${Object.keys(avatarBones).length} bones`
        };
        for (const [id, value] of Object.entries(values)) $(id).textContent = value;
        renderAnchorList();
        renderBonesTable();
        updateAnchorMarkers();
        $('exportJsonBtn').disabled = false;
        $('toggleAvatarBtn').disabled = false;
        $('resetCameraBtn').disabled = false;
        $('refreshBtn').disabled = false;
        $('toggleAnchorsBtn').disabled = false;
    }

    function getSkinnedMeshNames() {
        const names = [];
        avatar?.traverse(object => { if (object.isSkinnedMesh) names.push(object.name || '(unnamed)'); });
        return names;
    }

    function renderAnchorList() {
        const list = $('anchorList');
        list.innerHTML = '';
        const entries = Object.entries(anchorDisplayNames);
        let found = 0;
        for (const [key, label] of entries) {
            const anchor = anchors[key];
            const row = document.createElement('div');
            row.className = 'anchor-item';
            const detail = document.createElement('div');
            const name = document.createElement('div');
            name.className = 'anchor-name';
            name.textContent = label;
            const bone = document.createElement('div');
            bone.className = 'anchor-bone';
            bone.textContent = anchor?.bone?.name || 'Không tìm thấy bone';
            detail.append(name, bone);
            const coords = document.createElement('div');
            coords.className = 'anchor-coords';
            if (anchor?.position) {
                found++;
                coords.textContent = `X ${anchor.position.x.toFixed(3)}\nY ${anchor.position.y.toFixed(3)}\nZ ${anchor.position.z.toFixed(3)}`;
                coords.style.whiteSpace = 'pre-line';
            } else {
                coords.textContent = '—';
                coords.classList.add('muted');
            }
            row.append(detail, coords);
            list.appendChild(row);
        }
        if (!entries.length) list.innerHTML = '<div class="empty-state">Chưa có anchor.</div>';
        $('metricAnchors').textContent = `${found}`;
    }

    function renderBonesTable() {
        const body = $('bonesTable');
        const query = $('boneSearch').value.trim().toLowerCase();
        const bones = Object.values(avatarBones);
        const filtered = bones.filter(bone => !query || `${bone.name} ${bone.parent?.name || ''}`.toLowerCase().includes(query));
        body.innerHTML = '';
        if (!filtered.length) {
            body.innerHTML = '<tr><td colspan="3" class="empty-state">Không tìm thấy xương phù hợp.</td></tr>';
            return;
        }
        for (const bone of filtered) {
            const row = document.createElement('tr');
            const index = document.createElement('td'); index.textContent = String(bones.indexOf(bone));
            const name = document.createElement('td'); name.className = 'code-name'; name.textContent = bone.name;
            const parent = document.createElement('td'); parent.className = 'code-name muted'; parent.textContent = bone.parent?.name || '—';
            row.append(index, name, parent);
            body.appendChild(row);
        }
    }

    function resetCamera() {
        if (!initialCamera || !initialTarget) return;
        camera.position.copy(initialCamera);
        controls.target.copy(initialTarget);
        controls.update();
    }

    function setCameraView(kind) {
        if (!avatarMetrics) return;
        const height = Math.max(avatarMetrics.height, 1);
        const target = new THREE.Vector3(0, height * 0.52, 0);
        controls.target.copy(target);
        if (kind === 'front') camera.position.set(0, height * 0.55, height * 2.6);
        if (kind === 'side') camera.position.set(height * 2.6, height * 0.55, 0);
        if (kind === 'back') camera.position.set(0, height * 0.55, -height * 2.6);
        camera.near = Math.max(height / 1000, 0.001);
        camera.far = Math.max(height * 20, 100);
        camera.updateProjectionMatrix();
        controls.update();
    }

    function refreshData() {
        if (!avatar) return;
        avatar.updateWorldMatrix(true, true);
        createAvatarAnchors();
        avatarMetrics = calculateAvatarMetrics(avatar);
        updateOverview();
        setStatus('Avatar đã sẵn sàng', 'ready');
    }

    function exportJson() {
        if (!avatar || !avatarMetrics) return;
        const output = {
            avatarUrl: AVATAR_URL,
            meshes: [],
            bones: Object.values(avatarBones).map(bone => ({ name: bone.name, parent: bone.parent?.name ?? null })),
            anchors: Object.fromEntries(Object.entries(anchors).map(([name, value]) => [name, value ? {
                bone: value.bone.name,
                position: { x: value.position.x, y: value.position.y, z: value.position.z }
            } : null])),
            metrics: {
                height: avatarMetrics.height,
                totalWidth: avatarMetrics.totalWidth,
                depth: avatarMetrics.depth,
                shoulderBoneSpan: avatarMetrics.shoulderBoneSpan,
                hipBoneSpan: avatarMetrics.hipBoneSpan,
                ankleSpan: avatarMetrics.ankleSpan,
                unit: avatarMetrics.unit
            }
        };
        avatar.traverse(object => {
            if (object.isSkinnedMesh) output.meshes.push({
                name: object.name,
                vertices: object.geometry?.attributes?.position?.count ?? 0,
                material: Array.isArray(object.material) ? object.material.map(m => m.name) : object.material?.name ?? null
            });
        });
        const blob = new Blob([JSON.stringify(output, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'lhw-avatar-diagnostics.json';
        document.body.appendChild(link);
        link.click();
        link.remove();
        URL.revokeObjectURL(url);
    }

    function setLoading(show, title, message) {
        loadingOverlay.classList.toggle('hidden', !show);
        if (title) $('loadingTitle').textContent = title;
        if (message) $('loadingText').textContent = message;
    }

    const loader = new GLTFLoader();
    setStatus('Đang tải avatar…', 'loading');
    loader.load(
        AVATAR_URL,
        (gltf) => {
            avatar = gltf.scene;
            scene.add(avatar);
            avatar.updateWorldMatrix(true, true);

            const originalBox = new THREE.Box3().setFromObject(avatar);
            const originalCenter = originalBox.getCenter(new THREE.Vector3());
            avatar.position.x -= originalCenter.x;
            avatar.position.z -= originalCenter.z;
            avatar.updateWorldMatrix(true, true);
            const groundedBox = new THREE.Box3().setFromObject(avatar);
            avatar.position.y -= groundedBox.min.y;
            avatar.updateWorldMatrix(true, true);

            skinnedMeshCount = 0;
            totalVertices = 0;
            avatar.traverse((object) => {
                if (object.isMesh) {
                    object.castShadow = true;
                    object.receiveShadow = true;
                }
                if (object.isSkinnedMesh) {
                    skinnedMeshCount++;
                    totalVertices += object.geometry?.attributes?.position?.count ?? 0;
                }
            });

            findAvatarBones(avatar);
            createAvatarAnchors();
            avatarMetrics = calculateAvatarMetrics(avatar);
            updateOverview();

            const height = Math.max(avatarMetrics.height, 1);
            controls.target.set(0, height * 0.52, 0);
            camera.position.set(0, height * 0.57, height * 2.55);
            camera.near = Math.max(height / 1000, 0.001);
            camera.far = Math.max(height * 20, 100);
            camera.updateProjectionMatrix();
            controls.update();
            initialCamera = camera.position.clone();
            initialTarget = controls.target.clone();

            $('toggleAvatarBtn').textContent = 'Ẩn avatar';
            $('toggleAvatarBtn').addEventListener('click', () => {
                avatar.visible = !avatar.visible;
                $('toggleAvatarBtn').textContent = avatar.visible ? 'Ẩn avatar' : 'Hiện avatar';
            });
            $('resetCameraBtn').addEventListener('click', resetCamera);
            $('refreshBtn').addEventListener('click', refreshData);
            $('toggleAnchorsBtn').addEventListener('click', () => {
                anchorsVisible = !anchorsVisible;
                anchorMarkers.visible = anchorsVisible;
                $('toggleAnchorsBtn').textContent = anchorsVisible ? 'Ẩn anchor' : 'Hiện anchor';
                updateAnchorMarkers();
            });
            $('frontViewBtn').addEventListener('click', () => setCameraView('front'));
            $('sideViewBtn').addEventListener('click', () => setCameraView('side'));
            $('backViewBtn').addEventListener('click', () => setCameraView('back'));
            $('exportJsonBtn').addEventListener('click', exportJson);
            $('boneSearch').addEventListener('input', renderBonesTable);
            $('anchorsTab').addEventListener('click', () => switchTab('anchors'));
            $('bonesTab').addEventListener('click', () => switchTab('bones'));
            for (const id of ['frontViewBtn','sideViewBtn','backViewBtn']) $(id).disabled = false;

            setLoading(false);
            setStatus(`Avatar sẵn sàng · ${Object.keys(avatarBones).length} xương`, 'ready');
            console.info('[LHW Avatar Diagnostics] Loaded', { AVATAR_URL, avatarMetrics, avatarBones, anchors });
        },
        (event) => {
            if (event.total > 0) {
                const percent = Math.min(100, Math.round(event.loaded / event.total * 100));
                progressBar.style.width = `${percent}%`;
                $('loadingText').textContent = `Đang tải model… ${percent}%`;
            }
        },
        (error) => {
            console.error('Không tải được avatar GLB:', error);
            setStatus('Không tải được avatar', 'error');
            $('loadingSpinner').classList.add('hidden');
            $('loadingTitle').textContent = 'Không tải được avatar.glb';
            $('loadingText').textContent = 'Kiểm tra đường dẫn tệp và Console (F12).';
            const note = document.createElement('div');
            note.className = 'alert';
            note.textContent = `URL đang dùng: ${AVATAR_URL}`;
            document.querySelector('.loading-card').appendChild(note);
        }
    );

    function switchTab(tab) {
        const anchorsSelected = tab === 'anchors';
        $('anchorsTab').setAttribute('aria-selected', String(anchorsSelected));
        $('bonesTab').setAttribute('aria-selected', String(!anchorsSelected));
        $('anchorsPane').classList.toggle('hidden', !anchorsSelected);
        $('bonesPane').classList.toggle('hidden', anchorsSelected);
    }

    const resizeObserver = new ResizeObserver(() => {
        const width = container.clientWidth;
        const height = container.clientHeight;
        if (!width || !height) return;
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    });
    resizeObserver.observe(container);

    window.addEventListener('beforeunload', () => {
        resizeObserver.disconnect();
        controls.dispose();
        renderer.dispose();
    });

    renderer.setAnimationLoop(() => {
        controls.update();
        renderer.render(scene, camera);
    });

    window.LHWAvatar = {
        get avatar() { return avatar; },
        get bones() { return avatarBones; },
        get anchors() { return anchors; },
        get metrics() { return avatarMetrics; },
        findBone,
        createAvatarAnchors,
        calculateAvatarMetrics,
        refreshAvatarData: refreshData,
        getWorldPosition(boneName) {
            const bone = avatarBones[boneName];
            if (!bone || !avatar) return null;
            avatar.updateWorldMatrix(true, true);
            return bone.getWorldPosition(new THREE.Vector3());
        }
    };
</script>
</body>
</html>
