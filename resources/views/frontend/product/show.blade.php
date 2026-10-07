@extends('frontend.master')
@section('title')
    {{ $product->product_name }}
@endsection
@php
    $reviewsCount = $product->reviews->count();
    $avgRating = $reviewsCount ? $product->reviews->avg('rating') : 0;
    $rating = round($avgRating);

    $listPrice = (float) $product->list_price;
    $discount = $product->discount;
    $discountedPrice = $listPrice;
    $percentOff = 0;
    $hasDiscount = false;

    if ($discount && $listPrice > 0) {
        $discountAmount = (float) $discount->discount_amount;
        $isFixed = (int) $discount->is_fixed;

        if ($isFixed === 0) {
            // giảm theo %
            $percentOff = min(100, round($discountAmount));
            $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
        } else {
            // giảm theo số tiền
            $discountedPrice = max(0, $listPrice - $discountAmount);
            $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
        }

        $hasDiscount = $discountedPrice < $listPrice;
    }
@endphp

@section('page-style')
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .luxury-desc {
            color: #555;
            line-height: 1.6;
            margin-bottom: 25px;
            width: 70%;
        }

        .luxury-title-product {
            color: #0a2540;
            /* fallback */
            background: linear-gradient(120deg,
                    #0a2540 0%,
                    #0f3c91 35%,
                    #1e6bff 55%,
                    #6aa7ff 100%);
            background-size: 200% 200%;
            animation: luxuryGradient 6s ease infinite;

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .luxury-discount {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 999;

            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;

            color: #fff;
            background: linear-gradient(135deg, #0f3c91, #1e6bff);
            border-radius: 999px;

            box-shadow: 0 10px 30px rgba(30, 107, 255, 0.35);
        }

        .old-price {
            color: #999;
            font-size: 0.85rem;
            position: relative;
        }

        .old-price::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            height: 1.5px;
            background: #999;
        }

        .luxury-price {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            font-size: 26px;
        }

        /* Ảnh full width hiện đại */
        .banner-img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            border-radius: 20px;
            transition: transform 6s ease;
        }

        .swiper-slide-active .banner-img {
            transform: scale(1.05);
            /* Zoom nhẹ */
        }

        /* Overlay gradient đẹp */
        .banner-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 40px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0));
            border-radius: 0 0 20px 20px;
            color: white;
        }

        .banner-overlay h2 {
            font-size: 2.2rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        /* Nút CTA gradient */
        .btn-gradient {
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #007bff, #00c6ff);
            transform: translateY(-2px);
        }

        /* Navigation buttons */
        .swiper-button-next,
        .swiper-button-prev {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: #333;
            transition: all 0.3s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: #fff;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 20px;
            font-weight: bold;
        }

        /* Hiệu ứng hover scale cho item */
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Animation cho button */
        .animate-btn {
            transition: all 0.3s ease;
        }

        .animate-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Hiệu ứng cho ảnh */
        .cart-img {
            transition: transform 0.4s ease;
        }

        .cart-item:hover .cart-img {
            transform: rotate(-3deg) scale(1.05);
        }

        /* Nút xóa sản phẩm */
        .btn-remove {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #dc3545;
            background: #fff;
            color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 14px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            /* Bắt buộc để ripple không tràn ra ngoài */
        }

        .btn-remove:hover {
            background: #dc3545;
            color: #fff;
            transform: rotate(90deg) scale(1.1);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        /* Hiệu ứng ripple */
        .btn-remove .ripple-effect {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            background: rgba(255, 255, 255, 0.6);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
    <div class="container my-5" style="margin-top: 20px">
        <div class="row g-4" style="margin-top: 20px">

            {{-- Breadcrumb --}}
            <div class="col-12" style="margin-top: 80px">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home.index') }}"
                                class="text-decoration-none text-muted">Trang chủ</a></li>
                        @if ($product->category?->parent?->parent)
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.byCategory', $product->category->parent->parent->id) }}"
                                    class="text-decoration-none text-muted">
                                    {{ $product->category->parent->parent->categories_text }}
                                </a>
                            </li>
                        @endif
                        @if ($product->category?->parent)
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.byCategory', $product->category->parent->id) }}"
                                    class="text-decoration-none text-muted">
                                    {{ $product->category->parent->categories_text }}
                                </a>
                            </li>
                        @endif
                        @if ($product->category)
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.byCategory', $product->category->id) }}"
                                    class="text-decoration-none text-muted">
                                    {{ $product->category->categories_text }}
                                </a>
                            </li>
                        @endif
                        @if ($product->supplier)
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.byCategory', $product->category->id) }}"
                                    class="text-decoration-none text-muted">
                                    {{ $product->supplier->supplier_text }}
                                </a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active text-truncate fw-semibold text-dark" aria-current="page"
                            style="max-width:300px;">
                            {{ $product->product_name }}
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Product Image Gallery --}}
            <div class="col-lg-6">
                <div class="product-gallery">
                    <div class="main-image-display position-relative mb-3 rounded-4 overflow-hidden shadow-sm">

                        <img id="mainProductImage"
                            src="{{ Str::startsWith($product->image, ['http://', 'https://'])
                                ? $product->image
                                : asset('storage/uploads/products/' . $product->image) }}"
                            alt="{{ $product->product_name }}"
                            style="height:260px;object-fit:cover;transition: transform .3s;">
                        @if ($hasDiscount && $percentOff > 0)
                            <span class="luxury-discount">
                                -{{ $percentOff }}%
                            </span>
                        @endif
                    </div>

                    {{-- Thumbnails --}}
                    <div class="d-flex gap-2 flex-wrap justify-content-center justify-content-lg-start product-thumbnails">

                        <img src="{{ Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : asset('storage/uploads/products/' . $product->image) }}"
                            alt="{{ $product->product_name }}" class="img-thumbnail thumb-image active">

                        <div class="d-flex gap-2 flex-wrap mt-3">
                            @foreach ($product->images as $img)
                                @if ($img->image)
                                    @php
                                        $imageUrl = Str::startsWith($img->image, ['http://', 'https://'])
                                            ? $img->image
                                            : asset('storage/uploads/products/' . $img->image);
                                    @endphp

                                    <img src="{{ $imageUrl }}" data-image="{{ $imageUrl }}"
                                        alt="{{ $product->product_name }}" class="img-thumbnail thumb-image"
                                        style="width:80px;height:80px;object-fit:cover;cursor:pointer">
                                @endif
                            @endforeach
                        </div>


                    </div>
                </div>
            </div>

            {{-- Product Details --}}
            <div class="col-lg-6 d-flex flex-column">
                <div class="product-info-wrapper">
                    <h1 class="fw-bold mb-2 text-dark luxury-title-product">{{ $product->product_name }}</h1>

                    <div class="d-flex align-items-baseline mb-3">
                        <span class="fs-3 fw-bold text-danger me-2 product-price"></span>
                        <span class="text-muted text-decoration-line-through small fst-italic original-price"
                            style="text-decoration-thickness: 2px; text-decoration-color: #6c757d; display:none;text-decoration: line-through;"></span>
                    </div>

                    <div class="mb-2 luxury-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star luxury-star"></i>
                        @endfor

                        <small class="rating-text">
                            @if ($avgRating > 0)
                                ({{ number_format($avgRating, 1) }}/5)
                            @else
                                (Chưa có đánh giá)
                            @endif
                        </small>
                    </div>

                    <hr class="my-4">

                    <p class="luxury-desc text-gray-600 leading-relaxed line-clamp-3">

                        {{ $product->short_description }}
                    </p>
                    <div class="luxury-product">
                        <p class="card-product__price mb-0 luxury-price">
                            <span class="fs-5 fw-bold text-danger">
                                {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                            </span>

                            @if ($hasDiscount)
                                <span class=" old-price text-muted ms-2 text-decoration-line-through small fst-italic">
                                    {{ number_format($listPrice, 0, ',', '.') }} ₫
                                </span>
                            @endif
                        </p>
                    </div>

                    @php
                        $hasColor = $product->variants->whereNotNull('color')->where('color', '!=', '')->count() > 0;

                        $hasSize = $product->variants->whereNotNull('size')->where('size', '!=', '')->count() > 0;

                        $colors = $hasColor ? $product->variants->groupBy('color') : collect();
                    @endphp
                    @if ($product->variants->count())

                        {{-- ===== CHỌN MÀU ===== --}}
                        @if ($hasColor)
                            <div class="mb-4">
                                <label class="fw-semibold d-block mb-2">Màu sắc</label>

                                <div class="d-flex gap-3 flex-wrap">
                                    @foreach ($colors as $color => $items)
                                        @php $firstVariant = $items->first(); @endphp

                                        <div class="color-option selectable" data-color="{{ $color }}"
                                            data-image="{{ $firstVariant->image }}"
                                            data-variant-id="{{ $firstVariant->id }}"
                                            data-price="{{ $firstVariant->price }}" role="button">

                                            <img src="{{ $firstVariant->image }}" class="rounded border variant-thumb"
                                                style="width:164px;height:164px;object-fit:cover;cursor:pointer">

                                            <div class="small mt-1 text-center">{{ $color }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        {{-- ===== CHỌN SIZE ===== --}}
                        @if ($hasSize)
                            <div class="mb-4">
                                <label class="fw-semibold d-block mb-2">Size</label>

                                <div class="size-grid" id="sizeGrid">
                                    @foreach ($product->variants as $variant)
                                        <button type="button" class="size-option selectable" data-id="{{ $variant->id }}"
                                            data-color="{{ $variant->color }}" data-price="{{ $variant->price }}"
                                            @disabled($variant->stock_quantity <= 0)
                                            style="{{ $hasColor ? 'display:none' : 'display:inline-flex' }}">
                                            {{ $variant->size }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <input type="hidden" name="variant_id" id="selectedVariantId">

                    @endif
                    {{-- Quantity Control --}}
                    <div class="mb-4">
                        <label for="quantityInput" class="form-label fw-semibold text-dark">Số lượng:</label>
                        <div class="input-group quantity-control" style="width: 150px;">
                            <button class="btn btn-outline-secondary border-end-0" type="button" id="minusBtn">-</button>
                            <input type="text" class="form-control text-center border-start-0 border-end-0"
                                value="1" id="quantityInput" aria-label="Số lượng" readonly>
                            <button class="btn btn-outline-secondary border-start-0" type="button"
                                id="plusBtn">+</button>
                        </div>
                    </div>
                </div>
                {{-- 360° Product Viewer --}}
                @php
                    $model3dPath = public_path("models/products/{$product->id}/product.glb");
                    $has3dModel = file_exists($model3dPath) && filesize($model3dPath) > 0;
                @endphp

                @if ($has3dModel)
                    <button type="button" class="btn btn-outline-dark btn-lg w-100 mt-3 py-3" id="open360ViewerBtn"
                        data-model-url="{{ asset("models/products/{$product->id}/product.glb") }}">
                        <i class="fas fa-cube me-2"></i>
                        Xem sản phẩm 360°
                    </button>
                @endif


                {{-- Add to Cart Button --}}
                <button type="button" class="btn btn-primary btn-lg w-100 mt-auto py-3" data-id="{{ $product->id }}"
                    id="addToCartBtn">
                    <i class="fas fa-cart-plus me-2"></i> Thêm vào giỏ hàng
                </button>

            </div>

            <script type="importmap">
{
    "imports": {
        "three": "https://cdn.jsdelivr.net/npm/three@0.180.0/build/three.module.js",
        "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.180.0/examples/jsm/"
    }
}
</script>

            <script type="module">
                import * as THREE from 'three';
                import {
                    OrbitControls
                } from 'three/addons/controls/OrbitControls.js';

                import {
                    GLTFLoader
                } from 'three/addons/loaders/GLTFLoader.js';


                const button = document.getElementById('open360ViewerBtn');

                if (button) {

                    const modelUrl = button.dataset.modelUrl;

                    const modalElement =
                        document.getElementById('product360Modal');

                    const viewer =
                        document.getElementById('product360Viewer');

                    const loading =
                        document.getElementById('product360Loading');

                    const autoRotateBtn =
                        document.getElementById('toggleAutoRotate');


                    const modal =
                        new bootstrap.Modal(modalElement);


                    let scene;
                    let camera;
                    let renderer;
                    let controls;
                    let model;

                    let initialized = false;

                    let autoRotate = true;


                    /* =====================================================
                       OPEN MODAL
                    ===================================================== */

                    button.addEventListener('click', function() {

                        modal.show();

                        setTimeout(() => {

                            initViewer();

                            resizeViewer();

                        }, 300);

                    });


                    /* =====================================================
                       INIT THREE.JS
                    ===================================================== */

                    function initViewer() {

                        if (initialized) {
                            return;
                        }

                        initialized = true;


                        /* ===============================
                           SCENE
                        =============================== */

                        scene = new THREE.Scene();

                        scene.background =
                            new THREE.Color(0xf5f5f5);


                        /* ===============================
                           CAMERA
                        =============================== */

                        camera =
                            new THREE.PerspectiveCamera(
                                40,
                                viewer.clientWidth /
                                viewer.clientHeight,
                                0.01,
                                1000
                            );


                        camera.position.set(
                            0,
                            0.4,
                            4
                        );


                        /* ===============================
                           RENDERER
                        =============================== */

                        renderer =
                            new THREE.WebGLRenderer({
                                antialias: true,
                                alpha: true
                            });


                        renderer.setPixelRatio(
                            Math.min(
                                window.devicePixelRatio,
                                2
                            )
                        );


                        renderer.setSize(
                            viewer.clientWidth,
                            viewer.clientHeight
                        );


                        renderer.outputColorSpace =
                            THREE.SRGBColorSpace;


                        renderer.toneMapping =
                            THREE.ACESFilmicToneMapping;


                        renderer.toneMappingExposure =
                            1.2;


                        renderer.shadowMap.enabled = true;


                        /* Quan trọng */
                        renderer.domElement.style.width = '100%';
                        renderer.domElement.style.height = '100%';
                        renderer.domElement.style.display = 'block';
                        renderer.domElement.style.cursor = 'grab';
                        renderer.domElement.style.touchAction = 'none';


                        viewer.appendChild(
                            renderer.domElement
                        );


                        /* ===============================
                           LIGHT
                        =============================== */

                        const ambientLight =
                            new THREE.HemisphereLight(
                                0xffffff,
                                0x444444,
                                2.5
                            );

                        scene.add(ambientLight);


                        const keyLight =
                            new THREE.DirectionalLight(
                                0xffffff,
                                3
                            );

                        keyLight.position.set(
                            4,
                            6,
                            5
                        );

                        keyLight.castShadow = true;

                        scene.add(keyLight);


                        const fillLight =
                            new THREE.DirectionalLight(
                                0xffffff,
                                2
                            );

                        fillLight.position.set(
                            -4,
                            3,
                            3
                        );

                        scene.add(fillLight);


                        const backLight =
                            new THREE.DirectionalLight(
                                0xffffff,
                                1.5
                            );

                        backLight.position.set(
                            0,
                            3,
                            -5
                        );

                        scene.add(backLight);


                        /* ===============================
                           ORBIT CONTROLS
                        =============================== */

                        controls =
                            new OrbitControls(
                                camera,
                                renderer.domElement
                            );


                        /*
                         * XOAY
                         */
                        controls.enableRotate = true;


                        /*
                         * ZOOM
                         */
                        controls.enableZoom = true;


                        /*
                         * PAN
                         */
                        controls.enablePan = false;


                        /*
                         * Mượt
                         */
                        controls.enableDamping = true;

                        controls.dampingFactor = 0.08;


                        /*
                         * Zoom giới hạn
                         */
                        controls.minDistance = 1.2;

                        controls.maxDistance = 8;


                        /*
                         * Auto rotate
                         */
                        controls.autoRotate =
                            autoRotate;

                        controls.autoRotateSpeed =
                            1.5;


                        /*
                         * Giới hạn góc dọc
                         *
                         * Cho phép nhìn từ trên xuống
                         * nhưng không lộn ngược model
                         */
                        controls.minPolarAngle =
                            0.15;

                        controls.maxPolarAngle =
                            Math.PI - 0.15;


                        /*
                         * Tâm xoay
                         */
                        controls.target.set(
                            0,
                            0,
                            0
                        );


                        controls.update();


                        /* =================================================
                           USER DRAG
                        ================================================= */

                        renderer.domElement.addEventListener(
                            'pointerdown',
                            function() {

                                renderer.domElement.style.cursor =
                                    'grabbing';

                                /*
                                 * Người dùng bắt đầu kéo
                                 * thì dừng auto rotate
                                 */
                                controls.autoRotate = false;

                                autoRotate = false;

                                autoRotateBtn.innerHTML =
                                    '🔄 Xoay tự động';
                            }
                        );


                        renderer.domElement.addEventListener(
                            'pointerup',
                            function() {

                                renderer.domElement.style.cursor =
                                    'grab';
                            }
                        );


                        renderer.domElement.addEventListener(
                            'pointerleave',
                            function() {

                                renderer.domElement.style.cursor =
                                    'grab';
                            }
                        );


                        /* =================================================
                           LOAD GLB
                        ================================================= */

                        const loader =
                            new GLTFLoader();


                        loader.load(

                            modelUrl,

                            function(gltf) {

                                model = gltf.scene;


                                /* ===============================
                                   ENABLE SHADOW
                                =============================== */

                                model.traverse(
                                    function(child) {

                                        if (
                                            child.isMesh
                                        ) {

                                            child.castShadow = true;

                                            child.receiveShadow = true;


                                            if (
                                                child.material
                                            ) {

                                                child.material.needsUpdate =
                                                    true;
                                            }
                                        }

                                    }
                                );


                                /* ===============================
                                   BOUNDING BOX
                                =============================== */

                                const box =
                                    new THREE.Box3()
                                    .setFromObject(model);


                                const size =
                                    box.getSize(
                                        new THREE.Vector3()
                                    );


                                const center =
                                    box.getCenter(
                                        new THREE.Vector3()
                                    );


                                /* ===============================
                                   CENTER MODEL
                                =============================== */

                                model.position.sub(
                                    center
                                );


                                /* ===============================
                                   SCALE
                                =============================== */

                                const maxSize =
                                    Math.max(
                                        size.x,
                                        size.y,
                                        size.z
                                    );


                                const targetSize = 3;


                                const scale =
                                    targetSize /
                                    maxSize;


                                model.scale.setScalar(
                                    scale
                                );


                                scene.add(model);


                                /* ===============================
                                   CAMERA TARGET
                                =============================== */

                                controls.target.set(
                                    0,
                                    0,
                                    0
                                );


                                controls.update();


                                /* ===============================
                                   HIDE LOADING
                                =============================== */

                                loading.style.display =
                                    'none';


                                console.log(
                                    '3D Model loaded:',
                                    modelUrl
                                );

                            },

                            function(xhr) {

                                if (xhr.total) {

                                    const percent =
                                        (xhr.loaded /
                                            xhr.total) *
                                        100;

                                    console.log(
                                        `Loading: ${percent.toFixed(0)}%`
                                    );
                                }

                            },

                            function(error) {

                                console.error(
                                    'Không thể tải model 3D:',
                                    error
                                );


                                loading.innerHTML = `
                        <div class="text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Không thể tải mô hình 3D.
                        </div>
                    `;
                            }

                        );


                        /* ===============================
                           START ANIMATION
                        =============================== */

                        animate();

                    }


                    /* =====================================================
                       ANIMATION
                    ===================================================== */

                    function animate() {

                        requestAnimationFrame(
                            animate
                        );


                        if (controls) {

                            controls.update();

                        }


                        if (renderer && scene && camera) {

                            renderer.render(
                                scene,
                                camera
                            );

                        }

                    }


                    /* =====================================================
                       AUTO ROTATE BUTTON
                    ===================================================== */

                    autoRotateBtn.addEventListener(
                        'click',
                        function() {

                            autoRotate = !autoRotate;


                            if (controls) {

                                controls.autoRotate =
                                    autoRotate;

                            }


                            this.innerHTML =
                                autoRotate ?
                                '⏸ Dừng xoay' :
                                '🔄 Xoay tự động';

                        }
                    );


                    /* =====================================================
                       RESIZE
                    ===================================================== */

                    function resizeViewer() {

                        if (
                            !renderer ||
                            !camera
                        ) {
                            return;
                        }


                        const width =
                            viewer.clientWidth;

                        const height =
                            viewer.clientHeight;


                        if (
                            width === 0 ||
                            height === 0
                        ) {
                            return;
                        }


                        camera.aspect =
                            width / height;


                        camera.updateProjectionMatrix();


                        renderer.setSize(
                            width,
                            height
                        );

                    }


                    window.addEventListener(
                        'resize',
                        resizeViewer
                    );


                    modalElement.addEventListener(
                        'shown.bs.modal',
                        function() {

                            setTimeout(
                                resizeViewer,
                                100
                            );

                        }
                    );

                }
            </script>

            <style>
                /*
                     * 360 PRODUCT VIEWER
                     * Luôn nằm trên navbar/header
                     */

                #product360Modal {
                    z-index: 3000 !important;
                }

                .modal-backdrop {
                    z-index: 2990 !important;
                }


                /*
                     * MODAL RỘNG GẦN FULL MÀN HÌNH
                     */

                .modal-3d-wide {
                    width: 92vw;
                    max-width: 92vw;
                    margin: 1.5rem auto;
                }

                .modal-3d-wide .modal-content {
                    width: 100%;
                    border-radius: 12px;
                    overflow: hidden;
                }


                /*
                     * KHUNG HIỂN THỊ 3D
                     */

                #product360Viewer {
                    width: 100%;
                    height: 85vh !important;
                    min-height: 600px;
                    max-height: 850px;

                    background: #f5f5f5;

                    overflow: hidden;

                    user-select: none;
                    -webkit-user-select: none;
                }


                /*
                     * THREE.JS CANVAS
                     */

                #product360Viewer canvas {
                    display: block;

                    width: 100% !important;
                    height: 100% !important;

                    touch-action: none !important;

                    cursor: grab;
                }


                #product360Viewer canvas:active {
                    cursor: grabbing !important;
                }


                /*
                     * MOBILE
                     */

                @media (max-width: 768px) {

                    .modal-3d-wide {
                        width: 96vw;
                        max-width: 96vw;
                        margin: 0.75rem auto;
                    }

                    #product360Viewer {
                        height: 70vh !important;
                        min-height: 450px;
                        max-height: none;
                    }
                }
            </style>



            {{-- Product Tabs (Description & Reviews) --}}
            <div class="col-12 mt-5">
                <ul class="nav nav-tabs nav-fill flex-column flex-sm-row mb-4" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-uppercase" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button" role="tab" aria-controls="description"
                            aria-selected="true">Mô tả chi tiết</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-uppercase" id="reviews-tab" data-bs-toggle="tab"
                            data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews"
                            aria-selected="false">Đánh giá ({{ $reviewsCount }})</button>
                    </li>
                </ul>
                <div class="tab-content border-top pt-4" id="productTabsContent">
                    <ul class="list-group list-group-flush">
                        @foreach (preg_split("/\r\n|\n|\r/", $product->description) as $item)
                            @php
                                [$label, $value] = array_pad(explode(':', $item, 2), 2, null);
                            @endphp

                            <div class="row py-1">
                                <div class="col-4 fw-semibold">{{ $label }}</div>
                                <div class="col-8">{{ $value }}</div>
                            </div>
                        @endforeach

                    </ul>





                    {{-- Reviews Tab --}}
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="reviews-list">
                            @forelse($product->reviews as $index => $review)
                                <div
                                    class="card mb-3 shadow-sm border-0 review-card
        {{ $index >= 2 ? 'd-none extra-review' : '' }}">

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="card-title mb-0 fw-bold text-dark">
                                                {{ $review->user->name ?? 'Khách' }}
                                            </h6>
                                            <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                                        </div>

                                        <div class="text-warning mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>

                                        <p class="card-text text-secondary">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info text-center py-4" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> Chưa có đánh giá nào cho sản phẩm này. Hãy là
                                    người đầu tiên!
                                </div>
                            @endforelse
                            @if ($product->reviews->count() > 2)
                                <div class="text-center mt-3">
                                    <button class="btn btn-outline-primary px-4" id="toggleReviewsBtn">
                                        Xem thêm đánh giá
                                    </button>
                                </div>
                            @endif

                        </div>
                        {{-- Review Form --}}
                        @if (Auth::check() && $hasOrdered)
                            <div class="mt-5 p-4 border rounded-3 bg-light">
                                <h5 class="mb-3 text-dark fw-bold">Viết đánh giá của bạn</h5>

                                <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Xếp hạng:</label>
                                        <div class="d-flex gap-1 rating-stars-interactive" id="ratingStars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="far fa-star text-warning fa-lg"
                                                    data-rating="{{ $i }}"></i>
                                            @endfor
                                            <input type="hidden" name="rating" id="selectedRating" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Bình luận:</label>
                                        <textarea class="form-control" name="comment" rows="5" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."
                                            required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg mt-3">
                                        Gửi đánh giá
                                    </button>
                                </form>
                            </div>
                        @elseif(Auth::guard('customer')->check())
                            {{-- Đã đăng nhập nhưng CHƯA mua --}}
                            <div class="alert alert-warning text-center mt-4">
                                <i class="fas fa-lock me-2"></i>
                                Bạn cần mua sản phẩm này để có thể viết đánh giá.
                            </div>
                        @else
                            {{-- Chưa đăng nhập --}}
                            <div class="alert alert-info text-center mt-4">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Vui lòng <a href="{{ route('frontend.login.index') }}" class="fw-bold">đăng nhập</a> để
                                đánh giá sản
                                phẩm.
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            {{-- Sản phẩm liên quan --}}
            @if ($relatedProducts->count())
                @include('frontend.includes.ProductSection', [
                    'title' => 'SẢN PHẨM LIÊN QUAN',
                    'screen' => $relatedProducts,
                ])
            @endif

        </div>
    </div>
    @include('frontend/includes/ChatBot')
    <style>
        /* ===== SIZE GRID (Luxury spacing) ===== */
        .size-grid {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ===== SIZE OPTION – LUXURY BLUE ===== */
        .size-option {
            min-width: 56px;
            height: 44px;
            padding: 0 16px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;
            border: 1.5px solid #c7d2fe;

            background: linear-gradient(180deg, #ffffff, #f8fafc);
            color: #1e3a8a;

            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.6px;

            cursor: pointer;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== HOVER – LUXURY FEEL ===== */
        .size-option:hover:not(:disabled) {
            border-color: #2563eb;
            color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.18);
        }

        /* ===== ACTIVE – CHỌN SIZE ===== */
        .size-option.active {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: #ffffff;
            border-color: #1e3a8a;

            box-shadow:
                0 10px 25px rgba(37, 99, 235, 0.35),
                inset 0 0 0 1px rgba(255, 255, 255, 0.15);
        }

        /* ===== ACTIVE HOVER ===== */
        .size-option.active:hover {
            transform: none;
        }

        /* ===== DISABLED – HẾT HÀNG ===== */
        .size-option:disabled {
            background: #f1f5f9;
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
            box-shadow: none;
            position: relative;
        }

        /* Gạch chéo tinh tế */
        .size-option:disabled::after {
            content: "";
            position: absolute;
            width: 110%;
            height: 1.5px;
            background: #cbd5e1;
            transform: rotate(-18deg);
        }
    </style>
    {{-- Dynamic CSS (can be moved to a separate file) --}}
    <style>
        .luxury-star {
            color: #0f3c91;
            text-shadow: 0 1px 2px rgba(15, 60, 145, 0.25);
        }

        :root {
            --bs-primary: #0f3c91;
            /* Example primary color */
            --bs-secondary: #6c757d;
            --bs-danger: #dc3545;
            --bs-warning: #0f3c91;
            --bs-light: #f8f9fa;
            --bs-dark: #212529;
        }

        /* General improvements */
        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--bs-dark);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: var(--bs-dark);
        }

        .container {
            max-width: 1300px;
            /* Wider container for a more spacious feel */
        }

        /* Breadcrumb styling */
        .breadcrumb-item a {
            color: var(--bs-secondary) !important;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--bs-primary) !important;
        }

        .breadcrumb-item.active {
            color: var(--bs-dark) !important;
        }

        /* Product Gallery */
        .main-image-display {
            height: 500px;
            /* Consistent height for main image */
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f2f5;
            /* Light background for images with transparency */
            border: 1px solid #e9ecef;
        }

        .main-image-display img {
            transition: transform 0.3s ease-in-out;
        }

        .thumb-image {
            width: 90px;
            height: 90px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #e9ecef;
            /* Lighter default border */
            border-radius: 8px;
            /* Slightly more rounded thumbnails */
            transition: all 0.2s ease-in-out;
            padding: 2px;
            /* Small padding inside border */
        }

        .thumb-image.active,
        .thumb-image:hover {
            border-color: var(--bs-primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            /* More subtle shadow */
            transform: scale(1.03);
            /* Slight zoom on hover/active */
        }

        /* Product Info */
        .product-info-wrapper {
            padding: 1rem 0;
        }

        .product-price {
            font-size: 2.5rem !important;
            /* Even larger price */
            letter-spacing: -0.5px;
            /* Tighter letter spacing */
        }

        .discounted-price {
            font-size: 1.1rem;
            /* Slightly larger strikethrough price */
        }

        .reviews-link {
            font-weight: 500;
            color: var(--bs-dark) !important;
        }

        .reviews-link:hover {
            color: var(--bs-primary) !important;
            text-decoration: underline !important;
        }

        .quantity-control .btn {
            border-radius: 0.25rem;
            /* Standard Bootstrap border-radius */
        }

        .quantity-control .form-control {
            border-radius: 0;
            /* Remove border radius for input in group */
        }

        /* Add to cart button */
        .add-to-cart-btn {
            border-radius: 0.75rem;
            /* More rounded button */
            font-size: 1.25rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
            /* Darker primary on hover */
            border-color: #0056b3;
            transform: translateY(-2px);
            /* Slight lift */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Tabs Styling */
        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
            /* Thicker, lighter bottom border */
        }

        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            /* Highlight active tab with thicker border */
            color: var(--bs-secondary);
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: var(--bs-primary);
            border-color: #ced4da;
            /* Subtle hover border */
        }

        .nav-tabs .nav-link.active {
            color: var(--bs-primary);
            border-color: var(--bs-primary);
            /* Active tab highlight */
            background-color: transparent;
        }

        .tab-content {
            background-color: #fff;
            padding: 1.5rem 0;
        }

        .product-description-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .product-description-content p {
            margin-bottom: 1rem;
        }

        /* Review Cards */
        .review-card {
            border-radius: 0.75rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .review-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        /* Review Form */
        #reviewForm .form-control:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        .rating-stars-interactive i {
            cursor: pointer;
            transition: color 0.15s ease, transform 0.15s ease;
        }

        .rating-stars-interactive i:hover {
            transform: scale(1.1);
        }

        .rating-stars-interactive i.fas {
            color: var(--bs-warning);
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .main-image-display {
                height: 350px;
            }

            .thumb-image {
                width: 70px;
                height: 70px;
            }

            .product-price {
                font-size: 2rem !important;
            }

            .add-to-cart-btn {
                font-size: 1.1rem;
                padding-top: 0.8rem;
                padding-bottom: 0.8rem;
            }

            .nav-tabs .nav-link {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .main-image-display {
                height: 300px;
            }

            .thumb-image {
                width: 60px;
                height: 60px;
            }

            .product-price {
                font-size: 1.8rem !important;
            }

            .nav-tabs.flex-column {
                flex-direction: row !important;
                /* Keep tabs horizontal on smaller screens too */
            }

            .nav-tabs .nav-item {
                flex: 1 1 auto;
                /* Distribute items evenly */
                text-align: center;
            }
        }
    </style>


    <script>
        const hasColor = @json($hasColor);
        const hasSize = @json($hasSize);

        let selectedVariantId = null;

        /* ================= CHỌN MÀU ================= */
        document.querySelectorAll('.color-option').forEach(colorEl => {
            colorEl.addEventListener('click', () => {
                const color = colorEl.dataset.color;
                const image = colorEl.dataset.image;
                const variantId = colorEl.dataset.variantId;
                const price = colorEl.dataset.price;

                document.querySelectorAll('.color-option').forEach(c => c.classList.remove('active'));
                colorEl.classList.add('active');

                const mainImg = document.getElementById('mainProductImage');
                if (mainImg && image) mainImg.src = image;

                // 👉 KHÔNG CÓ SIZE
                if (!hasSize) {
                    selectedVariantId = variantId;
                    document.getElementById('selectedVariantId').value = variantId;
                    updatePrice(price);
                    return;
                }

                // 👉 CÓ SIZE → FILTER SIZE
                selectedVariantId = null;
                document.getElementById('selectedVariantId').value = '';

                document.querySelectorAll('.size-option').forEach(btn => {
                    btn.style.display = btn.dataset.color === color ? 'inline-flex' : 'none';
                    btn.classList.remove('active');
                });
            });
        });

        /* ================= CHỌN SIZE ================= */
        document.querySelectorAll('.size-option').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.size-option').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                selectedVariantId = btn.dataset.id;
                document.getElementById('selectedVariantId').value = selectedVariantId;

                updatePrice(btn.dataset.price);
                console.log('Selected variant:', selectedVariantId);
            });
        });

        function updatePrice(price) {
            const priceBox = document.getElementById('productPrice');
            if (priceBox) {
                priceBox.innerText =
                    new Intl.NumberFormat('vi-VN').format(price) + 'đ';
            }
        }

        if (!window.cartEventBound) {
            window.cartEventBound = true;

            const addBtn = document.getElementById('addToCartBtn');
            let isAddingToCart = false;

            addBtn.addEventListener('click', () => {
                if (isAddingToCart) return;
                isAddingToCart = true;

                const productId = addBtn.dataset.id;
                const quantity = document.getElementById('quantityInput').value;

                if ((hasColor || hasSize) && !selectedVariantId) {
                    alert('Vui lòng chọn đầy đủ phiên bản sản phẩm');
                    isAddingToCart = false;
                    return;
                }

                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append('quantity', quantity);
                if (selectedVariantId) {
                    formData.append('variant_id', selectedVariantId);
                }

                fetch("{{ route('cart.add') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const cartCountEl = document.querySelector('.cart-count');
                            if (cartCountEl) {
                                cartCountEl.textContent = data.cart_count;
                                cartCountEl.style.display = data.cart_count > 0 ?
                                    'inline-flex' :
                                    'none';
                            }
                            Toastify({
                                text: "Thêm sản phẩm thành công",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#28a745",
                            }).showToast();
                        } else {
                            alert(data.message || 'Có lỗi xảy ra');
                        }
                    })
                    .finally(() => {
                        isAddingToCart = false;
                    });
            });
        }
    </script>





    <script>
        const mainImage = document.getElementById('mainProductImage');

        /* CLICK ẢNH MÀU (VARIANT) */
        document.querySelectorAll('.color-option img').forEach(img => {
            img.addEventListener('click', () => {
                const image = img.closest('.color-option').dataset.image;
                if (mainImage && image) {
                    mainImage.src = image;
                }

                // active UI
                document.querySelectorAll('.variant-thumb').forEach(i => i.classList.remove('active'));
                img.classList.add('active');
            });
        });

        /* CLICK ẢNH PHỤ (GALLERY) */
        document.querySelectorAll('.thumb-image').forEach(thumb => {
            thumb.addEventListener('click', () => {
                const image = thumb.dataset.image || thumb.src;
                if (mainImage && image) {
                    mainImage.src = image;
                }

                document.querySelectorAll('.thumb-image').forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
            });
        });
    </script>








