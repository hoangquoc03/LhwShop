@extends('frontend.master')
@section('title')
    Thử đồ
@endsection

@section('page-style')
    <style>
        /* ===============================
                           FIX CONTAINER MASTER LAYOUT
                           =============================== */

        /* Gỡ max-width của master layout */
        .tryon-page {
            width: 100vw;
            margin-left: calc(-50vw + 50%);
        }

        /* Nếu master dùng .container */
        .tryon-page .container,
        .tryon-page .container-fluid {
            max-width: none !important;
            width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Fix main full height */
        .tryon-page main {
            min-height: 1000vh;
        }

        /* Fix grid desktop */
        @media (min-width: 1024px) {
            .tryon-page main {
                grid-template-columns: 320px 1fr 320px;
            }
        }

        /* Fix sidebar không bị ép */
        .tryon-page .sidebar {
            min-width: 320px;
        }

        /* Fix stage luôn ở giữa */
        .tryon-page .stage {
            min-width: 0;
        }

        /* --- Reset & Base Styles --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #111827;
            min-height: 100vh;
            overflow-x: hidden;
        }


        button {
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* --- Utilities --- */
        .hidden {
            display: none !important;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-center {
            justify-content: center;
        }

        .flex-col {
            flex-direction: column;
        }

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
        }

        .w-full {
            width: 100%;
        }

        .h-full {
            height: 100%;
        }

        /* --- Typography --- */
        .text-xs {
            font-size: 12px;
            line-height: 16px;
        }

        .text-sm {
            font-size: 14px;
            line-height: 20px;
        }

        .text-lg {
            font-size: 18px;
            line-height: 28px;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-gray-400 {
            color: #9ca3af;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .text-gray-600 {
            color: #4b5563;
        }

        .text-gray-900 {
            color: #111827;
        }

        .text-white {
            color: #ffffff;
        }

        .tracking-tight {
            letter-spacing: -0.025em;
        }

        .tracking-tighter {
            letter-spacing: -0.05em;
        }

        .uppercase {
            text-transform: uppercase;
        }

        /* --- Navigation --- */
        nav {
            height: 64px;
            border-bottom: 1px solid #f3f4f6;
            /* gray-100 */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(4px);
            z-index: 50;
            flex-shrink: 0;
        }

        .nav-links {
            display: none;
            gap: 24px;
            margin-left: 32px;
        }

        .nav-links a:hover {
            color: #000;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .icon-btn {
            padding: 8px;
            color: #6b7280;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-btn:hover {
            color: #000;
            background-color: #f9fafb;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid #e5e7eb;
        }

        .badge-dot {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 8px;
            height: 8px;
            background-color: #000;
            border-radius: 50%;
        }

        /* --- Main Layout --- */
        main {
            display: grid;
            grid-template-columns: 1fr;
            min-height: calc(100vh - 64px);
            /* trừ header */
        }


        /* --- Sidebar (Left & Right) --- */
        .sidebar {
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-left {
            padding: 24px;
            gap: 32px;
            border-right: 1px solid #f3f4f6;
        }

        .sidebar-right {
            border-left: 1px solid #f3f4f6;
        }

        .section-divider {
            border-top: 1px solid #f3f4f6;
            padding-top: 24px;
        }

        /* --- Inputs & Sliders --- */
        .input-group {
            margin-bottom: 24px;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .value-display {
            font-family: monospace;
            color: #111827;
        }

        input[type=range] {
            -webkit-appearance: none;
            width: 100%;
            background: transparent;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 16px;
            width: 16px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #171717;
            cursor: pointer;
            margin-top: -6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.1s;
        }

        input[type=range]:active::-webkit-slider-thumb {
            transform: scale(1.1);
        }

        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 4px;
            cursor: pointer;
            background: #e5e7eb;
            border-radius: 2px;
        }

        /* --- Skin Tones --- */
        .skin-options {
            display: flex;
            gap: 12px;
        }

        .skin-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid transparent;
            /* Ring offset simulation */
            box-shadow: 0 0 0 2px transparent;
            /* Outer ring */
            transition: all 0.2s;
        }

        .skin-btn:hover {
            box-shadow: 0 0 0 2px #e5e7eb;
        }

        .skin-btn.active {
            box-shadow: 0 0 0 2px #000000;
            border-color: #fff;
        }

        /* --- AI Suggestion Box --- */
        .ai-box {
            background-color: #f9fafb;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #f3f4f6;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        /* --- Central Stage (Model) --- */
        .stage {
            background-color: #f9fafb;
            position: relative;
            display: flex;

            align-items: center;
            justify-content: center;
            overflow: hidden;
            min-height: calc(100vh - 64px - 120px);
        }

        .grid-bg {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.4;
            pointer-events: none;
        }

        .live-badge {
            position: absolute;
            top: 24px;
            left: 24px;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            padding: 6px 12px;
            border-radius: 9999px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #22c55e;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }

        .model-container {
            position: relative;
            width: 100%;
            height: 100%;
            max-width: 448px;
            margin: 0 auto;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 48px;
            z-index: 0;
        }

        .shadow-oval {
            position: absolute;
            bottom: 40px;
            width: 128px;
            height: 16px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 100%;
            filter: blur(8px);
        }

        #model-silhouette {
            height: 80%;
            width: auto;
            filter: drop-shadow(0 20px 13px rgba(0, 0, 0, 0.03)) drop-shadow(0 8px 5px rgba(0, 0, 0, 0.08));
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: bottom center;
        }

        #body-fill {
            transition: fill 0.3s ease;
        }

        .clothing-layer {
            position: absolute;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .clothing-svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 4px 3px rgba(0, 0, 0, 0.07));
        }

        /* --- Controls --- */
        .controls-overlay {
            position: absolute;
            bottom: 24px;
            display: flex;
            gap: 16px;
            z-index: 20;
        }

        .btn-reset {
            background: #fff;
            padding: 12px;
            border-radius: 50%;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f3f4f6;
            transition: transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-reset:hover {
            transform: scale(1.05);
        }

        .btn-camera {
            background: #000;
            color: #fff;
            padding: 12px 24px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.025em;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: background 0.2s;
        }

        .btn-camera:hover {
            background: #1f2937;
        }

        /* --- Right Sidebar (Wardrobe) --- */
        .tabs-header {
            padding: 16px 24px;
            border-bottom: 1px solid #f3f4f6;
            overflow-x: auto;
        }

        .tabs-scroll {
            display: flex;
            gap: 16px;
            padding-bottom: 8px;
        }

        .tabs-scroll::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            padding-bottom: 4px;
            color: #6b7280;
            border-bottom: 2px solid transparent;
            transition: color 0.2s;
        }

        .tab-btn:hover {
            color: #111827;
        }

        .tab-btn.active {
            color: #000;
            border-bottom-color: #000;
        }

        .products-grid {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .product-card {
            cursor: pointer;
            group: 'card';
        }

        .product-image {
            aspect-ratio: 3/4;
            background-color: #f9fafb;
            border-radius: 8px;
            margin-bottom: 8px;
            position: relative;
            overflow: hidden;
            border: 1px solid #f3f4f6;
            transition: border-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-card:hover .product-image {
            border-color: #d1d5db;
        }

        .add-icon {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: #fff;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            opacity: 0;
            transition: opacity 0.2s;
            color: #000;
        }

        .product-card:hover .add-icon {
            opacity: 1;
        }

        .product-title {
            font-size: 12px;
            font-weight: 500;
            color: #111827;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-price {
            font-size: 12px;
            color: #6b7280;
        }

        .empty-state {
            margin-top: 32px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 4px;
            border: 1px dashed #d1d5db;
            text-align: center;
        }

        .link-underline {
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 2px;
            font-weight: 600;
            color: #000;
        }

        /* --- Scrollbar Customization --- */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #f3f4f6;
            border-radius: 20px;
        }

        .custom-scroll:hover::-webkit-scrollbar-thumb {
            background-color: #e5e7eb;
        }

        /* --- Responsive Grid --- */
        @media (min-width: 768px) {
            .nav-links {
                display: flex;
            }
        }

        @media (min-width: 1024px) {
            main {
                grid-template-columns: 3fr 6fr 3fr;
                /* 25% 50% 25% approx */
            }
        }
    </style>


    <div class="tryon-page">
        <main>

            <!-- Left Column: Configuration -->
            <aside class="sidebar sidebar-left custom-scroll">
                <div>
                    <h2 class="text-sm font-medium text-gray-900 tracking-tight" style="margin-bottom: 4px;">Thông số cơ thể
                    </h2>
                    <p class="text-xs text-gray-500" style="margin-bottom: 24px;">Điều chỉnh để mô phỏng hình thể của bạn.
                    </p>

                    <!-- Height Slider -->
                    <div class="input-group">
                        <div class="label-row">
                            <label class="text-xs font-medium text-gray-600">Chiều cao</label>
                            <span class="text-xs value-display"><span id="height-val">170</span> cm</span>
                        </div>
                        <input type="range" id="height-input" min="150" max="200" value="170">
                    </div>

                    <!-- Weight Slider -->
                    <div class="input-group">
                        <div class="label-row">
                            <label class="text-xs font-medium text-gray-600">Cân nặng</label>
                            <span class="text-xs value-display"><span id="weight-val">65</span> kg</span>
                        </div>
                        <input type="range" id="weight-input" min="40" max="120" value="65">
                    </div>
                </div>

                <div class="section-divider">
                    <h2 class="text-sm font-medium text-gray-900 tracking-tight" style="margin-bottom: 16px;">Tông màu da
                    </h2>
                    <div class="skin-options">
                        <button class="skin-btn active" style="background-color: #F8E6D8;" data-color="#F8E6D8"></button>
                        <button class="skin-btn" style="background-color: #EBCBB9;" data-color="#EBCBB9"></button>
                        <button class="skin-btn" style="background-color: #C69C84;" data-color="#C69C84"></button>
                        <button class="skin-btn" style="background-color: #8D5524;" data-color="#8D5524"></button>
                        <button class="skin-btn" style="background-color: #3B2219;" data-color="#3B2219"></button>
                    </div>
                </div>

                <div class="section-divider">
                    <h2 class="text-sm font-medium text-gray-900 tracking-tight" style="margin-bottom: 16px;">Gợi ý AI</h2>
                    <div class="ai-box">
                        <i data-lucide="sparkles" class="mt-0.5" style="color: #ca8a04;" width="16" height="16"></i>
                        <div>
                            <p class="text-xs font-medium text-gray-900" style="margin-bottom: 4px;">Dựa trên dáng người</p>
                            <p class="text-xs text-gray-500" style="line-height: 1.6;">Với chiều cao 170cm và cân nặng 65kg,
                                chúng tôi đề xuất các bộ đồ Form Regular để tôn dáng tốt nhất.</p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Center Column: Model Preview -->
            <section class="stage">
                <!-- Decorative Grid -->
                <div class="grid-bg"></div>

                <div class="live-badge">
                    <span class="pulse-dot"></span>
                    <span class="text-xs font-medium text-gray-600">Chế độ xem trực tiếp</span>
                </div>

                <!-- The Model -->
                <div class="model-container">
                    <!-- Shadow -->
                    <div class="shadow-oval"></div>

                    <!-- SVG Body Silhouette -->
                    <svg id="model-silhouette" viewBox="0 0 200 600" preserveAspectRatio="xMidYMax">
                        <path id="body-fill"
                            d="M100,50 C120,50 135,65 135,90 C135,110 125,125 100,125 C75,125 65,110 65,90 C65,65 80,50 100,50 Z
                                                                                         M65,130 C40,135 20,150 20,190 L20,350 C20,365 30,370 35,360 L55,250 L55,400 L55,580 C55,595 70,595 75,580 L75,400 L85,400 L85,580 C85,595 100,595 105,580 L105,400 L125,400 L125,580 C125,595 140,595 145,580 L145,250 L165,360 C170,370 180,365 180,350 L180,190 C180,150 160,135 135,130 Z"
                            fill="#F8E6D8" stroke="rgba(0,0,0,0.05)" stroke-width="1" />
                    </svg>

                    <!-- Clothes Layers -->
                    <div id="worn-top" class="clothing-layer hidden" style="bottom: 45%; width: 140px;">
                        <svg viewBox="0 0 200 200" class="clothing-svg">
                            <path d="M60,20 L140,20 L170,70 L140,80 L130,50 L130,190 L70,190 L70,50 L60,80 L30,70 Z"
                                fill="#171717" />
                        </svg>
                    </div>

                    <div id="worn-bottom" class="clothing-layer hidden" style="bottom: 12%; width: 90px;">
                        <svg viewBox="0 0 100 200" class="clothing-svg">
                            <path d="M10,10 L90,10 L95,190 L55,190 L50,60 L45,190 L5,190 Z" fill="#3b82f6" />
                        </svg>
                    </div>
                </div>

                <!-- Controls Overlay -->
                <div class="controls-overlay">
                    <button class="btn-reset" onclick="resetModel()">
                        <i data-lucide="rotate-ccw" width="18" height="18" class="text-gray-600"></i>
                    </button>
                    <button class="btn-camera">
                        <i data-lucide="camera" width="16" height="16"></i> CHỤP ẢNH
                    </button>
                </div>
            </section>

            <!-- Right Column: Wardrobe -->
            <aside class="sidebar sidebar-right">
                <!-- Tabs -->
                <div class="tabs-header">
                    <div class="tabs-scroll">
                        <button class="tab-btn active">Tất cả</button>
                        <button class="tab-btn">Áo thun</button>
                        <button class="tab-btn">Áo sơ mi</button>
                        <button class="tab-btn">Quần dài</button>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="products-grid custom-scroll">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider" style="margin-bottom: 16px;">
                        Gợi ý cho bạn</h3>

                    <div class="grid-layout">
                        <!-- Item 1: Black Tee -->
                        <div class="product-card" onclick="toggleClothes('top', '#171717')">
                            <div class="product-image">
                                <div class="flex items-center justify-center h-full">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1" style="color: #1f2937;">
                                        <path
                                            d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z" />
                                    </svg>
                                </div>
                                <div class="add-icon">
                                    <i data-lucide="plus" width="14" height="14"></i>
                                </div>
                            </div>
                            <h4 class="product-title">Basic Tee - Black</h4>
                            <p class="product-price">299.000₫</p>
                        </div>

                        <!-- Item 2: Blue Jeans -->
                        <div class="product-card" onclick="toggleClothes('bottom', '#3b82f6')">
                            <div class="product-image">
                                <div class="flex items-center justify-center h-full">
                                    <i data-lucide="scissors" style="color: #3b82f6;" width="32" height="32"></i>
                                </div>
                                <div class="add-icon">
                                    <i data-lucide="plus" width="14" height="14"></i>
                                </div>
                            </div>
                            <h4 class="product-title">Slim Fit Jeans</h4>
                            <p class="product-price">550.000₫</p>
                        </div>

                        <!-- Item 3: White Shirt -->
                        <div class="product-card" onclick="toggleClothes('top', '#ffffff')">
                            <div class="product-image">
                                <div class="flex items-center justify-center h-full">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                        stroke="#d1d5db" stroke-width="1.5">
                                        <path
                                            d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z" />
                                    </svg>
                                </div>
                                <div class="add-icon">
                                    <i data-lucide="plus" width="14" height="14"></i>
                                </div>
                            </div>
                            <h4 class="product-title">Oxford Shirt</h4>
                            <p class="product-price">420.000₫</p>
                        </div>

                        <!-- Item 4: Khaki Pants -->
                        <div class="product-card" onclick="toggleClothes('bottom', '#A3907D')">
                            <div class="product-image">
                                <div class="flex items-center justify-center h-full">
                                    <i data-lucide="scissors" style="color: #b45309; opacity: 0.5;" width="32"
                                        height="32"></i>
                                </div>
                                <div class="add-icon">
                                    <i data-lucide="plus" width="14" height="14"></i>
                                </div>
                            </div>
                            <h4 class="product-title">Chino Beige</h4>
                            <p class="product-price">380.000₫</p>
                        </div>
                    </div>

                    <div class="empty-state">
                        <p class="text-xs text-gray-500" style="margin-bottom: 8px;">Không tìm thấy món đồ ưng ý?</p>
                        <button class="text-xs link-underline">Xem toàn bộ kho hàng</button>
                    </div>
                </div>
            </aside>
        </main>
    </div>
    <script>
        // Initialize Icons
        lucide.createIcons();

        // Elements
        const heightInput = document.getElementById('height-input');
        const heightVal = document.getElementById('height-val');
        const weightInput = document.getElementById('weight-input');
        const weightVal = document.getElementById('weight-val');
        const bodyFill = document.getElementById('body-fill');
        const modelSilhouette = document.getElementById('model-silhouette');
        const skinBtns = document.querySelectorAll('.skin-btn');
        const wornTop = document.getElementById('worn-top');
        const wornBottom = document.getElementById('worn-bottom');

        // State for worn items
        let currentState = {
            top: false,
            bottom: false
        };

        // Update Height & Weight visuals
        function updateModelShape() {
            const h = parseInt(heightInput.value);
            const w = parseInt(weightInput.value);

            heightVal.innerText = h;
            weightVal.innerText = w;

            // Algorithm to change scale
            const baseScaleX = 1;
            const heightFactor = (170 - h) * 0.005;
            const weightFactor = (w - 65) * 0.008;

            const newScaleX = baseScaleX + heightFactor + weightFactor;
            const clampedScale = Math.min(Math.max(newScaleX, 0.85), 1.3);

            // Apply transform to SVG
            modelSilhouette.style.transform = `scaleX(${clampedScale}) scaleY(${1 + (h-170)*0.002})`;
        }

        heightInput.addEventListener('input', updateModelShape);
        weightInput.addEventListener('input', updateModelShape);

        // Skin Tone Logic (Updated for non-Tailwind classes)
        skinBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all
                skinBtns.forEach(b => b.classList.remove('active'));
                // Add active class to current
                btn.classList.add('active');
                // Change SVG fill
                bodyFill.setAttribute('fill', btn.getAttribute('data-color'));
            });
        });

        // Toggle Clothes
        function toggleClothes(type, color) {
            const el = type === 'top' ? wornTop : wornBottom;
            const svgPath = el.querySelector('path');

            if (currentState[type]) {
                // Flash effect
                el.style.opacity = '0.5';
                setTimeout(() => el.style.opacity = '1', 150);

                svgPath.setAttribute('fill', color);
            } else {
                // Show it
                el.classList.remove('hidden');
                svgPath.setAttribute('fill', color);
                currentState[type] = true;
            }
        }

        function resetModel() {
            wornTop.classList.add('hidden');
            wornBottom.classList.add('hidden');
            currentState.top = false;
            currentState.bottom = false;
            heightInput.value = 170;
            weightInput.value = 65;
            updateModelShape();
            // Reset skin to first
            skinBtns[0].click();
        }

        // Init
        updateModelShape();
    </script>
@endsection

@section('page-script')
    <script src="https://unpkg.com/lucide@latest"></script>
@endsection
