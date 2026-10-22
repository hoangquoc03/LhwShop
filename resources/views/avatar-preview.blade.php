<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LHW AI Fashion Studio - Avatar Test</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #171717;
            color: white;
        }

        header {
            padding: 16px 22px;
            background: #222;
        }

        h2 {
            margin: 0 0 6px;
        }

        #status {
            color: #bbb;
            font-size: 14px;
        }

        #viewer {
            width: 100%;
            height: 78vh;
            min-height: 420px;
        }

        #viewer canvas {
            display: block;
        }
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
    <header>
        <h2>LHW AI Fashion Studio</h2>
        <div id="status">Đang khởi tạo Three.js...</div>
    </header>

    <div id="viewer"></div>


    <script type="module">
        import * as THREE from 'three';

        import {
            GLTFLoader
        } from 'three/addons/loaders/GLTFLoader.js';

        import {
            OrbitControls
        } from 'three/addons/controls/OrbitControls.js';


        // =====================================================
        // 1. DOM
        // =====================================================

        const container = document.getElementById('viewer');
        const status = document.getElementById('status');

        if (!container || !status) {
            throw new Error(
                'Không tìm thấy phần tử #viewer hoặc #status.'
            );
        }


        // =====================================================
        // 2. THREE.JS SCENE
        // Quy ước: X = trái/phải, Y = chiều cao, Z = trước/sau
        // =====================================================

        const scene = new THREE.Scene();

        scene.background = new THREE.Color(0x242424);

        const camera = new THREE.PerspectiveCamera(
            40,
            container.clientWidth / container.clientHeight,
            0.01,
            100
        );

        camera.position.set(0, 1.6, 4);

        const renderer = new THREE.WebGLRenderer({
            antialias: true,
            alpha: false
        });

        renderer.setPixelRatio(
            Math.min(window.devicePixelRatio, 2)
        );

        renderer.setSize(
            container.clientWidth,
            container.clientHeight
        );

        renderer.outputColorSpace = THREE.SRGBColorSpace;

        container.appendChild(renderer.domElement);


        // =====================================================
        // 3. CAMERA CONTROLS
        // =====================================================

        const controls = new OrbitControls(
            camera,
            renderer.domElement
        );

        controls.enableDamping = true;
        controls.dampingFactor = 0.06;

        controls.target.set(0, 0.9, 0);


        // =====================================================
        // 4. LIGHTING
        // =====================================================

        scene.add(
            new THREE.HemisphereLight(
                0xffffff,
                0x777777,
                2
            )
        );

        const light = new THREE.DirectionalLight(
            0xffffff,
            2
        );

        light.position.set(3, 5, 4);

        scene.add(light);


        // =====================================================
        // 5. GROUND GRID
        // =====================================================

        const grid = new THREE.GridHelper(
            10,
            20,
            0x888888,
            0x444444
        );

        scene.add(grid);


        // =====================================================
        // 6. AVATAR STATE
        // =====================================================

        let avatar = null;

        let avatarBones = {};

        let anchors = {};

        let avatarMetrics = null;


        // =====================================================
        // 7. BONE MAPPING
        // Hỗ trợ nhiều quy ước đặt tên phổ biến.
        // Tên thực tế còn tùy thuộc file GLB.
        // =====================================================


        const boneMap = {
            pelvis: [
                'mixamorig1Hips',
                'mixamorigHips',
                'mixamorig:Hips',
                'Hips',
                'pelvis'
            ],

            spine: [
                'mixamorig1Spine',
                'mixamorigSpine',
                'mixamorig:Spine',
                'Spine',
                'spine'
            ],

            chest: [
                'mixamorig1Spine2',
                'mixamorigSpine2',
                'mixamorig:Spine2',
                'Spine2',
                'chest'
            ],

            neck: [
                'mixamorig1Neck',
                'mixamorigNeck',
                'mixamorig:Neck',
                'Neck',
                'neck'
            ],

            head: [
                'mixamorig1Head',
                'mixamorigHead',
                'mixamorig:Head',
                'Head',
                'head'
            ],

            shoulderLeft: [
                'mixamorig1LeftShoulder',
                'mixamorigLeftShoulder',
                'mixamorig:LeftShoulder',
                'LeftShoulder'
            ],

            shoulderRight: [
                'mixamorig1RightShoulder',
                'mixamorigRightShoulder',
                'mixamorig:RightShoulder',
                'RightShoulder'
            ],

            upperArmLeft: [
                'mixamorig1LeftArm',
                'mixamorigLeftArm',
                'mixamorig:LeftArm',
                'LeftArm'
            ],

            upperArmRight: [
                'mixamorig1RightArm',
                'mixamorigRightArm',
                'mixamorig:RightArm',
                'RightArm'
            ],

            elbowLeft: [
                'mixamorig1LeftForeArm',
                'mixamorigLeftForeArm',
                'mixamorig:LeftForeArm',
                'LeftForeArm'
            ],

            elbowRight: [
                'mixamorig1RightForeArm',
                'mixamorigRightForeArm',
                'mixamorig:RightForeArm',
                'RightForeArm'
            ],

            wristLeft: [
                'mixamorig1LeftHand',
                'mixamorigLeftHand',
                'mixamorig:LeftHand',
                'LeftHand'
            ],

            wristRight: [
                'mixamorig1RightHand',
                'mixamorigRightHand',
                'mixamorig:RightHand',
                'RightHand'
            ],

            thighLeft: [
                'mixamorig1LeftUpLeg',
                'mixamorigLeftUpLeg',
                'mixamorig:LeftUpLeg',
                'LeftUpLeg'
            ],

            thighRight: [
                'mixamorig1RightUpLeg',
                'mixamorigRightUpLeg',
                'mixamorig:RightUpLeg',
                'RightUpLeg'
            ],

            kneeLeft: [
                'mixamorig1LeftLeg',
                'mixamorigLeftLeg',
                'mixamorig:LeftLeg',
                'LeftLeg'
            ],

            kneeRight: [
                'mixamorig1RightLeg',
                'mixamorigRightLeg',
                'mixamorig:RightLeg',
                'RightLeg'
            ],

            ankleLeft: [
                'mixamorig1LeftFoot',
                'mixamorigLeftFoot',
                'mixamorig:LeftFoot',
                'LeftFoot'
            ],

            ankleRight: [
                'mixamorig1RightFoot',
                'mixamorigRightFoot',
                'mixamorig:RightFoot',
                'RightFoot'
            ],

            toeLeft: [
                'mixamorig1LeftToeBase',
                'mixamorigLeftToeBase',
                'mixamorig:LeftToeBase',
                'LeftToeBase'
            ],

            toeRight: [
                'mixamorig1RightToeBase',
                'mixamorigRightToeBase',
                'mixamorig:RightToeBase',
                'RightToeBase'
            ]
        };



        // Chuẩn hóa tên để so sánh.
        function normalizeBoneName(name) {
            return name
                .toLowerCase()
                .replace(/[^a-z0-9]/g, '');
        }


        // =====================================================
        // 8. FIND BONES
        // =====================================================

        function findAvatarBones(model) {
            const bones = {};

            model.traverse((object) => {
                if (!object.isBone) return;

                bones[object.name] = object;
            });

            avatarBones = bones;

            console.group('LHW Avatar - Skeleton');

            console.log(
                'Tổng số bones:',
                Object.keys(bones).length
            );

            console.table(
                Object.values(bones).map((bone) => ({
                    name: bone.name,
                    parent: bone.parent?.name ?? null
                }))
            );

            console.groupEnd();

            return bones;
        }


        // =====================================================
        // 9. RESOLVE BONE NAMES
        // =====================================================


        function findBone(logicalName) {
            const candidates = boneMap[logicalName] ?? [];
            const entries = Object.entries(avatarBones);

            for (const candidate of candidates) {
                const normalizedCandidate =
                    normalizeBoneName(candidate);

                const match = entries.find(([name]) =>
                    normalizeBoneName(name) === normalizedCandidate
                );

                if (match) {
                    return match[1];
                }
            }

            return null;
        }



        // =====================================================
        // 10. GET WORLD POSITION
        // =====================================================

        function getBoneWorldPosition(logicalName) {
            const bone = findBone(logicalName);

            if (!bone) return null;

            const position = new THREE.Vector3();

            bone.updateWorldMatrix(true, false);

            bone.getWorldPosition(position);

            return position;
        }


        // =====================================================
        // 11. CREATE ANCHORS
        // Mỗi anchor có bone, position và trạng thái.
        // =====================================================


        function createAvatarAnchors() {
            const result = {};

            // Cập nhật matrix trước khi đọc vị trí bone.
            if (!avatar) {
                console.warn('Avatar chưa được tải.');
                return {};
            }

            avatar.updateWorldMatrix(true, true);

            // Tạo anchor từ bone theo world coordinates.
            for (const logicalName of Object.keys(boneMap)) {
                const bone = findBone(logicalName);

                if (!bone) {
                    result[logicalName] = null;
                    continue;
                }

                const position = new THREE.Vector3();
                bone.updateWorldMatrix(true, false);
                bone.getWorldPosition(position);

                result[logicalName] = {
                    bone,
                    position
                };
            }

            // Alias cho hông.
            if (!result.hip && result.pelvis) {
                result.hip = {
                    bone: result.pelvis.bone,
                    position: result.pelvis.position.clone()
                };
            }

            // Nếu không tìm thấy chest, dùng spine2 hoặc spine.
            if (!result.chest) {
                const fallbackBone =
                    findBone('chest') || findBone('spine');

                if (fallbackBone) {
                    const position = new THREE.Vector3();
                    fallbackBone.getWorldPosition(position);

                    result.chest = {
                        bone: fallbackBone,
                        position
                    };
                }
            }

            // Các alias phải có position riêng, không dùng chung Vector3.
            const aliases = {
                footLeft: 'toeLeft',
                footRight: 'toeRight'
            };

            for (const [alias, source] of Object.entries(aliases)) {
                if (result[source]) {
                    result[alias] = {
                        bone: result[source].bone,
                        position: result[source].position.clone()
                    };
                } else {
                    result[alias] = null;
                }
            }

            anchors = result;

            console.group('LHW Avatar - Anchors');
            console.table(
                Object.entries(anchors).map(([name, anchor]) => ({
                    anchor: name,
                    found: Boolean(anchor),
                    bone: anchor?.bone?.name ?? null,
                    x: anchor ? anchor.position.x.toFixed(3) : null,
                    y: anchor ? anchor.position.y.toFixed(3) : null,
                    z: anchor ? anchor.position.z.toFixed(3) : null
                }))
            );
            console.groupEnd();

            return anchors;
        }



        // =====================================================
        // 12. AVATAR METRICS
        // =====================================================


        function calculateAvatarMetrics(model) {
            model.updateWorldMatrix(true, true);

            // Kích thước tổng thể của mesh và skeleton.
            const box = new THREE.Box3().setFromObject(model);
            const size = box.getSize(new THREE.Vector3());
            const center = box.getCenter(new THREE.Vector3());

            // Đo khoảng cách giữa các anchor quan trọng.
            const getDistance = (a, b) => {
                if (!anchors[a] || !anchors[b]) return null;

                return anchors[a].position.distanceTo(
                    anchors[b].position
                );
            };

            const shoulderBoneSpan = getDistance(
                'shoulderLeft',
                'shoulderRight'
            );

            const hipBoneSpan = getDistance(
                'thighLeft',
                'thighRight'
            );

            const ankleSpan = getDistance(
                'ankleLeft',
                'ankleRight'
            );

            return {
                // Kích thước toàn bộ model, có thể bao gồm cả hai tay.
                height: size.y,
                totalWidth: size.x,
                depth: size.z,

                center: center.clone(),
                min: box.min.clone(),
                max: box.max.clone(),

                // Khoảng cách giữa các bone, KHÔNG phải số đo vòng cơ thể.
                shoulderBoneSpan,
                hipBoneSpan,
                ankleSpan,

                // Ghi rõ đơn vị để dùng nhất quán về sau.
                unit: 'meters'
            };
        }

        function refreshAvatarData() {
            if (!avatar) {
                console.warn('Chưa có avatar để cập nhật.');
                return null;
            }

            avatar.updateWorldMatrix(true, true);

            // Đọc lại vị trí các bone.
            createAvatarAnchors();

            // Tính lại kích thước sau khi cập nhật anchors.
            avatarMetrics = calculateAvatarMetrics(avatar);

            console.log('LHW Avatar - Refreshed');
            console.log('Anchors:', anchors);
            console.log('Metrics:', avatarMetrics);

            return {
                anchors,
                metrics: avatarMetrics
            };
        }




        // =====================================================
        // 13. LOAD AVATAR
        // =====================================================

        const loader = new GLTFLoader();

        status.textContent = 'Đang tải avatar...';

        loader.load(
            '/lhwshop/public/models/avatar/avatar.glb',

            (gltf) => {
                avatar = gltf.scene;

                scene.add(avatar);

                // Cập nhật ma trận trước khi đo.
                avatar.updateWorldMatrix(true, true);

                const initialBox = new THREE.Box3()
                    .setFromObject(avatar);

                const initialCenter = initialBox.getCenter(
                    new THREE.Vector3()
                );

                // Căn giữa theo X và Z.
                avatar.position.x -= initialCenter.x;
                avatar.position.z -= initialCenter.z;

                // Đưa điểm thấp nhất về Y = 0.
                avatar.updateWorldMatrix(true, true);

                const groundedBox = new THREE.Box3()
                    .setFromObject(avatar);

                avatar.position.y -= groundedBox.min.y;

                avatar.updateWorldMatrix(true, true);

                // Tìm bones trước.
                findAvatarBones(avatar);

                // Tạo anchors trước khi tính các khoảng cách giữa bone.
                createAvatarAnchors();

                // Sau đó mới tính metrics.
                avatarMetrics = calculateAvatarMetrics(avatar);

                console.log('Avatar metrics:', avatarMetrics);

                // Camera nhìn vào giữa thân người.
                controls.target.set(
                    0,
                    avatarMetrics.height * 0.5,
                    0
                );

                camera.position.set(
                    0,
                    avatarMetrics.height * 0.65,
                    Math.max(avatarMetrics.height * 2.5, 2)
                );

                camera.near = 0.01;
                camera.far = Math.max(
                    100,
                    avatarMetrics.height * 20
                );

                camera.updateProjectionMatrix();

                controls.update();

                // Tìm bones và tạo anchors.
                findAvatarBones(avatar);

                createAvatarAnchors();

                const foundAnchors = Object.entries(anchors)
                    .filter(([name, value]) =>
                        value &&
                        ![
                            'shoulderLeft',
                            'shoulderRight',
                            'elbowLeft',
                            'elbowRight',
                            'wristLeft',
                            'wristRight',
                            'kneeLeft',
                            'kneeRight',
                            'ankleLeft',
                            'ankleRight',
                            'footLeft',
                            'footRight'
                        ].includes(name)
                    ).length;

                status.textContent =
                    `Tải thành công | Cao: ${avatarMetrics.height.toFixed(2)} m | ` +
                    `Bones: ${Object.keys(avatarBones).length} | ` +
                    `Anchors: ${foundAnchors}`;

                console.log('Avatar loaded:', avatar);

                console.log('Bone map:', avatarBones);

                console.log('Anchors:', anchors);

                console.log('Metrics:', avatarMetrics);
            },

            (event) => {
                if (event.total > 0) {
                    const percent = Math.round(
                        event.loaded / event.total * 100
                    );

                    status.textContent =
                        `Đang tải avatar: ${percent}%`;
                }
            },

            (error) => {
                console.error(
                    'Không tải được avatar GLB:',
                    error
                );

                status.textContent =
                    'Lỗi tải avatar. Kiểm tra URL và Console (F12).';
            }
        );


        // =====================================================
        // 14. RESIZE
        // =====================================================

        window.addEventListener('resize', () => {
            const width = container.clientWidth;
            const height = container.clientHeight;

            if (!width || !height) return;

            camera.aspect = width / height;

            camera.updateProjectionMatrix();

            renderer.setSize(width, height);
        });


        // =====================================================
        // 15. RENDER LOOP
        // =====================================================

        renderer.setAnimationLoop(() => {
            controls.update();

            renderer.render(scene, camera);
        });


        // =====================================================
        // 16. EXPOSE FOR DEBUGGING
        // Dùng trong Console khi avatar đã tải xong.
        // =====================================================



        window.LHWAvatar = {
            get avatar() {
                return avatar;
            },

            get bones() {
                return avatarBones;
            },

            get anchors() {
                return anchors;
            },

            get metrics() {
                return avatarMetrics;
            },

            findBone,
            getBoneWorldPosition,
            createAvatarAnchors,
            calculateAvatarMetrics,

            refreshAvatarData() {
                if (!avatar) {
                    console.warn('Chưa có avatar để cập nhật.');
                    return null;
                }

                avatar.updateWorldMatrix(true, true);

                createAvatarAnchors();
                avatarMetrics = calculateAvatarMetrics(avatar);

                console.log('LHW Avatar - Refreshed');
                console.log('Anchors:', anchors);
                console.log('Metrics:', avatarMetrics);

                return {
                    anchors,
                    metrics: avatarMetrics
                };
            },

            getWorldPosition(boneName) {
                const bone = avatarBones[boneName];

                if (!bone) {
                    console.warn('Không tìm thấy bone:', boneName);
                    return null;
                }

                avatar.updateWorldMatrix(true, true);

                const position = new THREE.Vector3();
                bone.getWorldPosition(position);

                return position;
            }
        };
    </script>

</body>

</html>
