@extends('frontend.master')
@section('title')
    Đặt hàng thành công - LHW Shop
@endsection

@section('page-style')
    <style>
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

    <div class="container my-5">
        <div class="row">

            @include('frontend.customer.partials.sidebar')

            {{-- Nội dung chính --}}
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        {{-- Chi tiết đơn hàng --}}
                        <h5 class="mb-3"> Chi tiết đơn hàng</h5>
                        <p class="mb-1">Mã đơn hàng: <strong>#{{ $order->id }}</strong></p>
                        <table class="table table-borderless mb-3">
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->details as $detail)
                                    <tr>
                                        <td>
                                            <img src="{{ isset($detail->product->image)
                                                ? (Str::startsWith($detail->product->image, ['http://', 'https://'])
                                                    ? $detail->product->image
                                                    : asset('storage/uploads/products/' . $detail->product->image))
                                                : asset('storage/uploads/default.png') }}"
                                                alt="{{ $detail->product->product_name ?? 'Product' }}" width="60"
                                                height="60" class="rounded shadow-sm" style="object-fit: cover;">


                                        </td>
                                        <td>{{ $detail->product->product_name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ number_format($detail->unit_price, 0, ',', '.') }}₫</td>
                                        <td>{{ number_format($detail->quantity * $detail->unit_price, 0, ',', '.') }}₫</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-end mb-4">
                            <h5>Tổng tiền: <span class="text-danger">{{ number_format($order->total, 0, ',', '.') }}₫
                                </span>
                            </h5>
                        </div>

                        {{-- Trạng thái đơn hàng động dạng tiến trình --}}
                        @php
                            $steps = [
                                'Pending' => ['label' => 'Chờ xử lý', 'icon' => '⏳'],
                                'Shipped' => ['label' => 'Đã gửi hàng', 'icon' => '📦'],
                                'Delivered' => ['label' => 'Đã giao', 'icon' => '🚚'],
                            ];

                            $orderFlow = ['Pending', 'Shipped', 'Delivered'];
                            $current = $order->order_status;
                        @endphp

                        @if ($current === 'Cancelled')
                            {{-- Nếu đơn bị hủy --}}
                            <div class="text-center mb-4">
                                <div class="mb-1" style="font-size: 30px; color: red;">
                                    ❌
                                </div>
                                <div class="font-weight-bold text-danger">Đã hủy</div>
                                <div class="text-muted">
                                    {{ \Carbon\Carbon::parse($order->updated_at ?? $order->created_at)->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        @else
                            <div class="position-relative d-flex justify-content-between align-items-center mb-4"
                                style="max-width: 600px; margin: auto;">
                                {{-- Thanh nối --}}
                                <div class="position-absolute w-100"
                                    style="top: 20px; height: 4px; background: #dee2e6; z-index: 1;"></div>
                                <div class="position-absolute"
                                    style="top: 20px; height: 4px; background: #28a745; z-index: 2;
            width: calc({{ (array_search($current, $orderFlow) / (count($orderFlow) - 1)) * 100 }}%);">
                                </div>

                                {{-- Các bước --}}
                                @foreach ($orderFlow as $step)
                                    @php
                                        $isActive = $step === $current;
                                        $isCompleted =
                                            array_search($step, $orderFlow) < array_search($current, $orderFlow);
                                    @endphp
                                    <div class="text-center flex-fill" style="z-index: 3;">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                                            style="width: 40px; height: 40px; margin: auto;
                        @if ($isActive) background: #007bff; color: #fff;
                        @elseif($isCompleted) background: #28a745; color: #fff;
                        @else background: #adb5bd; color: #fff; @endif">
                                            {{ $steps[$step]['icon'] }}
                                        </div>
                                        <small
                                            @if ($isActive) class="font-weight-bold text-primary"
                    @elseif($isCompleted) class="text-success"
                    @else class="text-muted" @endif>
                                            {{ $steps[$step]['label'] }}
                                        </small>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Nút hủy đơn khi còn Pending --}}
                            @if ($current === 'Pending')
                                <div class="text-center mt-3">
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hủy đơn hàng
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endif

                        {{-- Thông tin khách hàng & thanh toán --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="mb-3">Thông tin khách hàng</h6>
                                        <p class="mb-1"><strong>Họ và tên:</strong> {{ $order->ship_name }}</p>
                                        <p class="mb-1">
                                            <strong>Điện thoại:</strong> {{ $order->ship_phone }}
                                        </p>

                                        <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->ship_address1 }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="mb-3">Thông tin thanh toán</h6>
                                        <p class="mb-1">
                                            <strong>Phương thức:</strong>
                                            {{ optional($order->payment_type)->payment_name ?? ($order->payment_method ?? 'Chưa xác định') }}
                                        </p>
                                        <p><strong>Tạm tính:</strong>
                                            {{ number_format($order->subtotal, 0, ',', '.') }}₫
                                        </p>

                                        <p><strong>Voucher:</strong>
                                            -{{ number_format($order->voucher_discount, 0, ',', '.') }}₫
                                        </p>

                                        <p><strong>Phí ship:</strong>
                                            {{ number_format($order->shipping_fee, 0, ',', '.') }}₫
                                        </p>

                                        <h5 class="text-danger">
                                            Tổng cộng:
                                            {{ number_format($order->total, 0, ',', '.') }}₫
                                        </h5>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Quay lại --}}
                        <div class="text-center mt-3">
                            <a href="" class="btn btn-secondary me-2">📜 Xem lịch sử mua hàng</a>
                            <a href="" class="btn btn-primary">🏠 Quay lại Trang chủ</a>
                        </div>
                    </div>
                </div>

                {{-- Lịch sử mua hàng gần đây (nếu có) --}}
                @if ($recentOrders->count() > 0)
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="mb-3">📦 Lịch sử mua hàng gần đây</h5>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $rOrder)
                                        <tr>
                                            <td>#{{ $rOrder->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($rOrder->created_at)->format('d/m/Y') }}</td>
                                            <td>{{ number_format($rOrder->details->sum(fn($d) => $d->quantity * $d->unit_price), 0, ',', '.') }}₫
                                            </td>
                                            <td>
                                                @if ($rOrder->delivered_at)
                                                    <span class="badge bg-success">Đã nhận hàng</span>
                                                @elseif($rOrder->confirmed_at)
                                                    <span class="badge bg-info">Đã xác nhận</span>
                                                @else
                                                    <span class="badge bg-warning">Đặt hàng thành công</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-outline-primary">Xem</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

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

    .card-product__imgOverlay {
        background: rgba(255, 255, 255, 0.7);
        padding: 0.5rem;
        border-radius: 50px;
    }

    .card-product__imgOverlay li {
        list-style: none;
    }

    .card-product__imgOverlay button {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.2rem;
        /* Kích thước icon */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-product__imgOverlay button i {
        display: block;
        /* Ngăn icon bị kéo méo */
        line-height: 1;
    }
</style>

@section('user.js')
    <script>
        document.querySelectorAll('.btn-qty').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let id = this.dataset.id;
                let input = document.querySelector(`.qty-input[data-id="${id}"]`);
                let currentQty = parseInt(input.value);

                if (this.dataset.type === "plus") {
                    currentQty++;
                } else if (this.dataset.type === "minus" && currentQty > 1) {
                    currentQty--;
                }

                fetch(`/cart/update/${id}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            quantity: currentQty
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            input.value = data.quantity;

                            // update giá sản phẩm
                            let itemRow = document.querySelector(`.cart-item[data-id="${id}"]`);
                            itemRow.querySelector(".item-subtotal").innerText = data.subtotal;

                            // update tổng tiền
                            document.querySelector(".cart-total").innerText = data.total;
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
            $(".btn-remove-favorite").on("click", function() {
                let btn = $(this);
                let item = btn.closest(".favorite-item");
                let productId = item.data("id");

                $.ajax({
                    url: "/favorites/remove",
                    type: "POST",
                    data: {
                        product_id: productId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            item.remove();

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
