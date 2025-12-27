@php
    $avgRating = (float) ($product->reviews_avg_rating ?? 0);
    $rating = (int) round($avgRating);

    $discount = $product->discount;
    $listPrice = (float) $product->list_price;

    $discountedPrice = $listPrice;
    $percentOff = 0;
    $hasDiscount = false;

    if ($discount && $listPrice > 0) {
        $discountAmount = (float) ($discount->discount_amount ?? 0);
        $isPercent = (int) ($discount->is_fixed ?? 0);

        if ($isPercent === 0 && $discountAmount > 0) {
            $percentOff = min(100, round($discountAmount));
            $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
        } elseif ($isPercent === 1 && $discountAmount > 0) {
            $discountedPrice = max(0, $listPrice - $discountAmount);
            $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
        }

        $hasDiscount = $discountedPrice < $listPrice;
    }
@endphp

<div class="col-md-3 col-sm-6">
    <div class="card card-product border-0 shadow-sm rounded-3 overflow-hidden position-relative h-100">

        {{-- Badge giảm giá --}}
        @if ($hasDiscount && $percentOff > 0)
            <span class="position-absolute top-0 start-0 m-2 badge rounded-pill shadow"
                style="background: linear-gradient(135deg,#0f3c91,#1e6bff); color:#fff; font-size:0.9rem; padding:0.35rem 0.6rem;z-index: 10;">
                -{{ $percentOff }}%
            </span>
        @endif

        {{-- Ảnh sản phẩm --}}
        <div class="card-product__img position-relative overflow-hidden">
            <img src="{{ Str::startsWith($product->image, ['http://', 'https://'])
                ? $product->image
                : asset('storage/uploads/products/' . $product->image) }}"
                alt="{{ $product->product_name }}" style="height:260px;object-fit:cover;transition: transform .3s;">
            <ul
                class="card-product__imgOverlay list-unstyled d-flex justify-content-center gap-2 position-absolute top-50 start-50 translate-middle opacity-0 transition-icons">
                <li>
                    @if (!Auth::guard('customer')->check())
                        <a href="{{ route('frontend.register.register') }}">
                            <button class="btn btn-light rounded-circle shadow-sm">
                                <i class="ti-search"></i>
                            </button>
                        </a>
                    @else
                        <a href="/product/{{ $product->id }}">
                            <button class="btn btn-light rounded-circle shadow-sm">
                                <i class="ti-search"></i>
                            </button>
                        </a>
                    @endif

                </li>



                <li>
                    <button class="btn btn-light rounded-circle shadow-sm add-to-cart" data-id="{{ $product->id }}">
                        <i class="ti-shopping-cart"></i>
                    </button>
                </li>

                <li class="nav-item">
                    <button class="btn btn-light rounded-circle shadow-sm btn-favorite" data-id="{{ $product->id }}"
                        type="button">
                        <i
                            class="ti-heart
            {{ in_array($product->id, session('favorites', [])) ? 'text-primary' : '' }}">
                        </i>
                    </button>
                </li>
            </ul>
        </div>

        {{-- Thông tin sản phẩm --}}
        <div class="card-body text-center">
            <h5 class="card-title fw-semibold">
                <a href="/product/{{ $product->id }}" class="text-dark text-decoration-none">
                    {{ $product->product_name }}
                </a>
            </h5>

            <div class="mb-2 luxury-rating">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star luxury-star"></i>
                @endfor

                <small class="rating-text">
                    @if ($avgRating > 0)
                        ({{ number_format($avgRating, 1) }}/5)
                    @else
                    @endif
                </small>
            </div>

            {{-- Giá --}}
            <p class="card-product__price mb-0">
                <span class="fs-5 fw-bold text-danger">
                    {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                </span>
                @if ($hasDiscount)
                    <span class="text-muted ms-2 text-decoration-line-through small fst-italic "
                        style="text-decoration: line-through;">
                        {{ number_format($listPrice, 0, ',', '.') }} ₫
                    </span>
                @endif
            </p>
        </div>
    </div>
</div>
<style>
    .luxury-star {
        color: #0f3c91;
        text-shadow: 0 1px 2px rgba(15, 60, 145, 0.25);
    }
</style>
