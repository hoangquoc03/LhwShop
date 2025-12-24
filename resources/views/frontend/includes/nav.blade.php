<nav class="navbar navbar-expand-lg  luxury-nav">
    <div class="container-fluid luxury-container">

        <!-- LOGO -->
        <a class="navbar-brand luxury-logo" href="{{ route('frontend.home.index') }}">
            <span>LW</span>Shop
        </a>

        <!-- Nút thu gọn -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="ti-menu"></i>
        </button>

        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <!-- Menu chính -->
            <ul class="navbar-nav luxury-menu ml-4">
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
                                            @foreach ($item->suppliers as $s)
                                                <a class="dropdown-item"
                                                    href="{{ route('products.filter', [
                                                        'category_id' => $item->id,
                                                        'supplier_id' => $s->id,
                                                    ]) }}">
                                                    {{ $s->supplier_text }}
                                                </a>
                                            @endforeach


                                        </div>

                                        {{-- Cột 2: Mức giá --}}
                                        <div class="col-md-4">
                                            <h6 class="dropdown-header">Mức giá</h6>
                                            <a class="dropdown-item"
                                                href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 1]) }}">Dưới
                                                20 triệu</a>
                                            <a class="dropdown-item"
                                                href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 2]) }}">20
                                                - 40 triệu</a>
                                            <a class="dropdown-item"
                                                href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 3]) }}">40
                                                - 70 triệu</a>
                                            <a class="dropdown-item"
                                                href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 4]) }}">70
                                                - 80 triệu</a>
                                            <a class="dropdown-item"
                                                href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 5]) }}">80
                                                - 100 triệu</a>
                                            <a class="dropdown-item"
                                                href="{{ route('products.filter', ['category_id' => $item->id, 'price_range' => 6]) }}">Trên
                                                100 triệu</a>
                                        </div>

                                        {{-- Cột 3: Sản phẩm nổi bật / mới --}}
                                        <div class="col-md-4">
                                            <h6 class="dropdown-header">Sản phẩm</h6>
                                            @foreach ($item->products->sortByDesc('created_at')->take(6) as $product)
                                                <a class="dropdown-item d-flex justify-content-between align-items-center"
                                                    href="#">
                                                    <span class="text-truncate" style="max-width: 120px;">
                                                        {{ $product->product_name }}
                                                    </span>
                                                    <span>
                                                        @if ($product->is_featured)
                                                            <span class="badge badge-success ml-1">Nổi bật</span>
                                                        @endif
                                                        @if ($product->is_new)
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
            <ul class="navbar-nav nav-right ml-auto align-items-center">
                <!-- Ô tìm kiếm -->
                <li class="nav-item position-relative luxury-search">
                    <form action="{{ route('products.filter') }}" method="GET" class="lux-search">
                        <i class="ti-search lux-search__icon"></i>
                        <input type="text" id="search-input" name="query" placeholder="Tìm kiếm sản phẩm cao cấp…"
                            autocomplete="off">
                        <div id="search-suggestions" class="lux-suggestions"></div>
                    </form>
                </li>




                <!-- Yêu thích -->
                <li class="nav-item mr-3">
                    <a href="{{ route('favorites.index') }}" class="btn btn-light position-relative">

                        <i class="ti-heart"></i>

                        <span id="favorite-count" class="nav-shop__circle"
                            style="{{ count(session('favorites', [])) > 0 ? '' : 'display:none' }}">
                            {{ count(session('favorites', [])) }}
                        </span>

                    </a>
                </li>




                <li class="nav-item mr-3">
                    <a href="{{ route('cart.index') }}" class="btn btn-light position-relative">
                        <i class="ti-shopping-cart"></i>
                        @php
                            if (Auth::guard('customer')->check()) {
                                $cartCount = \App\Models\ShopCart::where(
                                    'customer_id',
                                    Auth::guard('customer')->id(),
                                )->sum('quantity');
                            } else {
                                $cartCount = collect(session('cart', []))->sum('quantity');
                            }
                        @endphp

                        <span class="nav-shop__circle cart-count" style="{{ $cartCount > 0 ? '' : 'display:none' }}">
                            {{ $cartCount }}
                        </span>

                    </a>
                </li>


                @if (Auth::guard('customer')->check())
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <i class="ti-user"></i> {{ Auth::guard('customer')->user()->first_name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right p-3" style="width: 350px;">

                            {{-- Hồ sơ và đăng xuất --}}
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <a href="#" class="btn btn-sm btn-primary">Hồ sơ</a>

                                <a href="#" class="btn btn-sm btn-danger"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Đăng xuất
                                </a>

                                <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>


                            {{-- Tabs thông báo --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Thông báo</strong>
                                <a href="#" class="small">Đánh dấu đã đọc tất cả</a>
                            </div>
                            <ul class="nav nav-tabs nav-fill mb-3" id="notificationTabs" role="tablist"
                                style="border-bottom: 2px solid #dee2e6; border-radius: 5px; overflow: hidden;">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all"
                                        role="tab" aria-controls="all" aria-selected="true"
                                        style="border: none; background-color: #f1f3f5; color: #495057; padding: 8px 12px;">
                                        Tất cả
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="order-tab" data-toggle="tab" href="#order"
                                        role="tab" aria-controls="order" aria-selected="false"
                                        style="border: none; background-color: #f1f3f5; color: #495057; padding: 8px 12px;">
                                        Đơn hàng
                                    </a>
                                </li>
                            </ul>

                            {{-- Nội dung tab --}}
                            <div class="tab-content" id="notificationTabsContent">
                                <div class="tab-pane fade show active" id="all" role="tabpanel">
                                    @php
                                        $recentOrders = \App\Models\ShopOrder::where(
                                            'customer_id',
                                            Auth::guard('customer')->id(),
                                        )
                                            ->latest()
                                            ->take(5)
                                            ->get();
                                    @endphp
                                    @foreach ($recentOrders as $recent)
                                        <div class="notification-item d-flex align-items-start mb-2 p-2"
                                            style="border-radius: 5px; background: {{ $loop->first ? '#e8f0fe' : '#f9f9f9' }}">
                                            <div class="icon mr-2">
                                                @if ($recent->status == 'delivered')
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
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($recent->order_date)->diffForHumans() }}</small>
                                                <div>
                                                    <a href="{{ route('orders.success', $recent->id) }}"
                                                        class="small">Xem chi tiết</a>
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
                            <i class="ti-pencil-alt"></i> Đăng nhập
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<style>
    /* .nav-right {
        padding-right: 45px;
    } */

    /* ================= GLOBAL NAV LINK ================= */


    .luxury-nav .nav-link {
        color: #111;
        font-weight: 500;
        transition: color .25s ease;
    }

    .luxury-nav .nav-link:hover {
        color: #0f3c91;
    }

    .luxury-nav .nav-item.active .nav-link {
        color: #0f3c91;
        font-weight: 600;
    }

    /* ================= LOGO ================= */
    .luxury-logo {
        font-family: 'Playfair Display', 'Didot', serif;
        font-size: 30px;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #111;
        padding-left: 45px;
        text-decoration: none;
    }

    .luxury-logo span {
        font-family: 'Montserrat', sans-serif;
        font-weight: 300;
        color: #0f3c91;
    }

    .luxury-logo:hover {
        text-decoration: none;
    }

    /* ================= NAVBAR ================= */
    .luxury-nav {
        background: #f1f1f1;
        padding: 14px 0;
        box-shadow: 0 6px 30px rgba(0, 0, 0, .06);
        transition: background .3s ease, box-shadow .3s ease;
    }

    .luxury-nav.scrolled {
        background: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .12);
    }

    /* ================= MENU ================= */
    .luxury-menu {
        display: flex;
        align-items: center;
    }

    .luxury-menu .nav-item {
        margin-right: 24px;
    }

    /* ===== LUXURY SEARCH ===== */
    .luxury-search {
        margin-right: 20px;
    }

    /* Box */
    .lux-search {
        position: relative;
        display: flex;
        align-items: center;

        width: 260px;
        height: 40px;

        background: #ffffff;
        border: 1px solid #e6e6e6;
        border-radius: 4px;

        padding-left: 40px;
        padding-right: 14px;

        transition: all 0.25s ease;
    }

    /* Hover & Focus */
    .lux-search:hover {
        border-color: #bfbfbf;
    }

    .lux-search:focus-within {
        border-color: #111;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    }

    /* Icon */
    .lux-search__icon {
        position: absolute;
        left: 14px;

        font-size: 14px;
        color: #999;

        pointer-events: none;
        transition: color 0.25s ease;
    }

    .lux-search:focus-within .lux-search__icon {
        color: #111;
    }

    /* Input */
    .lux-search input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;

        font-size: 13px;
        font-weight: 400;
        letter-spacing: 0.4px;
        color: #111;
    }

    /* Placeholder */
    .lux-search input::placeholder {
        color: #aaa;
    }

    /* ===== SUGGESTIONS ===== */
    .lux-suggestions {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;

        background: #ffffff;
        border: 1px solid #eee;

        max-height: 320px;
        overflow-y: auto;

        display: none;
        z-index: 999;

        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    /* Item */
    .lux-suggestions a {
        display: flex;
        align-items: center;

        padding: 10px 14px;
        font-size: 13px;
        color: #111;
        text-decoration: none;

        transition: background 0.2s ease;
    }

    .lux-suggestions a:hover {
        background: #f6f6f6;
    }

    .lux-suggestions img {
        width: 42px;
        height: 42px;
        object-fit: cover;
        margin-right: 10px;
    }

    /* ================= SEARCH SUGGEST ================= */
    .suggestions-box {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #eee;
        max-height: 320px;
        overflow-y: auto;
        display: none;
        z-index: 1000;
        box-shadow: 0 8px 30px rgba(0, 0, 0, .08);
    }

    .suggestions-box a {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        font-size: 13px;
        color: #111;
        text-decoration: none;
    }

    .suggestions-box a:hover {
        background: #f6f6f6;
    }

    .suggestions-box img {
        width: 42px;
        height: 42px;
        object-fit: cover;
        margin-right: 10px;
    }

    /* ================= ICON BADGE ================= */
    .nav-shop__circle {
        position: absolute;
        top: -6px;
        right: -6px;

        min-width: 18px;
        height: 18px;
        padding: 0 4px;

        background: #0f3c91;
        color: #fff;

        font-size: 11px;
        font-weight: 500;

        border-radius: 999px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }



    /* ================= DROPDOWN ================= */
    .dropdown-toggle::after {
        display: none !important;
    }

    .nav-item.submenu:hover>.dropdown-menu {
        display: block;
    }

    /* ================= MEGA MENU ================= */
    .mega-menu {
        position: absolute;
        top: 0;
        left: 100%;
        min-width: 700px;
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        display: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .1);
        z-index: 1000;
    }

    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu:hover>.mega-menu {
        display: block;
    }

    .mega-menu .dropdown-item {
        font-size: 13px;
        padding: 5px 0;
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    function updateCartCount(count) {
        const cartBadge = document.querySelector('.cart-count');
        if (!cartBadge) return;

        if (count > 0) {
            cartBadge.innerText = count;
            cartBadge.style.display = 'inline-flex';
        } else {
            cartBadge.innerText = '';
            cartBadge.style.display = 'none';
        }
    }


    window.addEventListener("scroll", function() {
        const navbar = document.querySelector(".transparent-navbar");
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });

    $(document).ready(function() {
        let typingTimer;

        function showSpinner() {
            $('#loading-spinner').show();
        }

        function hideSpinner() {
            $('#loading-spinner').hide();
        }

        // --- SEARCH SUGGESTIONS ---
        $("#search-input").on("keyup input", function() {
            clearTimeout(typingTimer);
            let keyword = $(this).val().trim();

            if (keyword.length < 2) {
                $("#search-suggestions").hide();
                return;
            }

            typingTimer = setTimeout(() => {
                $.ajax({
                    url: "{{ route('products.search') }}",
                    type: "GET",
                    data: {
                        keyword: keyword
                    },
                    beforeSend: function() {
                        $("#search-suggestions").html(
                                '<div class="p-2 text-muted">Đang tìm...</div>')
                            .show();
                    },
                    success: function(res) {
                        let box = $("#search-suggestions");
                        box.empty();

                        if (Array.isArray(res) && res.length > 0) {
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
                            box.html(
                                '<div class="p-2 text-muted">Không tìm thấy sản phẩm</div>'
                            ).show();
                        }
                    },
                    error: function() {
                        $("#search-suggestions").html(
                            '<div class="p-2 text-danger">Lỗi khi tìm kiếm</div>'
                        ).show();
                    }
                });
            }, 300);
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('#search-input, #search-suggestions').length) {
                $("#search-suggestions").hide();
            }
        });

        // --- LOAD MORE ---
        $("#load-more").on("click", function() {
            let btn = $(this);
            let page = parseInt(btn.data("page")) + 1;
            let categoryId = {{ isset($category) ? $category->id : 'null' }};
            let url = categoryId ? `/products/category/${categoryId}` :
                "{{ route('products.filter') }}";

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    page: page
                },
                beforeSend: showSpinner,
                success: function(res) {
                    if (res.trim() === '') {
                        btn.hide();
                    } else {
                        $("#product-list").append(res);
                        btn.data("page", page);
                    }
                },
                complete: hideSpinner,
                error: function() {
                    alert("Có lỗi xảy ra!");
                }
            });
        });
    });
</script>
<script>
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('.luxury-nav');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
</script>
