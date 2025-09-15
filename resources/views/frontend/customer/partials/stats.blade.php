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