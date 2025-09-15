<div class="col-lg-3 mb-4">
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="https://ui-avatars.com/api/?name={{ $customer->first_name }}+{{ $customer->last_name }}&background=random" 
                        alt="Avatar" class="rounded-circle" width="80" height="80">
            </div>
            <p class="mb-1"><strong>{{ $customer->first_name }} {{ $customer->last_name }}</strong></p>
            <p class="text-muted small mb-2">{{ $customer->email }}</p>
            <a href="" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                class="btn btn-outline-danger btn-sm w-100">
                Đăng xuất
            </a>
            <form id="logout-form" action="" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ route('customer.dashboard') }}" class="text-decoration-none">Tổng quan</a></li>
                <li class="list-group-item"><a href="#" class="text-decoration-none">Lịch sử mua hàng</a></li>
                <li class="list-group-item"><a href="#" class="text-decoration-none">Tra cứu bảo hành</a></li>
                <li class="list-group-item"><a href="#" class="text-decoration-none">Sản phẩm yêu thích</a></li>
                <li class="list-group-item"><a href="#" class="text-decoration-none">Thông tin tài khoản</a></li>
                <li class="list-group-item"><a href="#" class="text-decoration-none">Tìm kiếm cửa hàng</a></li>
                <li class="list-group-item"><a href="#" class="text-decoration-none">Chính sách bảo hành</a></li>
                <li class="list-group-item"><a href="#" class="text-decoration-none">Điều khoản sử dụng</a></li>
                <li class="list-group-item"><a href="{{ url('/') }}" class="text-decoration-none">Trang chủ</a></li>
            </ul>
        </div>
    </div>
</div>