@extends('frontend.master')
@section('title')
    Giỏ hàng của bạn
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('paymentModal');
            if (modal) {
                document.body.appendChild(modal);
            }
        });
    </script>


    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('orders.store') }}" class="p-4 border rounded shadow-sm bg-white">
                    @csrf

                    {{-- 🛒 Thông tin sản phẩm --}}
                    <h5 class="mb-3"> Thông tin sản phẩm</h5>
                    <div class="list-group mb-3">
                        @php $total = 0; @endphp
                        @foreach ($cart as $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-3">
                                    <img src="{{ $item['image'] ?? 'https://via.placeholder.com/60' }}"
                                        alt="{{ $item['name'] }}" class="rounded border"
                                        style="width:60px; height:60px; object-fit:cover;">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">{{ $item['name'] }}</div>
                                    <small class="text-muted">Số lượng: x{{ $item['quantity'] }}</small>
                                </div>
                                <div class="fw-bold text-danger">
                                    {{ number_format($subtotal, 0, ',', '.') }}₫
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <hr>

                    {{-- 👤 Thông tin khách hàng --}}
                    <h5 class="mb-3">👤 Thông tin khách hàng</h5>
                    <input type="text" name="ship_name" value="{{ $customer->name }}" class="form-control mb-3"
                        placeholder="Họ và tên" required>
                    <input type="email" name="email" value="{{ $customer->email }}" class="form-control mb-3"
                        placeholder="Email" required readonly>
                    <input type="text" name="ship_phone" value="{{ $customer->phone }}" class="form-control mb-3"
                        placeholder="Số điện thoại" required>

                    {{-- 🚚 Thông tin nhận hàng --}}
                    <h5 class="mb-3">🚚 Thông tin nhận hàng</h5>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="delivery_type" id="storePickup" value="store"
                            checked>
                        <label class="form-check-label" for="storePickup">Nhận tại cửa hàng</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="delivery_type" id="homeDelivery"
                            value="home">
                        <label class="form-check-label" for="homeDelivery">Giao hàng tận nơi</label>
                    </div>

                    {{-- Form nhập địa chỉ (ẩn mặc định) --}}
                    <div id="deliveryInfo" style="display: none;">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Số nhà, tên đường</label>
                                    <input type="text" id="address" name="address" class="form-control"
                                        placeholder="Nhập địa chỉ cụ thể">
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="city" class="form-label">Tỉnh/Thành phố</label>
                                        <select name="city" class="form-select custom-select js-city">
                                            <option value="">-- Chọn tỉnh/thành --</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="ward" class="form-label">Xã/Phường</label>
                                        <select name="ward" class="form-select custom-select js-ward">
                                            <option value="">-- Chọn xã/phường --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <script>
                        $(document).on('change', '.js-city', function() {
                            let city_id = $(this).val();
                            let wardSelect = $('.js-ward');

                            wardSelect.html('<option value="">-- Chọn xã/phường --</option>');

                            if (!city_id) return;

                            $.ajax({
                                url: `/get-wards/${city_id}`,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    console.log('Wards:', data);

                                    if (data.length === 0) {
                                        wardSelect.append('<option value="">Không có xã/phường</option>');
                                        return;
                                    }

                                    data.forEach(function(ward) {
                                        wardSelect.append(
                                            `<option value="${ward.id}">${ward.name}</option>`
                                        );
                                    });
                                }
                            });
                        });
                    </script>



                    {{-- 🎟 Voucher --}}
                    <div class="card shadow-sm mb-3">
                        <div class="card-header fw-bold">VOUCHER</div>
                        <div class="card-body">
                            @if ($vouchers->count() > 0)
                                <select name="voucher_id" class="form-select custom-select">
                                    <option value="" data-discount="0">-- Chọn voucher --</option>
                                    @foreach ($vouchers as $voucher)
                                        <option value="{{ $voucher->id }}"
                                            data-discount="{{ $voucher->discount_amount }}"
                                            @if ($appliedVoucher && $appliedVoucher['id'] == $voucher->id) selected @endif>
                                            {{ $voucher->code }} - Giảm
                                            {{ number_format($voucher->discount_amount, 0, ',', '.') }}₫
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <p class="text-muted">Bạn chưa có voucher nào.</p>
                            @endif
                        </div>
                    </div>
                    <input type="hidden" name="payment_type_id" id="payment_type_id">
                    {{-- 💳 Thông tin thanh toán --}}
                    <div class="card shadow-sm mb-3">
                        <div class="card-header fw-bold">THÔNG TIN THANH TOÁN</div>
                        <div class="card-body">
                            <!-- Nút mở modal -->
                            <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#paymentModal">
                                @if (!empty($selectedPaymentLabel))
                                    Thanh toán bằng: <b>{{ $selectedPaymentLabel }}</b>
                                @else
                                    <span id="paymentLabel">Chọn phương thức thanh toán</span>
                                @endif
                            </button>
                        </div>
                    </div>


                    <div class="card shadow-sm mb-3">
                        <div class="card-header fw-bold">THANH TOÁN</div>
                        <div class="card-body">

                            {{-- Tạm tính --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span>
                                    {{ number_format($totalAfterProductDiscount, 0, ',', '.') }}₫
                                </span>
                            </div>

                            {{-- Phí ship --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí ship:</span>
                                <span id="shippingFee">
                                    {{ number_format($shippingFee, 0, ',', '.') }}₫
                                </span>
                            </div>

                            {{-- Voucher --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span>Voucher:</span>
                                <span id="voucherDiscount" class="text-success">
                                    -{{ number_format($voucherDiscount, 0, ',', '.') }}₫
                                </span>
                            </div>

                            <hr>

                            {{-- Tổng cộng --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Tổng cộng:</h5>
                                <h5 class="mb-0 text-danger fw-bold" id="grandTotal">
                                    {{ number_format($grandTotal, 0, ',', '.') }}₫
                                </h5>
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Đặt hàng</button>


                </form>
                <!-- Modal chọn phương thức thanh toán -->
                <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="paymentModalLabel">Chọn phương thức thanh toán
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">

                                @if ($paymentTypes->count() > 0)
                                    <div class="list-group">
                                        @foreach ($paymentTypes as $payment)
                                            <label class="list-group-item d-flex align-items-center payment-option"
                                                style="cursor:pointer;">
                                                <input type="radio" name="payment_type" value="{{ $payment->id }}"
                                                    class="form-check-input me-3"
                                                    @if (!empty($selectedPayment) && $selectedPayment == $payment->id) checked @endif>
                                                <div>
                                                    <strong>{{ $payment->payment_name }}</strong>
                                                    @if ($payment->description)
                                                        <div class="small text-muted">{{ $payment->description }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">Chưa có phương thức thanh toán nào.</p>
                                @endif

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="button" id="confirmPaymentBtn" class="btn btn-danger"
                                    data-bs-dismiss="modal">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ===== GIÁ TRỊ BAN ĐẦU TỪ CONTROLLER =====
            let baseTotal = {{ $totalAfterProductDiscount }};
            let shippingFee = {{ $shippingFee ?? 0 }};
            let voucherDiscount = {{ $voucherDiscount ?? 0 }};

            // ===== UPDATE UI =====
            function updateTotal() {
                let finalTotal = baseTotal + shippingFee - voucherDiscount;

                document.getElementById("shippingFee").textContent =
                    shippingFee.toLocaleString("vi-VN") + "₫";

                document.getElementById("voucherDiscount").textContent =
                    "-" + voucherDiscount.toLocaleString("vi-VN") + "₫";

                document.getElementById("grandTotal").textContent =
                    finalTotal.toLocaleString("vi-VN") + "₫";
            }

            // ===== CHỌN HÌNH THỨC GIAO HÀNG =====
            document.querySelectorAll("input[name='delivery_type']").forEach(el => {
                el.addEventListener("change", function() {
                    shippingFee = this.value === "home" ? 30000 : 0;
                    updateTotal();
                });
            });

            // ===== CHỌN VOUCHER =====
            const voucherSelect = document.querySelector("select[name='voucher_id']");
            if (voucherSelect) {
                voucherSelect.addEventListener("change", function() {
                    voucherDiscount = parseInt(
                        this.options[this.selectedIndex].dataset.discount || 0
                    );
                    updateTotal();
                });
            }

            updateTotal();
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmBtn = document.getElementById('confirmPaymentBtn');
            const labelSpan = document.getElementById('paymentLabel');
            const hiddenInput = document.getElementById('payment_type_id');

            confirmBtn.addEventListener('click', function() {
                const selected = document.querySelector('input[name="payment_type"]:checked');

                if (!selected) {
                    alert('Vui lòng chọn phương thức thanh toán');
                    return;
                }

                hiddenInput.value = selected.value;

                labelSpan.innerHTML = 'Thanh toán bằng: <b>' +
                    selected.closest('label').querySelector('strong').innerText +
                    '</b>';
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


@endsection
<style>
    /* Select đẹp hơn */
    .custom-select {
        border: 2px solid #dee2e6;
        /* màu xám nhạt */
        border-radius: 12px;
        /* bo góc */
        padding: 8px 12px;
        transition: all 0.3s ease-in-out;
    }

    /* Khi hover */
    .custom-select:hover {
        border-color: #0d6efd;
        /* xanh Bootstrap */
    }

    /* Khi focus */
    .custom-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 6px rgba(13, 110, 253, 0.4);
        /* ánh sáng xanh */
    }

    /* Tooltip chung cho nút con */
    .contact-item::after {
        content: attr(data-label);
        /* Lấy text từ attribute */
        position: absolute;
        right: 60px;
        /* khoảng cách so với nút */
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.75);
        color: #fff;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
    }

    /* Khi hover nút con thì hiện tooltip */
    .contact-item:hover::after {
        opacity: 1;
        visibility: visible;
        right: 70px;
    }

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

    .section-intro h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #007bff, #00c6ff);
        display: inline-block;
        padding: 10px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }


    /* Box nổi bật */
    .highlight-box {
        background: linear-gradient(135deg, #007bff, #00c6ff);
        /* xanh dương gradient */
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    /* Chữ trong khung */
    .highlight-box h2 {
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Reset chiều cao Swiper wrapper */
    .featuredSwiper {
        height: auto !important;
        padding-bottom: 1rem;
        /* tạo khoảng cách nhỏ đẹp mắt, không bị to */
    }

    /* Swiper wrapper auto fit */
    .featuredSwiper .swiper-wrapper {
        height: auto !important;
        align-items: stretch;
        /* các card bằng nhau theo chiều cao lớn nhất */
    }

    /* Slide cũng auto */
    .featuredSwiper .swiper-slide {
        height: auto !important;
        display: flex;
        justify-content: center;
    }

    /* Slide giữ căn giữa */
    .featuredSwiper .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        /* không stretch nữa */
        height: auto !important;
    }

    /* Card gọn gàng */
    .featuredSwiper .card-product {
        max-width: 260px;
        height: auto;
        /* không kéo giãn */
        display: flex;
        flex-direction: column;
        border-radius: 16px;
        transition: transform .3s ease, box-shadow .3s ease;
    }

    /* Ảnh đồng bộ */
    .featuredSwiper .card-product__img img {
        height: 220px;
        object-fit: contain;
        background: #f8f9fa;
        padding: 12px;
        border-bottom: 1px solid #eee;
    }

    /* Body giữ cân bằng */
    .featuredSwiper .card-body {
        flex: 1 1 auto;
        min-height: 160px;
        /* để card đều nhau */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
    }

    .card-product {
        border: 2px solid #007bff;
        /* viền xanh dương */
        border-radius: 12px;
        /* bo góc mềm */
        overflow: hidden;
        /* giữ nội dung không tràn */
        background: #fff;
        /* nền trắng gọn gàng */
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .card-product:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 20px rgba(0, 123, 255, .2);
    }

    .transition-icons {
        opacity: 0;
        transform: scale(0.8);
        transition: all .3s;
    }

    .card-product:hover .transition-icons {
        opacity: 1;
        transform: scale(1);
    }

    .filter-buttons .btn {
        min-width: 150px;
        /* Đảm bảo nút đều nhau */
        text-align: center;
        border-radius: 25px;
        /* Bo tròn mềm mại */
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .filter-buttons .dropdown .btn {
        min-width: 180px;
    }

    .filter-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .filter-buttons .dropdown-menu {
        min-width: auto;
        border-radius: 8px;
    }

    .breadcrumb-transparent {
        background-color: transparent !important;
        /* bỏ nền */
        padding: 0;
        /* bỏ padding mặc định */
        margin: 0;
        /* nếu muốn sát container */
    }

    .breadcrumb-transparent .breadcrumb-item+.breadcrumb-item::before {
        color: #6c757d;
        /* màu dấu phân cách / */
    }

    .breadcrumb-transparent .breadcrumb-item a {
        color: #0d6efd;
        /* màu link */
        transition: color 0.3s ease;
    }

    .breadcrumb-transparent .breadcrumb-item a:hover {
        color: #ff416c;
        /* màu hover */
    }

    .breadcrumb-transparent .breadcrumb-item.active {
        color: #6c757d;
        /* màu chữ active */
    }

    /* Container logo */
    .supplier-logos-wrapper {
        padding: 1rem 0;
    }

    /* Logo container scroll ngang */
    .supplier-logos {
        justify-content: flex-start;
        /* căn trái */
        scrollbar-width: thin;
        scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
    }

    /* Logo hover & card */
    .supplier-logo {
        flex: 0 0 auto;
        width: 120px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        border-radius: 12px;
        background-color: #f8f9fa;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .supplier-logo:hover {
        transform: translateY(-5px) scale(1.1);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    /* Logo image */
    .supplier-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    /* Scrollbar đẹp cho webkit */
    .supplier-logos::-webkit-scrollbar {
        height: 6px;
    }

    .supplier-logos::-webkit-scrollbar-track {
        background: transparent;
    }

    .supplier-logos::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    /* Responsive nhỏ */
    @media (max-width: 768px) {
        .supplier-logo {
            width: 100px;
            height: 50px;
        }
    }

    @media (max-width: 576px) {
        .supplier-logo {
            width: 80px;
            height: 40px;
        }
    }

    /* Hover effect cho card và ảnh */
    .card-product:hover .card-product__img img {
        transform: scale(1.1);
    }

    .card-product:hover .card-product__imgOverlay {
        opacity: 1;
    }

    .card-product__imgOverlay button {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-product__imgOverlay button:hover {
        transform: scale(1.2);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Cải thiện typography */
    .section-intro h2 {
        font-size: 2rem;
        letter-spacing: 0.5px;
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

    .card-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .card-product__price .text-danger {
        background: rgba(255, 77, 77, 0.1);
        padding: 0 0.3rem;
        border-radius: 4px;
    }

    /* Khung ảnh */
    .card-product__img {
        position: relative;
        overflow: hidden;
        /* giữ icon trong vùng ảnh */
        border-bottom: 1px solid #eee;
    }

    /* Ảnh sản phẩm */
    .card-product__img img {
        width: 100%;
        height: 220px;
        object-fit: contain;
        background: #fff;
        transition: transform 0.3s ease;
    }

    /* Overlay icon */
    .card-product__imgOverlay {
        bottom: 10px;
        /* dịch xuống trong ảnh */
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    /* Hover: hiện icon */
    .card-product__img:hover .card-product__imgOverlay {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
</style>
@section('user.js')
    <script>
        const storePickup = document.getElementById('storePickup');
        const homeDelivery = document.getElementById('homeDelivery');
        const deliveryInfo = document.getElementById('deliveryInfo');

        function toggleDelivery() {
            if (homeDelivery.checked) {
                deliveryInfo.style.display = 'block';
            } else {
                deliveryInfo.style.display = 'none';
            }
        }

        storePickup.addEventListener('change', toggleDelivery);
        homeDelivery.addEventListener('change', toggleDelivery);
        window.addEventListener('load', toggleDelivery);
    </script>

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
