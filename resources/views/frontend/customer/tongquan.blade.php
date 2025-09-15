@extends('frontend.customer.dashboard')
@section('title')
Lịch sử mua hàng 
@endsection

@section('content-main')
<div class="row text-center mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm rounded-2xl p-3">
            <h5 class="text-primary mb-1">{{ $stats['total'] }}</h5>
            <small class="text-muted">Tổng đơn hàng</small>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm rounded-2xl p-3">
            <h5 class="text-warning mb-1">{{ $stats['pending'] }}</h5>
            <small class="text-muted">Chờ xử lý</small>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm rounded-2xl p-3">
            <h5 class="text-success mb-1">{{ $stats['delivered'] }}</h5>
            <small class="text-muted">Đã giao</small>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm rounded-2xl p-3">
            <h5 class="text-danger mb-1">{{ $stats['cancelled'] }}</h5>
            <small class="text-muted">Đã hủy</small>
        </div>
    </div>
</div>
<div class="card shadow-sm rounded-2xl">
    <div class="card-header bg-light">
        <strong>🆕 Đơn hàng gần đây</strong>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($order->order_status == 'Pending')
                                <span class="badge bg-warning text-dark">Chờ xử lý</span>
                            @elseif($order->order_status == 'Shipped')
                                <span class="badge bg-info text-dark">Đã gửi</span>
                            @elseif($order->order_status == 'Delivered')
                                <span class="badge bg-success">Đã giao</span>
                            @elseif($order->order_status == 'Cancelled')
                                <span class="badge bg-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                        <td>
                            <a href="{{ route('orders.success', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                Xem
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Chưa có đơn hàng nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection