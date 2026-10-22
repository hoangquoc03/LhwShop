<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>LHW AI Fashion Studio - Virtual Fitting Room</title>

        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background: #f4f4f5;
                color: #18181b;
            }

            .fitting-app {
                max-width: 1200px;
                margin: auto;
                padding: 20px;
            }

            #fittingViewer {
                height: 68vh;
                min-height: 420px;
                background: #e8e8eb;
                border-radius: 16px;
                overflow: hidden;
            }

            #fittingViewer canvas {
                display: block;
                width: 100%;
                height: 100%;
            }

            .toolbar {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin: 16px 0;
            }

            button {
                padding: 11px 16px;
                border: 1px solid #d4d4d8;
                border-radius: 9px;
                background: white;
                cursor: pointer;
            }

            button:hover {
                background: #f4f4f5;
            }

            #fittingStatus {
                color: #52525b;
                font-size: 14px;
            }

            .fitting-status-heading {
                margin: 0 0 8px;
                font-size: 16px;
            }

            .fitting-status-item {
                display: grid;
                gap: 3px;
                margin: 6px 0;
                padding: 9px 11px;
                border-left: 4px solid #a1a1aa;
                border-radius: 4px;
                background: #fff;
            }

            .fitting-status-item[data-state='ready'] {
                border-left-color: #16a34a;
            }

            .fitting-status-item[data-state='pending'],
            .fitting-status-item[data-state='warning'] {
                border-left-color: #d97706;
                background: #fffbeb;
            }

            .fitting-status-item[data-state='error'] {
                border-left-color: #dc2626;
                background: #fef2f2;
            }

            .fitting-status-note {
                font-size: 13px;
            }

            .debug-panel {
                display: grid;
                gap: 8px;
                margin: 16px 0;
                padding: 16px;
                border: 1px solid #d4d4d8;
                border-radius: 12px;
                background: #fff;
                font-size: 13px;
            }

            .debug-panel h2 {
                margin: 0;
                font-size: 18px;
            }

            .debug-panel select,
            .debug-panel input {
                box-sizing: border-box;
                min-width: 0;
                padding: 6px;
                border: 1px solid #d4d4d8;
                border-radius: 6px;
            }

            .debug-panel select {
                margin-left: 6px;
            }

            .debug-vector {
                display: grid;
                grid-template-columns: minmax(150px, 1.5fr) repeat(
                        3,
                        minmax(64px, 1fr)
                    );
                align-items: center;
                gap: 6px;
            }

            .debug-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .debug-anchors {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
                gap: 4px 12px;
                padding-top: 6px;
                border-top: 1px solid #e4e4e7;
            }

            .fitting-warning {
                margin: 4px 0;
                padding: 10px 12px;
                border-left: 4px solid #d97706;
                border-radius: 4px;
                background: #fffbeb;
                color: #78350f;
            }

            @media (max-width: 600px) {
                .debug-vector {
                    grid-template-columns: 1fr repeat(3, minmax(54px, 0.7fr));
                }
            }
        </style>
    </head>

    <body>
        <div class="fitting-app">
            <h1>LHW AI Fashion Studio</h1>
            <p>Virtual Fitting Room — bản thử nghiệm 3D</p>

            <div id="fittingViewer"></div>

            <div class="toolbar">
                <button id="rotateAvatar">Bật/tắt xoay</button>
                <button id="reloadOutfit">Tải lại outfit</button>
                <button id="resetCamera">Đặt lại góc nhìn</button>
                <a href="{{ route("glb-inspector") }}">
                    GLB Landmark Inspector
                </a>
            </div>

            <section
                id="fittingDebug"
                class="debug-panel"
                aria-live="polite"
                aria-label="Thông tin debug căn chỉnh"
            ></section>

            <div id="fittingStatus" aria-live="polite">
                Đang khởi tạo phòng thử đồ...
            </div>
        </div>

        <script>
            window.LHW_FITTING_CONFIG = {
                avatarUrl: '/models/avatar/avatar.glb',
                features: {
                    // Re-enable only after product 22 has verified individual shoe assets.
                    renderShoes3D: false,
                },

                autoFit: {
                    enabled: true,

                    // Ưu tiên landmarks; thiếu landmarks thì dùng thuật toán cũ.
                    strategy: 'landmarks-first',

                    fallback: 'legacy',

                    categories: {
                        top: {
                            requiredLandmarks: @json(config("lhw_fitting.landmarks.top")),
                        },

                        bottom: {
                            requiredLandmarks: @json(config("lhw_fitting.landmarks.bottom")),
                        },
                    },

                    validation: {
                        minimumScale: 0.02,
                        maximumScale: 50,
                        maximumRmsRelativeToAvatarHeight: 0.08,
                    },
                },

                // Thay các ID này bằng ID sản phẩm thật trong database.
                outfit: {
                    top: 13,
                    bottom: 17,
                    shoes: 22,
                },

                // Replace modelUrl per product ID without changing the fitting engine.
                // render3D enables an explicitly experimental preview; it does not certify quality.
                // qualityStatus records review state; it is not inferred from successful loading.
                // For split shoes, set both leftShoeUrl and rightShoeUrl; keep modelUrl as fallback.
                productAssets: {
                    13: {
                        modelUrl: '/models/products/13/product.glb',
                        render3D: true,
                        qualityStatus: 'known-incomplete-geometry',
                        warnings: [
                            'Lưng áo có vùng hở hình học đã quan sát ở góc sau; vật liệu opaque/DoubleSide. Thay GLB bằng asset có back panel đầy đủ hoặc chỉnh trong Blender.',
                        ],
                    },
                    17: {
                        modelUrl: '/models/products/17/product.glb',
                        render3D: true,
                        qualityStatus: 'known-incomplete-geometry',
                        warnings: [
                            'Quần có vùng hở hình học đã quan sát ở hông/mông/chân; vật liệu opaque/DoubleSide. Thay GLB bằng asset đầy đủ hoặc chỉnh topology trong Blender.',
                        ],
                    },
                    22: {
                        modelUrl: '/models/products/22/product.glb',
                        render3D: false,
                        qualityStatus: 'pending-review',
                        leftShoeUrl: null,
                        rightShoeUrl: null,
                    },
                },

                // Values are meters/degrees; normalization runs after restoring source transforms
                // and applying local rotation, then scaling and world-space translation.
                productFit: {
                    13: {
                        positionOffset: [0, 0, -0.07],
                        rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: {
                            pivot: 'bounds-center',
                            scale: 'axis',
                        },
                    },
                    17: {
                        positionOffset: [0, 0, 0],
                        rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1.08, 1, 1.12],
                        normalization: {
                            pivot: 'bounds-center',
                            scale: 'axis',
                        },
                    },
                    22: {
                        positionOffset: [0, 0, 0],
                        rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: {
                            pivot: 'bounds-center',
                            scale: 'axis',
                        },
                        parts: {
                            left: {
                                positionOffset: [0, 0, 0],
                                rotationOffset: [0, 0, 0],
                                scaleMultiplier: [1, 1, 1],
                                normalization: {
                                    pivot: 'bounds-center',
                                    scale: 'axis',
                                },
                            },
                            right: {
                                positionOffset: [0, 0, 0],
                                rotationOffset: [0, 0, 0],
                                scaleMultiplier: [1, 1, 1],
                                normalization: {
                                    pivot: 'bounds-center',
                                    scale: 'axis',
                                },
                            },
                        },
                    },
                },
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

        <script type="module" src="/js/lhw-fitting-room.js"></script>
    </body>
</html>