@endsection
<script>
    const toggleBtn = document.getElementById('toggleReviewsBtn');

    if (toggleBtn) {
        let expanded = false;

        toggleBtn.addEventListener('click', () => {
            document.querySelectorAll('.extra-review').forEach(el => {
                el.classList.toggle('d-none');
            });

            expanded = !expanded;
            toggleBtn.innerText = expanded ?
                'Thu gọn đánh giá' :
                'Xem thêm đánh giá';
        });
    }
</script>

<style>
    #floating-buttons {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        z-index: 9999;
    }

    #floating-buttons .btn {
        width: 55px;
        height: 55px;
        font-size: 1.4rem;
        padding: 0;
        transition: all 0.3s ease-in-out;
    }

    /* Nút con ẩn mặc định */
    .contact-item {
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
        margin-bottom: 8px;
    }

    /* Khi hover vào contact-menu thì hiện nút con */
    .contact-menu:hover .contact-item {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    #floating-buttons .btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    #back-to-top {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
    }

    /* Khi active thì hiện ra */
    #back-to-top.show {
        opacity: 1;
        visibility: visible;
    }

    /* Nút con ẩn mặc định */
    .contact-item {
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
        margin-bottom: 8px;
    }

    /* Khi active thì hiện nút con */
    .contact-menu.active .contact-item {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .logo-slider-wrapper {
        position: relative;
        overflow: hidden;
    }

    .logo-slider {
        display: flex;
        gap: 60px;
        animation: scroll-left 25s linear infinite;
    }

    .logo-item img {
        height: 60px;
        width: auto;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .logo-item img:hover {
        filter: grayscale(0%);
        opacity: 1;
        transform: scale(1.1);
    }

    /* Hiệu ứng fade 2 bên */
    .logo-slider-wrapper::before,
    .logo-slider-wrapper::after {
        content: "";
        position: absolute;
        top: 0;
        width: 80px;
        height: 100%;
        z-index: 2;
        pointer-events: none;
    }

    .logo-slider-wrapper::before {
        left: 0;
        background: linear-gradient(to right, #fff, transparent);
    }

    .logo-slider-wrapper::after {
        right: 0;
        background: linear-gradient(to left, #fff, transparent);
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .card-product__img:hover img {
        transform: scale(1.05);
    }

    .card-product__imgOverlay button {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-product__imgOverlay button:hover {
        transform: scale(1.2);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .card-product__imgOverlay {
        opacity: 0;
        transition: all 0.3s ease;
    }

    .card-product__img:hover .card-product__imgOverlay {
        opacity: 1;
    }

    .card-product__imgOverlay button {
        width: 40px;
        height: 40px;
    }

    /* Overlay ẩn mặc định */
    .hero-carousel__slideOverlay {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
    }

    /* Khi active (slide đang hiển thị) thì hiện */
    .hero-carousel__slide.active .hero-carousel__slideOverlay {
        opacity: 1;
        transform: translateY(0);
    }

    /* Khung ảnh đồng bộ */
    .hero-image-wrapper {
        position: relative;
        width: 100%;
        height: 450px;
        /* Chiều cao cố định cho đồng đều */
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .hero-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Giữ tỷ lệ, lấp đầy khung */
        transition: transform 0.4s ease;
    }

    .hero-image-wrapper img:hover {
        transform: scale(1.08);
        /* zoom nhẹ khi hover */
    }

    /* Overlay mờ */
    .hero-carousel__slideOverlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 40%, rgba(0, 0, 0, 0.6) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        padding: 20px;
        text-align: center;
        color: #fff;
        opacity: 1;
        transition: background 0.3s ease;
    }

    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        position: relative;
        opacity: 0 !important;
        transition: opacity 1s;
    }

    .swiper-slide-active {
        opacity: 1 !important;
    }

    .hero-carousel__slideOverlay:hover {
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.2) 30%, rgba(0, 0, 0, 0.75) 100%);
    }

    .hero-carousel__slideOverlay h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .hero-carousel__slideOverlay p {
        font-size: 16px;
        opacity: 0.9;
    }

    .product-info {
        animation: fadeInLeft 1s ease;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .carousel-layout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
    }

    .product-info {
        width: 300px;
        padding: 20px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .product-info h2 {
        font-size: 22px;
        margin-bottom: 12px;
        color: #222;
    }

    .product-info p {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
    }

    .btn-buy {
        display: inline-block;
        padding: 10px 20px;
        background: #0072bc;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-buy:hover {
        background: #005b9f;
    }

    /* Vùng chứa toàn bộ carousel */
    .carousel-container {
        margin: auto;
        width: 100%;
        max-width: 1000px;
        height: 700px;
        position: relative;
        perspective: 2200px;
        overflow: hidden;
        user-select: none;
        overflow: visible;
        /* không cho bôi đen */
    }

    /* Carousel xoay */
    .carousel {
        width: 100%;
        height: 100%;
        position: absolute;
        transform-style: preserve-3d;
        transition: transform 1s ease-in-out;
        user-select: none;
    }

    /* Item sản phẩm */
    .item {
        position: absolute;
        width: 400px;
        height: 450px;
        left: 50%;
        top: 50%;
        transform-style: preserve-3d;
        transform-origin: center;
        margin: -225px 0 0 -200px;
        text-align: center;
        user-select: none;
    }

    .item img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        transition: transform 0.3s ease;
        pointer-events: none;
        /* fix click không chọn ảnh */
    }

    .item img:hover {
        transform: scale(1.05);
    }

    .item p {
        margin-top: 12px;
        background: rgba(0, 0, 0, 0.65);
        color: #fff;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 500;
        user-select: none;
        /* không cho bôi đen chữ */
    }
</style>

@section('user.js')
    <div class="modal fade" id="product360Modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-3d-wide modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold">
                            🪞 Xem sản phẩm 360°
                        </h5>
                        <small class="text-muted">
                            Kéo chuột để xoay sản phẩm
                        </small>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body p-0">
                    <div id="product360Viewer"
                        style="
                        width:100%;
                        height:650px;
                        background:#f5f5f5;
                        position:relative;
                    ">
                        <div id="product360Loading"
                            class="position-absolute top-50 start-50 translate-middle text-center">
                            <div class="spinner-border"></div>
                            <div class="mt-2">
                                Đang tải mô hình 3D...
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" id="toggleAutoRotate">
                        🔄 Xoay tự động
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Đóng
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
