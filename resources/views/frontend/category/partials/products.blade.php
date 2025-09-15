@foreach ($products as $product)
  @php
    $avgRating = (float) ($product->reviews_avg_rating ?? 0);
    $rating    = (int) round($avgRating);

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
              style="background: linear-gradient(135deg,#007bff,#00c6ff); color:#fff; font-size:0.9rem; padding:0.35rem 0.6rem;z-index: 10;">
          -{{ $percentOff }}%
        </span>
      @endif

      {{-- Ảnh sản phẩm --}}
      <div class="card-product__img position-relative overflow-hidden">
        <img class="card-img-top"
             src="{{ asset('storage/uploads/products/'.$product->image) }}"
             alt="{{ $product->product_name }}"
             style="height:220px;object-fit:contain;transition: transform .3s;">
        <ul class="card-product__imgOverlay list-unstyled d-flex justify-content-center gap-2 position-absolute top-50 start-50 translate-middle opacity-0 transition-icons">
          <li><button class="btn btn-primary rounded-circle shadow-sm"><i class="ti-search"></i></button></li>
          <li><button class="btn btn-primary rounded-circle shadow-sm"><i class="ti-shopping-cart"></i></button></li>
          <li><button class="btn btn-primary rounded-circle shadow-sm"><i class="ti-heart"></i></button></li>
        </ul>
      </div>

      {{-- Thông tin sản phẩm --}}
      <div class="card-body text-center">
        <p class="text-muted small mb-1">{{ $product->category->categories_text ?? 'Danh mục' }}</p>
        <h5 class="card-title fw-semibold">
          <a href="/product/{{ $product->id }}" class="text-dark text-decoration-none">
            {{ $product->product_name }}
          </a>
        </h5>

        {{-- Rating --}}
        <div class="mb-2">
          @for ($i = 1; $i <= 5; $i++)
            @if ($i <= $rating) 
              <i class="fas fa-star text-warning"></i>
            @else
              <i class="far fa-star text-warning"></i>
            @endif
          @endfor
          <small class="text-muted">
            @if ($avgRating > 0) ({{ number_format($avgRating,1) }}/5) @else (Chưa có đánh giá) @endif
          </small>
        </div>

        {{-- Giá --}}
        <p class="card-product__price mb-0">
          <span class="fs-5 fw-bold text-danger">
            {{ number_format($discountedPrice, 0, ',', '.') }} ₫
          </span>
          @if ($hasDiscount)
            <span class="text-muted ms-2 text-decoration-line-through small fst-italic" style="text-decoration: line-through;">
              {{ number_format($listPrice, 0, ',', '.') }} ₫
            </span>
          @endif
        </p>
      </div>
    </div>
  </div>
@endforeach
