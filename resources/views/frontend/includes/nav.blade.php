

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top transparent-navbar">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand logo_h" href="{{ route('frontend.home.index') }}">
            <img src="{{ asset('frontend/img/logo.png') }}" alt="Logo" height="40">
        </a>

        <!-- Nút thu gọn -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="ti-menu"></i>
        </button>

        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <!-- Menu chính -->
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
                <li class="nav-item {{ request()->routeIs('frontend.home.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('frontend.home.index') }}">
                        <i class="ti-home"></i> Trang chủ
                    </a>
                </li>

                <!-- Danh mục -->
                <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle"> 
                    <i class="ti-view-grid"></i> Danh mục
                </a>
                
                    
                    <!-- Menu cấp 1 -->
                    <ul class="dropdown-menu">
                        @foreach ($categories as $item)
                            <li class="dropdown-submenu">
                                <!-- Link danh mục -->
                                <a class="dropdown-item" href="{{ route('products.byCategory', $item->id) }}">
                                    {{ $item->categories_text }}
                                </a>

                                <!-- Mega menu -->
                                <div class="mega-menu">
                                    <div class="row">

                                        {{-- Cột 1: Hãng --}}
                                        <div class="col-md-4">
                                            <h6 class="dropdown-header">Hãng</h6>
                                            @foreach ($item->products->pluck('supplier')->unique('id') as $s)
                                                @if ($s) {{-- tránh lỗi nếu sản phẩm chưa có supplier --}}
                                                    <a class="dropdown-item" 
                                                    href="{{ route('products.filter', ['category_id' => $item->id, 'supplier_id' => $s->id]) }}">
                                                        {{ $s->supplier_text }}
                                                    </a>
                                                @endif
                                            @endforeach

                                        </div>

                                        {{-- Cột 2: Mức giá --}}
                                        <div class="col-md-4">
                                            <h6 class="dropdown-header">Mức giá</h6>
                                            <a class="dropdown-item" href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 1]) }}">Dưới 2 triệu</a>
                                            <a class="dropdown-item" href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 2]) }}">2 - 4 triệu</a>
                                            <a class="dropdown-item" href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 3]) }}">4 - 7 triệu</a>
                                            <a class="dropdown-item" href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 4]) }}">7 - 13 triệu</a>
                                            <a class="dropdown-item" href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 5]) }}">13 - 20 triệu</a>
                                            <a class="dropdown-item" href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 6]) }}">Trên 20 triệu</a>
                                        </div>

                                        {{-- Cột 3: Sản phẩm nổi bật / mới --}}
                                        <div class="col-md-4">
                                            <h6 class="dropdown-header">Sản phẩm</h6>
                                            @foreach ($item->products->sortByDesc('created_at')->take(6) as $product)
                                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">
                                                    <span class="text-truncate" style="max-width: 120px;">
                                                        {{ $product->product_name }}
                                                    </span>
                                                    <span>
                                                        @if($product->is_featured)
                                                            <span class="badge badge-success ml-1">Nổi bật</span>
                                                        @endif
                                                        @if($product->is_new)
                                                            <span class="badge badge-info ml-1">Mới</span>
                                                        @endif
                                                    </span>
                                                </a>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </li>
            
            </ul>

            <!-- Menu bên phải -->
            <ul class="nav-shop d-flex align-items-center">
                <!-- Ô tìm kiếm -->
                <li class="nav-item mr-3 position-relative">
                    <!-- Search Box -->
                    <form action="{{ route('products.filter') }}" method="GET" class="search-box">
                        <div class="search-wrapper position-relative">
                            <input type="text" id="search-input" name="query" class="form-control" placeholder="Hôm nay bạn muốn mua gì?">
                            
                            <div id="search-suggestions" class="list-group suggestions-box"></div>
                        </div>
                    </form>
                    <!-- Box hiển thị gợi ý -->
                    <div id="search-suggestions" class="list-group position-absolute w-100 shadow-sm" style="z-index:1000; display:none;">
                    </div>
                </li>


                <!-- Yêu thích -->
                <li class="nav-item dropdown mr-3">
                    <button class="btn btn-light position-relative dropdown-toggle" data-toggle="dropdown">
                        <i class="ti-heart"></i>
                        <span class="nav-shop__circle nav-favorites__count ">{{ count(session('favorites', [])) }}</span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right p-3 shadow" style="min-width:260px;">
                        <h6 class="dropdown-header">Sản phẩm yêu thích</h6>
                        <div id="favorite-list">
                            @php $favoriteProducts = session('favorites', []); @endphp
                            @foreach(App\Models\ShopProduct::whereIn('id', $favoriteProducts)->take(3)->get() as $product)
                            <div class="d-flex align-items-center mb-2" data-id="{{ $product->id }}">
                                <img src="{{ asset('storage/uploads/products/' . basename($product->image)) }}" 
                                    class="mr-2 rounded" 
                                    alt="{{ $product->product_name }}" 
                                    style="width:40px;height:40px;object-fit:cover;">
                                <div>
                                    <p class="mb-0 small">{{ $product->product_name }}</p>
                                    <span class="text-danger small">{{ number_format($product->list_price,0,',','.') }}₫</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('favorites.index') }}" class="btn btn-primary btn-sm btn-block">
                            <i class="ti-eye"></i> Xem tất cả
                        </a>

                </li>

                <li class="nav-item dropdown mr-3">
                    <button class="btn btn-light position-relative dropdown-toggle" data-toggle="dropdown">
                        <i class="ti-shopping-cart"></i>
                        <span class="nav-shop__circle nav-cart__count">{{ collect(session('cart', []))->sum('quantity') }}</span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right p-3 shadow cart-dropdown" style="min-width:300px;">
                        <h6 class="dropdown-header">Giỏ hàng của bạn</h6>
                        <div class="cart-items">
                            @php $cart = session('cart', []) @endphp
                            @forelse($cart as $id => $item)
                            <div class="d-flex align-items-center mb-2 cart-item" data-id="{{ $id }}">
                                <img src="{{ $item['image'] }}" class="mr-2 rounded" style="width:40px;height:40px;object-fit:cover;">
                                <div class="flex-grow-1">
                                    <p class="mb-0 small font-weight-bold">{{ $item['name'] }}</p>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-danger small">{{ number_format($item['price'],0,',','.') }}₫</span>
                                        <span class="small text-muted">x{{ $item['quantity'] }}</span>
                                    </div>
                                </div>
                                <form method="POST" action="">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link text-danger">
                                        <i class="ti-close"></i>
                                    </button>
                                </form>
                            </div>
                            @empty
                            <p class="text-center text-muted small empty-cart">Giỏ hàng trống</p>
                            @endforelse
                        </div>

                        @if(count($cart))
                        <div class="cart-total mt-2">
                            <div class="dropdown-divider"></div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="font-weight-bold">Tổng:</span>
                                <span class="text-danger font-weight-bold">{{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),0,',','.') }}₫</span>
                            </div>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-primary btn-sm btn-block mb-2">
                                <i class="ti-eye"></i> Xem giỏ hàng
                            </a>
                            <a href="#" class="btn btn-primary btn-sm btn-block">
                                <i class="ti-credit-card"></i> Thanh toán
                            </a>
                        </div>
                        @endif
                    </div>
                </li>
