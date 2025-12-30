@extends('frontend.master')
@section('title')
    Giỏ hàng của bạn
@endsection


@section('page-style')
    <style>
        .luxury-title-product {
            font-size: 3rem;
            /* lớn hơn để nổi bật */
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;

            background: linear-gradient(45deg,
                    #0a2540,
                    #0f3c91,
                    #1e6bff,
                    #6aa7ff,
                    #00d4ff,
                    #0a2540);
            background-size: 1200% 1200%;
            /* mở rộng gradient để macro */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: luxuryGradientMacro 20s ease infinite;
            /* chậm hơn, rộng hơn */
        }

        /* Macro gradient animation */
        @keyframes luxuryGradientMacro {
            0% {
                background-position: 0% 50%;
            }

            25% {
                background-position: 50% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            75% {
                background-position: 50% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
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
            background: linear-gradient(135deg, #0a2540, #00c6ff);
            color: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #0a2540, #00c6ff);
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
            background: linear-gradient(135deg, #0a2540, #00c6ff);
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

    <div class="container py-5">
        <h2 class="luxury-title-product"> Giỏ
            hàng của bạn</h2>

        @if (count($cart))
            <div class="row">
                <!-- Danh sách sản phẩm -->
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-3 border-0 rounded-3 animate__animated animate__fadeInLeft">
                        <div class="card-body">
                            @foreach ($cart as $id => $item)
                                <div class="d-flex align-items-center mb-4 cart-item p-3 rounded hover-scale"
                                    data-id="{{ $id }}">
                                    <img src="{{ isset($item['image'])
                                        ? (Str::startsWith($item['image'], ['http://', 'https://'])
                                            ? $item['image']
                                            : asset('storage/uploads/products/' . $item['image']))
                                        : asset('storage/uploads/default.png') }}"
                                        class="rounded shadow-sm me-3 cart-img"
                                        style="width:70px;height:70px;object-fit:cover;"
                                        alt="{{ $item['name'] ?? 'Product' }}">

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">{{ $item['name'] ?? 'Product' }}</h6>
                                        {{-- VARIANT HIỆN TẠI --}}
                                        @if (!empty($item['size']) || !empty($item['color']))
                                            <div class="small text-muted mb-2">
                                                @if (!empty($item['color']))
                                                    Màu: <span class="fw-semibold">{{ $item['color'] }}</span>
                                                @endif

                                                @if (!empty($item['size']))
                                                    | Size: <span class="fw-semibold">{{ $item['size'] }}</span>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- VARIANT OPTIONS --}}
                                        @if (!empty($item['variants']))
                                            <div class="variant-box mb-3" data-key="{{ $id }}"
                                                data-variants='@json($item['variants']['map'])'>

                                                {{-- COLOR (chỉ hiện nếu có) --}}
                                                @if (!empty($item['variants']['colors']))
                                                    <label class="form-label mb-1 fw-semibold">Màu sắc</label>
                                                    <select class="form-select form-select-sm mb-2 variant-color">
                                                        <option value="">-- Chọn màu --</option>
                                                        @foreach ($item['variants']['colors'] as $color)
                                                            <option value="{{ $color }}"
                                                                @selected($color == $item['color'])>
                                                                {{ $color }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                                {{-- SIZE --}}
                                                @if (!empty($item['variants']['sizes']))
                                                    <label class="form-label mb-1 fw-semibold">Size</label>
                                                    <select class="form-select form-select-sm variant-size">
                                                        <option value="">-- Chọn size --</option>
                                                        @foreach ($item['variants']['sizes'] as $size)
                                                            <option value="{{ $size }}"
                                                                @selected($size == $item['size'])>
                                                                {{ $size }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                                <input type="hidden" class="variant-id" value="{{ $item['variant_id'] }}">
                                            </div>
                                        @endif

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="item-subtotal text-primary fw-bold fs-6">
                                                {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }}₫
                                            </span>

                                            <div class="d-flex align-items-center">
                                                <div class="input-group input-group-sm me-3" style="width: 120px;">
                                                    <button type="button" class="btn btn-outline-secondary btn-qty"
                                                        data-type="minus" data-id="{{ $id }}">−</button>
                                                    <input type="text" class="form-control text-center qty-input"
                                                        value="{{ $item['quantity'] ?? 1 }}" data-id="{{ $id }}"
                                                        readonly>
                                                    <button type="button" class="btn btn-outline-secondary btn-qty"
                                                        data-type="plus" data-id="{{ $id }}">+</button>
                                                </div>

                                                <form method="POST" action="{{ route('cart.remove', ['id' => $id]) }}">
                                                    @csrf
                                                    @method('DELETE') <!-- Quan trọng: phương thức DELETE -->
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-circle shadow-sm btn-remove ripple">
                                                        <i class="ti-close"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Tổng tiền -->
                <div class="col-lg-4">
                    <div class="card shadow-sm p-4 border-0 rounded-3 animate__animated animate__fadeInRight">
                        <h5 class="mb-3 fw-bold">Tổng cộng</h5>

                        @php
                            $totalBeforeDiscount = collect($cart)->sum(function ($i) {
                                // Nếu có discount_percent thì tính giá gốc
                                $discountPercent = $i['discount_percent'] ?? 0;
                                return $discountPercent > 0
                                    ? ($i['price'] / (1 - $discountPercent / 100)) * $i['quantity']
                                    : $i['price'] * $i['quantity'];
                            });
                        @endphp

                        <div class="d-flex justify-content-between mb-3">
                            <span>Tổng tiền:</span>
                            <div>
                                @if ($totalBeforeDiscount > $total)
                                    <span class="text-muted" style="text-decoration: line-through;">
                                        {{ number_format($totalBeforeDiscount, 0, ',', '.') }}₫
                                    </span>
                                    <span class="text-primary fw-bold ms-2">
                                        {{ number_format($total, 0, ',', '.') }}₫
                                    </span>
                                @else
                                    <span class="text-primary fw-bold">
                                        {{ number_format($total, 0, ',', '.') }}₫
                                    </span>
                                @endif
                            </div>
                        </div>


                        @if (Auth::guard('customer')->check())
                            <a href="{{ route('orders.create') }}"
                                class="btn btn-primary btn-lg w-100 mb-3 rounded-pill shadow-sm animate-btn">
                                <i class="ti-credit-card"></i> Đặt hàng
                            </a>
                        @else
                            <!-- Nếu chưa đăng nhập thì chuyển qua login -->
                            <a href="{{ route('frontend.login.index') }}"
                                class="btn btn-primary btn-lg w-100 mb-3 rounded-pill shadow-sm animate-btn">
                                <i class="ti-lock"></i> Đăng nhập để thanh toán
                            </a>
                        @endif

                        <a href="{{ route('frontend.home.index') }}"
                            class="btn btn-outline-secondary btn-lg w-100 rounded-pill shadow-sm animate-btn">
                            <i class="ti-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Giỏ hàng trống -->
            <div class="text-center py-5 animate__animated animate__fadeIn">
                <i class="ti-shopping-cart text-primary" style="font-size: 60px;"></i>
                <h4 class="mt-3 fw-bold">Giỏ hàng của bạn đang trống</h4>
                <a href="{{ route('frontend.home.index') }}"
                    class="btn btn-primary mt-3 px-4 py-2 rounded-pill shadow-sm animate-btn">
                    <i class="ti-arrow-left"></i> Tiếp tục mua sắm
                </a>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.querySelectorAll('.variant-box').forEach(box => {

                const variantMap = JSON.parse(box.dataset.variants);
                const colorSelect = box.querySelector('.variant-color');
                const sizeSelect = box.querySelector('.variant-size');
                const cartKey = box.dataset.key;

                function updateVariant() {
                    const color = colorSelect ? colorSelect.value : '';
                    const size = sizeSelect ? sizeSelect.value : '';

                    // KEY ĐÚNG THEO JSON
                    const mapKey = (color ?? '') + '|' + (size ?? '');

                    if (!variantMap[mapKey]) {
                        console.warn('❌ Variant not found:', mapKey);
                        return;
                    }

                    fetch("{{ route('cart.updateVariant') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                cart_key: cartKey,
                                variant_id: variantMap[mapKey].id
                            })
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                location.reload();
                            }
                        });
                }

                colorSelect?.addEventListener('change', updateVariant);
                sizeSelect?.addEventListener('change', updateVariant);
            });

        });
    </script>




    <script>
        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('variant-select')) return;

            const cartId = e.target.dataset.id;
            const type = e.target.dataset.type;
            const value = e.target.value;

            fetch('{{ route('cart.updateVariant') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        cart_id: cartId,
                        type: type,
                        value: value
                    })
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        location.reload();
                    }
                });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".btn-remove-favorite", function(e) {
                e.preventDefault();
                let item = $(this).closest(".favorite-item");
                let productId = item.data("id");

                $.ajax({
                    url: "{{ route('favorites.remove') }}",
                    type: "POST",
                    data: {
                        product_id: productId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            // Xoá sản phẩm khỏi DOM
                            item.remove();

                            // Cập nhật số yêu thích trên navbar
                            $(".nav-shop__circle").text(res.count);
                            $("#favorite-list").html(res.html);
                            // Nếu hết sản phẩm thì hiển thị thông báo
                            if (res.count === 0) {
                                $("#favorite-list").html(
                                    "<p>Chưa có sản phẩm yêu thích nào.</p>");
                            }

                            // Thông báo
                            Toastify({
                                text: "Đã xóa sản phẩm khỏi yêu thích",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#ff6b6b",
                            }).showToast();
                        }
                    },
                    error: function() {
                        Toastify({
                            text: "Có lỗi xảy ra!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#ff6b6b",
                        }).showToast();
                    }
                });
            });
        });
    </script>

    <script>
        function showSpinner() {
            document.getElementById("loading-overlay").style.display = "flex";
        }

        function hideSpinner() {
            document.getElementById("loading-overlay").style.display = "none";
        }

        // AJAX nút "Xem thêm"
        $("#load-more").on("click", function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).data("next-page"),
                method: "GET",
                beforeSend: function() {
                    showSpinner();
                },
                success: function(res) {
                    $("#product-list").append(res);
                },
                complete: function() {
                    hideSpinner();
                }
            });
        });

        // Spinner khi rời trang (reload / redirect)
        window.addEventListener("beforeunload", function() {
            showSpinner();
        });

        // Spinner khi click sort
        document.querySelectorAll('a[href*="?sort="]').forEach(link => {
            link.addEventListener("click", function() {
                showSpinner();
            });
        });
    </script>


