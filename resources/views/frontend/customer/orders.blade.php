@extends('frontend.customer.dashboard')
@section('title')
Lịch sử mua hàng 
@endsection
  
@section('content-main')
<h4 class="mb-4">🛒 Lịch sử mua hàng</h4>

<div class="card shadow-sm rounded-3">
    <div class="card-body p-0">
        <table class="table align-middle table-striped mb-0">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Mã đơn</th>
                    <th scope="col">Ngày đặt</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col" class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($order->order_status == 'Pending')
                                <span class="badge bg-warning text-dark px-3 py-2">⏳ Chờ xử lý</span>
                            @elseif($order->order_status == 'Shipped')
                                <span class="badge bg-info text-dark px-3 py-2">📦 Đã gửi</span>
                            @elseif($order->order_status == 'Delivered')
                                <span class="badge bg-success px-3 py-2">✅ Đã giao</span>
                            @elseif($order->order_status == 'Cancelled')
                                <span class="badge bg-danger px-3 py-2">❌ Đã hủy</span>
                            @endif
                        </td>
                        <td class="text-danger fw-bold">
                            {{ number_format($order->total_price, 0, ',', '.') }}₫
                        </td>
                        <td class="text-center">
                            <a href="{{ route('orders.success', $order->id) }}" 
                               class="btn btn-sm btn-gradient px-3 py-2">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            🚫 Bạn chưa có đơn hàng nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-3 d-flex justify-content-center">
    {{ $orders->links('pagination::bootstrap-5') }}
</div>

{{-- Style riêng --}}
<style>
    .btn-gradient {
        background: linear-gradient(135deg,#007bff,#00c6ff);
        color: #fff;
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .btn-gradient:hover {
        background: linear-gradient(135deg,#0056b3,#00aaff);
        transform: translateY(-2px);
    }
</style>
@endsection