@if(Auth::guard('customer')->check())
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <i class="ti-user"></i> {{ Auth::guard('customer')->user()->first_name }}
        </a>
        <div class="dropdown-menu dropdown-menu-right p-3" style="width: 350px;">

            {{-- Hồ sơ và đăng xuất --}}
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <a href="" class="btn btn-sm btn-primary">Hồ sơ</a>
                <a href="" class="btn btn-sm btn-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Đăng xuất
                </a>
                <form id="logout-form" action="{{ route('frontend.login.index') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            {{-- Tabs thông báo --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Thông báo</strong>
                <a href="#" class="small">Đánh dấu đã đọc tất cả</a>
            </div>
            <ul class="nav nav-tabs nav-fill mb-3" id="notificationTabs" role="tablist" style="border-bottom: 2px solid #dee2e6; border-radius: 5px; overflow: hidden;">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab"
                    aria-controls="all" aria-selected="true"
                    style="border: none; background-color: #f1f3f5; color: #495057; padding: 8px 12px;">
                    Tất cả
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab"
                    aria-controls="order" aria-selected="false"
                    style="border: none; background-color: #f1f3f5; color: #495057; padding: 8px 12px;">
                    Đơn hàng
                    </a>
                </li>
            </ul>

            {{-- Nội dung tab --}}
            <div class="tab-content" id="notificationTabsContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                    @php
                        $recentOrders = \App\Models\ShopOrder::where('customer_id', Auth::guard('customer')->id())
                                        ->latest()
                                        ->take(5)
                                        ->get();
                    @endphp
                    @foreach($recentOrders as $recent)
                    <div class="notification-item d-flex align-items-start mb-2 p-2" 
                         style="border-radius: 5px; background: {{ $loop->first ? '#e8f0fe' : '#f9f9f9' }}">
                        <div class="icon mr-2">
                            @if($recent->status == 'delivered')
                                <i class="ti-check-box text-success"></i>
                            @elseif($recent->status == 'ready')
                                <i class="ti-shopping-cart text-primary"></i>
                            @else
                                <i class="ti-shopping-cart"></i>
                            @endif
                        </div>
                        <div class="content">
                            <div style="font-size: 14px;">
                                {!! $recent->message ?? "Đơn hàng <strong>#{$recent->id}</strong> đang xử lý." !!}
                            </div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($recent->order_date)->diffForHumans() }}</small>
                            <div>
                                <a href="{{ route('orders.success', $recent->id) }}" class="small">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Tab Đơn hàng --}}
                <div class="tab-pane fade" id="order" role="tabpanel">
                    {{-- Bạn có thể lọc riêng đơn hàng ở đây nếu muốn --}}
                </div>
            </div>

        </div>
    </li>