@endsection

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
    <script>
        document.querySelectorAll('.btn-qty').forEach(button => {
            button.addEventListener('click', function() {
                const type = this.dataset.type;
                const id = this.dataset.id;
                const input = document.querySelector(`.qty-input[data-id="${id}"]`);
                let quantity = parseInt(input.value);

                if (type === 'plus') quantity++;
                else if (type === 'minus' && quantity > 1) quantity--;

                // Gửi AJAX cập nhật số lượng
                fetch(`/cart/update/${id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            quantity
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            input.value = quantity;

                            // Cập nhật tổng tiền sản phẩm
                            const itemSubtotal = input.closest('.cart-item').querySelector(
                                '.item-subtotal');
                            itemSubtotal.textContent = new Intl.NumberFormat('vi-VN').format(data
                                .item_total) + '₫';

                            // Cập nhật số lượng trên icon cart
                            const cartBadge = document.querySelector('.cart-count');
                            if (cartBadge) {
                                cartBadge.innerText = data.cart_count;
                                cartBadge.style.display = data.cart_count > 0 ? 'inline-flex' : 'none';
                            }
                        }
                    });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.ripple').forEach(button => {
            button.addEventListener('click', function(e) {
                const circle = document.createElement("span");
                circle.classList.add("ripple-effect");

                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                circle.style.width = circle.style.height = size + 'px';
                circle.style.left = e.clientX - rect.left - size / 2 + "px";
                circle.style.top = e.clientY - rect.top - size / 2 + "px";

                this.appendChild(circle);

                // Xóa ripple sau khi animation xong
                setTimeout(() => circle.remove(), 600);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-favorite').on('click', function() {
                let btn = $(this);
                let productId = btn.data('id');

                $.ajax({
                    url: '/favorites/add', // Route Laravel thêm yêu thích
                    type: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            // Đổi màu icon tim
                            btn.find('i').addClass('text-primary');

                            // Kiểm tra trùng trước khi append dropdown
                            if ($('#favorite-list').find('[data-id="' + productId + '"]')
                                .length === 0) {
                                let product = res.product;
                                let html = `
                            <div class="d-flex align-items-center mb-2" data-id="${product.id}">
                                <img src="${product.image}" class="mr-2 rounded" alt="${product.name}" style="width:40px;height:40px;object-fit:cover;">
                                <div>
                                    <p class="mb-0 small">${product.name}</p>
                                    <span class="text-danger small">${product.price}</span>
                                </div>
                            </div>
                        `;
                                $('#favorite-list').prepend(html);
                            }

                            // Cập nhật số lượng
                            $('.nav-shop__circle').text($('#favorite-list > div').length);

                            // Hiển thị toast
                            Toastify({
                                text: `"${res.product.name}" đã thêm vào danh sách yêu thích`,
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#4fbe87",
                            }).showToast();
                        }
                    },
                    error: function() {
                        Toastify({
                            text: "Có lỗi xảy ra!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#ff6b6b",
                        }).showToast();
                    }
                });
            });

            // Hover dropdown show
            $('.nav-item.dropdown').hover(
                function() {
                    $(this).addClass('show');
                    $(this).find('.dropdown-menu').addClass('show');
                },
                function() {
                    $(this).removeClass('show');
                    $(this).find('.dropdown-menu').removeClass('show');
                }
            );
        });
    </script>




    <script>
        $(document).ready(function() {
            var $carousel = $(".hero-carousel");

            $carousel.owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                nav: true,
                dots: true
            });

            // Gắn class active cho slide hiện tại
            $carousel.on('changed.owl.carousel', function(event) {
                var index = event.item.index; // index slide hiện tại
                $(".hero-carousel__slide").removeClass("active");
                $(".owl-item").eq(index).find(".hero-carousel__slide").addClass("active");
            });

            // Kích hoạt slide đầu tiên khi load
            $(".owl-item.active .hero-carousel__slide").addClass("active");
        });
    </script>

    <script>
        new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            effect: "fade",
            speed: 1200
        });
    </script>
@endsection
