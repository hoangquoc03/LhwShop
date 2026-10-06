@extends('frontend.master')
@section('title')
    Thanh toán - LHW Shop
@endsection

@section('page-style')
    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <div class="text-center mb-4">

                            <h4 class="fw-bold mb-2">
                                Thanh toán đơn hàng
                            </h4>

                            <p class="text-muted mb-0">
                                Đơn hàng #{{ $order->id }}
                            </p>

                        </div>


                        {{-- SỐ TIỀN --}}
                        <div class="text-center mb-4">

                            <div class="text-muted small">
                                Số tiền cần thanh toán
                            </div>

                            <div class="fs-3 fw-bold text-danger">
                                {{ number_format($orderTotal, 0, ',', '.') }} ₫
                            </div>

                        </div>


                        {{-- QR CODE --}}
                        <div class="text-center mb-4">

                            <div class="mb-3">
                                <span class="fw-semibold">
                                    Quét mã QR để chuyển khoản
                                </span>
                            </div>

                            <img src="{{ $qrUrl }}" alt="QR thanh toán" class="img-fluid" style="max-width: 320px;">

                        </div>


                        {{-- THÔNG TIN CHUYỂN KHOẢN --}}
                        <div class="border rounded-3 p-3 mb-4">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">
                                    Ngân hàng
                                </span>

                                <strong>
                                    {{ config('services.sepay.bank') }}
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">
                                    Số tài khoản
                                </span>

                                <strong>
                                    {{ config('services.sepay.account_number') }}
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">
                                    Chủ tài khoản
                                </span>

                                <strong>
                                    {{ config('services.sepay.account_name') }}
                                </strong>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">

                                <span class="text-muted">
                                    Nội dung chuyển khoản
                                </span>

                                <strong class="text-danger">
                                    {{ $order->payment_code }}
                                </strong>

                            </div>

                        </div>


                        {{-- ĐANG CHỜ THANH TOÁN --}}
                        <div id="paymentWaiting" class="text-center">

                            <div class="spinner-border text-primary mb-3"></div>

                            <div class="fw-semibold">
                                Đang chờ thanh toán...
                            </div>

                            <div class="text-muted small mt-1">
                                Vui lòng chuyển khoản đúng số tiền và nội dung.
                            </div>

                            <div class="text-muted small mt-2">
                                Hệ thống sẽ tự động xác nhận sau khi nhận được tiền.
                            </div>

                        </div>


                        {{-- THANH TOÁN THÀNH CÔNG --}}
                        <div id="paymentSuccess" class="text-center d-none">

                            <div class="rounded-circle bg-success text-white
                d-inline-flex align-items-center
                justify-content-center mb-3"
                                style="width:60px;height:60px;">
                                ✓
                            </div>

                            <h5 class="fw-bold text-success">
                                Chuyển khoản thành công
                            </h5>

                            <p class="text-muted mb-3">
                                Đơn hàng của bạn đã được thanh toán.
                            </p>

                            <a href="{{ route('orders.success', $order->id) }}" class="btn btn-success">
                                Xem đơn hàng
                            </a>

                        </div>


                        {{-- SCRIPT KIỂM TRA THANH TOÁN --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {

                                const waiting = document.getElementById('paymentWaiting');
                                const success = document.getElementById('paymentSuccess');

                                let checking = true;

                                function checkPaymentStatus() {

                                    if (!checking) {
                                        return;
                                    }

                                    fetch("{{ route('orders.payment.status', $order->id) }}", {
                                            method: 'GET',
                                            headers: {
                                                'Accept': 'application/json',
                                                'X-Requested-With': 'XMLHttpRequest'
                                            },
                                            credentials: 'same-origin'
                                        })
                                        .then(response => {

                                            if (!response.ok) {
                                                throw new Error('HTTP ' + response.status);
                                            }

                                            return response.json();
                                        })
                                        .then(data => {

                                            console.log('Payment status:', data);

                                            if (data.paid === true) {

                                                checking = false;

                                                waiting.classList.add('d-none');
                                                success.classList.remove('d-none');

                                                // Chờ một chút để khách nhìn thấy thông báo
                                                setTimeout(function() {
                                                    window.location.href =
                                                        "{{ route('orders.success', $order->id) }}";
                                                }, 1500);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Payment status error:', error);
                                        });
                                }

                                // Kiểm tra ngay lần đầu
                                checkPaymentStatus();

                                // Sau đó kiểm tra mỗi 3 giây
                                setInterval(checkPaymentStatus, 3000);

                            });
                        </script>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