@else
    <li class="nav-item">
        <a href="{{ route('frontend.login.index') }}" class="nav-link">
            <i class="ti-user"></i> Đăng nhập
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('frontend.register.register') }}" class="nav-link">
            <i class="ti-pencil-alt"></i> Đăng ký
        </a>
    </li>
@endif


            </ul>
        </div>
    </div>
</nav>

<style>

    .dropdown-hover:hover .dropdown-menu {
        display: block;
    }
    .dropdown-hover .dropdown-menu {
        margin-top: 0; /* loại bỏ khoảng trống trên */
    }
    .search-wrapper {
        max-width: 400px;
        margin: 0 auto;
    }

    #search-input {
        border-radius: 20px;
        padding-left: 15px;
        padding-right: 40px;
    }

    .suggestions-box {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-top: none;
        max-height: 350px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .suggestions-box a {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        text-decoration: none;
        color: #333;
        transition: background 0.2s;
    }

    .suggestions-box a:hover {
        background: #f8f9fa;
    }

    .suggestions-box img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        margin-right: 10px;
        border-radius: 6px;
    }

    .client.dropdown-menu li a {
        display: flex;
        align-items: center; /* Căn icon và text theo chiều dọc */
        gap: 8px; /* khoảng cách giữa icon và text */
        padding: 8px 15px; /* đều padding để nhìn đẹp hơn */
        width: 100%;
    }

    .client.dropdown-menu li a i {
        font-size: 16px;
        min-width: 20px; /* giữ độ rộng cố định cho icon để text thẳng hàng */
        text-align: center;
    }

    .logo_h img {
        width: 150px;
        height: auto;
    }
    .logo_h {
        width: 150px;
        height: 80px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Ô tìm kiếm */
    .search-box {
        position: relative;
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border-radius: 50px;
        padding: 5px 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .search-box:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        width: 220px;
        padding: 5px 10px;
        font-size: 14px;
    }
    .search-box input::placeholder {
        color: #aaa;
        font-style: italic;
    }
    .search-box .btn-search {
        border: none;
        background: #007bff; /* Nền xanh hiện đại */
        color: #fff;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    .search-box .btn-search:hover {
        background: #0056b3;
    }

    /* Số lượng badge */
    .nav-shop__circle {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: #fff;
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 50%;
    }

    /* Mega menu */
    .mega-menu {
        position: absolute;
        display: none;
        top: 0;
        left: 100%; /* xổ ngang, đổi thành left:0; top:100% nếu muốn xổ xuống */
        min-width: 700px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        padding: 20px;
        z-index: 1000; /* tránh bị che/tràn */
    }

    /* Hiện menu khi hover submenu */
    .dropdown-submenu {
        position: relative;
    }
    .dropdown-submenu:hover > .mega-menu {
        display: block;
    }

    /* Item trong mega menu */
    .mega-menu .dropdown-item {
        font-size: 13px;
        padding: 5px 0;
        display: block;
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Dropdown cấp 1 */
    .nav-item.submenu:hover > .dropdown-menu {
        display: block;
    }

    /* Ẩn caret */
    .dropdown-toggle::after {
        display: none !important;
    }
    /* Navbar trong suốt */

/* Khi cuộn xuống => đổi thành nền trắng mờ */
.transparent-navbar.scrolled {
    background: rgba(255, 255, 255, 0.95) !important;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}


.transparent-navbar.scrolled .nav-link {
    color: #333; /* chữ đen khi cuộn xuống */
}
.transparent-navbar .nav-link:hover {
    color: #ff6b6b;
}


</style>

<script>
    window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".transparent-navbar");
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});

