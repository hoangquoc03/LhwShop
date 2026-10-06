@php
    use Illuminate\Support\Str;

    $products = $screen ?? collect();

    if (!($products instanceof \Illuminate\Support\Collection)) {
        $products = collect($products);
    }

    $wrapperId = $wrapperId ?? 'products-' . Str::slug($title ?? 'san-pham') . '-' . uniqid();
@endphp

<section class="product-section section-margin calc-60px mt-4 pt-4">

    <div class="container position-relative">

        {{-- ================= HEADER ================= --}}
        <div class="product-section-header">

            <div>
                <span class="product-section-subtitle">
                    LWSHOP COLLECTION
                </span>

                <h2 class="product-section-title">
                    {{ $title ?? 'SẢN PHẨM' }}
                </h2>
            </div>

            @if ($products->count() > 0)
                <div class="product-section-count">
                    {{ $products->count() }} sản phẩm
                </div>
            @endif

        </div>


        {{-- ================= PRODUCT LIST ================= --}}

        @if ($products->count() > 0)

            <div class="product-slider-wrapper">

                {{-- Previous --}}
                <button type="button" class="product-nav product-nav-prev" data-target="{{ $wrapperId }}"
                    aria-label="Sản phẩm trước">

                    <span>‹</span>

                </button>


                {{-- Products --}}
                <div class="products-container featured-products-wrapper" id="{{ $wrapperId }}">

                    @foreach ($products as $product)
                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | RATING
                            |--------------------------------------------------------------------------
                            */

                            $avgRating = (float) ($product->reviews_avg_rating ?? 0);

                            $rating = (int) round($avgRating);

                            /*
                            |--------------------------------------------------------------------------
                            | PRICE
                            |--------------------------------------------------------------------------
                            */

                            $discount = $product->discount ?? null;

                            $listPrice = (float) ($product->list_price ?? 0);

                            $discountedPrice = $listPrice;

                            $percentOff = 0;

                            $hasDiscount = false;

                            if ($discount && $listPrice > 0) {
                                $discountAmount = (float) ($discount->discount_amount ?? 0);

                                $isFixed = (int) ($discount->is_fixed ?? 0);

                                // is_fixed = 0 => giảm %
                                if ($isFixed === 0 && $discountAmount > 0) {
                                    $percentOff = min(100, round($discountAmount));

                                    $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
                                }

                                // is_fixed = 1 => giảm tiền
                                elseif ($isFixed === 1 && $discountAmount > 0) {
                                    $discountedPrice = max(0, $listPrice - $discountAmount);

                                    $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
                                }

                                $hasDiscount = $discountedPrice < $listPrice;
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | IMAGE
                            |--------------------------------------------------------------------------
                            */

                            $image = $product->image ?? '';

                            $imageUrl = Str::startsWith($image, ['http://', 'https://'])
                                ? $image
                                : asset('storage/uploads/products/' . $image);

                        @endphp


                        {{-- ================= CARD ================= --}}

                        <article class="product-card">

                            {{-- Discount badge --}}
                            @if ($hasDiscount && $percentOff > 0)
                                <span class="product-discount-badge">
                                    -{{ $percentOff }}%
                                </span>
                            @endif


                            {{-- IMAGE --}}
                            <div class="product-image-wrapper">

                                <a href="{{ url('/product/' . $product->id) }}">

                                    <img src="{{ $imageUrl }}" alt="{{ $product->product_name }}"
                                        class="product-image" loading="lazy">

                                </a>


                                {{-- ACTION BUTTONS --}}
                                <div class="product-actions">

                                    {{-- View --}}
                                    @if (!Auth::guard('customer')->check())
                                        <a href="{{ route('frontend.register.register') }}" class="product-action-btn"
                                            title="Xem sản phẩm">

                                            <i class="ti-search"></i>

                                        </a>
                                    @else
                                        <a href="{{ url('/product/' . $product->id) }}" class="product-action-btn"
                                            title="Xem sản phẩm">

                                            <i class="ti-search"></i>

                                        </a>
                                    @endif


                                    {{-- Cart --}}
                                    <button type="button" class="product-action-btn add-to-cart"
                                        data-id="{{ $product->id }}" title="Thêm vào giỏ">

                                        <i class="ti-shopping-cart"></i>

                                    </button>


                                    {{-- Favorite --}}
                                    <button type="button" class="product-action-btn btn-favorite"
                                        data-id="{{ $product->id }}" title="Yêu thích">

                                        <i
                                            class="ti-heart
                                            {{ in_array($product->id, session('favorites', [])) ? 'text-primary' : '' }}">
                                        </i>

                                    </button>

                                </div>

                            </div>


                            {{-- PRODUCT INFO --}}
                            <div class="product-info">

                                <h3 class="product-name">

                                    <a href="{{ url('/product/' . $product->id) }}">

                                        {{ $product->product_name }}

                                    </a>

                                </h3>


                                {{-- Rating --}}
                                <div class="product-rating">

                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="
                                            {{ $i <= $rating ? 'fas' : 'far' }}
                                            fa-star
                                        "></i>
                                    @endfor


                                    @if ($avgRating > 0)
                                        <span>
                                            {{ number_format($avgRating, 1) }}
                                        </span>
                                    @endif

                                </div>


                                {{-- PRICE --}}
                                <div class="product-price">

                                    <span class="product-current-price">

                                        {{ number_format($discountedPrice, 0, ',', '.') }}

                                        ₫

                                    </span>


                                    @if ($hasDiscount)
                                        <span class="product-old-price">

                                            {{ number_format($listPrice, 0, ',', '.') }}

                                            ₫

                                        </span>
                                    @endif

                                </div>

                            </div>

                        </article>
                    @endforeach

                </div>


                {{-- Next --}}
                <button type="button" class="product-nav product-nav-next" data-target="{{ $wrapperId }}"
                    aria-label="Sản phẩm tiếp theo">

                    <span>›</span>

                </button>

            </div>
        @else
            <div class="product-empty">

                <div class="product-empty-icon">
                    <i class="ti-shopping-bag"></i>
                </div>

                <h3>Chưa có sản phẩm</h3>

                <p>
                    Hiện chưa có sản phẩm trong danh mục này.
                </p>

            </div>

        @endif

    </div>

</section>


{{-- =========================================================
    STYLE
========================================================= --}}

<style>
    .product-section {
        position: relative;
    }


    /* ================= HEADER ================= */

    .product-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        margin-bottom: 30px;

        padding-bottom: 18px;

        border-bottom: 1px solid #eeeeee;
    }


    .product-section-subtitle {
        display: block;

        margin-bottom: 7px;

        color: #0f3c91;

        font-size: 11px;

        font-weight: 600;

        letter-spacing: 3px;

        text-transform: uppercase;
    }


    .product-section-title {
        margin: 0;

        color: #0a2540;

        font-size: 30px;

        font-weight: 600;

        letter-spacing: -0.5px;
    }


    .product-section-count {
        color: #888;

        font-size: 13px;
    }


    /* ================= SLIDER ================= */

    .product-slider-wrapper {
        position: relative;

        padding: 0 25px;
    }


    .featured-products-wrapper {
        display: grid;

        grid-auto-flow: column;

        grid-template-rows: repeat(2, auto);

        grid-auto-columns: 250px;

        gap: 22px;

        overflow-x: auto;

        padding: 10px 5px 20px;

        scroll-behavior: smooth;

        scroll-snap-type: x mandatory;

        scrollbar-width: none;
    }


    .featured-products-wrapper::-webkit-scrollbar {
        display: none;
    }


    /* ================= CARD ================= */

    .product-card {
        position: relative;

        min-width: 0;

        overflow: hidden;

        background: #ffffff;

        border: 1px solid #eeeeee;

        border-radius: 12px;

        scroll-snap-align: start;

        transition:
            transform .35s ease,
            box-shadow .35s ease,
            border-color .35s ease;
    }


    .product-card:hover {

        transform: translateY(-6px);

        border-color: #e5e5e5;

        box-shadow:
            0 15px 35px rgba(0, 0, 0, .08);
    }


    /* ================= IMAGE ================= */

    .product-image-wrapper {
        position: relative;

        width: 100%;

        height: 280px;

        overflow: hidden;

        background: #f7f7f7;
    }


    .product-image {

        width: 100%;

        height: 100%;

        object-fit: cover;

        display: block;

        transition:
            transform .6s cubic-bezier(.2, .7, .2, 1);
    }


    .product-card:hover .product-image {

        transform: scale(1.06);
    }


    /* ================= DISCOUNT ================= */

    .product-discount-badge {

        position: absolute;

        top: 12px;

        left: 12px;

        z-index: 10;

        padding: 6px 10px;

        color: white;

        background:
            linear-gradient(135deg,
                #0f3c91,
                #1e6bff);

        border-radius: 20px;

        font-size: 11px;

        font-weight: 700;

        letter-spacing: .5px;

        box-shadow:
            0 5px 15px rgba(15, 60, 145, .25);
    }


    /* ================= ACTIONS ================= */

    .product-actions {

        position: absolute;

        left: 50%;

        bottom: 18px;

        z-index: 20;

        display: flex;

        gap: 8px;

        transform:
            translate(-50%, 20px);

        opacity: 0;

        transition:
            opacity .3s ease,
            transform .3s ease;
    }


    .product-card:hover .product-actions {

        opacity: 1;

        transform:
            translate(-50%, 0);
    }


    .product-action-btn {

        width: 38px;

        height: 38px;

        display: flex;

        align-items: center;

        justify-content: center;

        border: none;

        border-radius: 50%;

        background: rgba(255, 255, 255, .96);

        color: #0a2540;

        text-decoration: none;

        cursor: pointer;

        box-shadow:
            0 5px 18px rgba(0, 0, 0, .15);

        transition:
            background .25s ease,
            color .25s ease,
            transform .25s ease;
    }


    .product-action-btn:hover {

        background: #0a2540;

        color: white;

        transform: translateY(-2px);
    }


    .product-action-btn .text-primary {

        color: #0f3c91 !important;
    }


    /* ================= INFO ================= */

    .product-info {

        padding: 17px 16px 20px;

        text-align: center;
    }


    .product-name {

        min-height: 44px;

        margin: 0 0 8px;

        font-size: 15px;

        font-weight: 600;

        line-height: 1.45;
    }


    .product-name a {

        color: #222;

        text-decoration: none;

        transition: color .2s ease;
    }


    .product-name a:hover {

        color: #0f3c91;
    }


    /* ================= RATING ================= */

    .product-rating {

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 2px;

        min-height: 22px;

        margin-bottom: 9px;

        color: #0f3c91;

        font-size: 12px;
    }


    .product-rating span {

        margin-left: 5px;

        color: #888;

        font-size: 11px;
    }


    /* ================= PRICE ================= */

    .product-price {

        display: flex;

        align-items: center;

        justify-content: center;

        flex-wrap: wrap;

        gap: 7px;
    }


    .product-current-price {

        color: #d62828;

        font-size: 17px;

        font-weight: 700;
    }


    .product-old-price {

        color: #999;

        font-size: 12px;

        text-decoration: line-through;

        text-decoration-thickness: 1px;
    }


    /* ================= NAV ================= */

    .product-nav {

        position: absolute;

        top: 50%;

        z-index: 50;

        width: 42px;

        height: 42px;

        display: flex;

        align-items: center;

        justify-content: center;

        padding: 0;

        border: 1px solid #eeeeee;

        border-radius: 50%;

        background: rgba(255, 255, 255, .96);

        color: #0a2540;

        font-size: 28px;

        line-height: 1;

        cursor: pointer;

        transform: translateY(-50%);

        box-shadow:
            0 5px 18px rgba(0, 0, 0, .12);

        transition:
            all .25s ease;
    }


    .product-nav:hover {

        color: white;

        background: #0a2540;

        transform:
            translateY(-50%) scale(1.05);
    }


    .product-nav-prev {

        left: -5px;
    }


    .product-nav-next {

        right: -5px;
    }


    /* ================= EMPTY ================= */

    .product-empty {

        padding: 70px 20px;

        text-align: center;

        border: 1px dashed #dddddd;

        border-radius: 12px;

        color: #777;
    }


    .product-empty-icon {

        margin-bottom: 15px;

        font-size: 35px;

        color: #0f3c91;
    }


    .product-empty h3 {

        margin-bottom: 5px;

        color: #333;

        font-size: 18px;
    }


    .product-empty p {

        margin: 0;

        font-size: 14px;
    }


    /* ================= RESPONSIVE ================= */

    @media (max-width: 991px) {

        .featured-products-wrapper {

            grid-template-rows: repeat(2, auto);

            grid-auto-columns: 220px;

            gap: 16px;
        }

        .product-image-wrapper {

            height: 250px;
        }

    }


    @media (max-width: 575px) {

        .product-section-header {

            align-items: flex-start;

        }

        .product-section-title {

            font-size: 23px;
        }

        .product-section-count {

            display: none;
        }

        .product-slider-wrapper {

            padding: 0;
        }

        .featured-products-wrapper {

            grid-auto-columns: 190px;

            gap: 12px;

            padding-left: 0;

            padding-right: 0;
        }

        .product-image-wrapper {

            height: 220px;
        }

        .product-nav {

            display: none;
        }

        .product-actions {

            opacity: 1;

            transform:
                translate(-50%, 0);
        }

    }
</style>


{{-- =========================================================
    JAVASCRIPT
========================================================= --}}

@once

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* =====================================================
               PRODUCT SLIDER
            ===================================================== */

            document.querySelectorAll('.product-nav').forEach(function(button) {

                button.addEventListener('click', function() {

                    const targetId = this.dataset.target;

                    const container = document.getElementById(targetId);

                    if (!container) {
                        console.warn(
                            'Không tìm thấy product container:',
                            targetId
                        );

                        return;
                    }


                    const card =
                        container.querySelector('.product-card');


                    if (!card) {
                        return;
                    }


                    const gap =
                        parseFloat(
                            getComputedStyle(container).columnGap
                        ) || 20;


                    const scrollAmount =
                        (card.offsetWidth + gap) *
                        2;


                    container.scrollBy({

                        left: this.classList.contains('product-nav-next') ?
                            scrollAmount :
                            -scrollAmount,

                        behavior: 'smooth'

                    });

                });

            });


            /* =====================================================
               ADD TO CART
            ===================================================== */

            if (typeof window.jQuery !== 'undefined') {

                $(document)
                    .off('click.productSection', '.add-to-cart')
                    .on('click.productSection', '.add-to-cart', function(e) {

                        e.preventDefault();

                        e.stopPropagation();


                        const button = $(this);

                        const productId =
                            button.data('id');


                        if (!productId) {
                            return;
                        }


                        button.prop('disabled', true);


                        $.ajax({

                            url: "{{ route('cart.add') }}",

                            type: "POST",

                            data: {

                                _token: "{{ csrf_token() }}",

                                product_id: productId

                            },

                            success: function(res) {

                                if (res.success) {

                                    $('.cart-count')
                                        .text(res.cart_count)
                                        .show();


                                    if (
                                        typeof Toastify !== 'undefined'
                                    ) {

                                        Toastify({

                                            text: "Thêm sản phẩm thành công",

                                            duration: 3000,

                                            gravity: "top",

                                            position: "right",

                                            backgroundColor: "#28a745"

                                        }).showToast();

                                    }

                                }

                            },

                            error: function(xhr) {

                                console.error(
                                    'Add cart error:',
                                    xhr.responseText
                                );

                            },

                            complete: function() {

                                button.prop(
                                    'disabled',
                                    false
                                );

                            }

                        });

                    });


                /* =================================================
                   FAVORITE
                ================================================= */

                $(document)
                    .off('click.productSectionFavorite', '.btn-favorite')
                    .on('click.productSectionFavorite', '.btn-favorite', function(e) {

                        e.preventDefault();

                        e.stopPropagation();


                        const button = $(this);

                        const productId =
                            button.data('id');

                        const icon =
                            button.find('i');


                        if (!productId) {
                            return;
                        }


                        $.ajax({

                            url: "{{ route('favorites.add') }}",

                            type: "POST",

                            data: {

                                _token: "{{ csrf_token() }}",

                                product_id: productId

                            },

                            success: function(res) {

                                if (res.success) {

                                    icon.addClass(
                                        'text-primary'
                                    );


                                    $('#favorite-count')
                                        .text(res.count)
                                        .show();


                                    if (
                                        typeof Toastify !== 'undefined'
                                    ) {

                                        Toastify({

                                            text: "Đã thêm vào yêu thích",

                                            duration: 3000,

                                            gravity: "top",

                                            position: "right",

                                            backgroundColor: "#e91e63"

                                        }).showToast();

                                    }

                                }

                            },

                            error: function(xhr) {

                                console.error(
                                    'Favorite error:',
                                    xhr.responseText
                                );

                            }

                        });

                    });

            }

        });
    </script>
@endonce