$(document).ready(function(){
    let typingTimer;

    function showSpinner() { $('#loading-spinner').show(); }
    function hideSpinner() { $('#loading-spinner').hide(); }

    // --- SEARCH SUGGESTIONS ---
    $("#search-input").on("keyup input", function(){
        clearTimeout(typingTimer);
        let keyword = $(this).val().trim();

        if(keyword.length < 2){
            $("#search-suggestions").hide();
            return;
        }

        typingTimer = setTimeout(() => {
            $.ajax({
                url: "{{ route('products.search') }}",
                type: "GET",
                data: { keyword: keyword },
                beforeSend: function(){
                    $("#search-suggestions").html('<div class="p-2 text-muted">Đang tìm...</div>').show();
                },
                success: function(res){
                    let box = $("#search-suggestions");
                    box.empty();

                    if(Array.isArray(res) && res.length > 0){
                        res.forEach(product => {
                            box.append(`
                                <a href="/products/${product.id}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <img src="${product.image}" alt="${product.product_name}" style="width:40px; height:40px; object-fit:cover; margin-right:10px;">
                                    <span>${product.product_name}</span>
                                </a>
                            `);
                        });
                        box.show();
                    } else {
                        box.html('<div class="p-2 text-muted">Không tìm thấy sản phẩm</div>').show();
                    }
                },
                error: function(){
                    $("#search-suggestions").html('<div class="p-2 text-danger">Lỗi khi tìm kiếm</div>').show();
                }
            });
        }, 300);
    });

    $(document).click(function(e){
        if(!$(e.target).closest('#search-input, #search-suggestions').length){
            $("#search-suggestions").hide();
        }
    });

    // --- LOAD MORE ---
    $("#load-more").on("click", function(){
        let btn = $(this);
        let page = parseInt(btn.data("page")) + 1;
        let categoryId = {{ isset($category) ? $category->id : 'null' }};
        let url = categoryId ? `/products/category/${categoryId}` : "{{ route('products.filter') }}";

        $.ajax({
            url: url,
            type: "GET",
            data: { page: page },
            beforeSend: showSpinner,
            success: function(res){
                if(res.trim() === ''){
                    btn.hide();
                } else {
                    $("#product-list").append(res);
                    btn.data("page", page);
                }
            },
            complete: hideSpinner,
            error: function(){
                alert("Có lỗi xảy ra!");
            }
        });
    });
});
</script>
