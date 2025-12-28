@extends('frontend.master')
@section('title')
    {{ $product->product_name }}
@endsection
@php
    $hasSize = $product->variants->whereNotNull('size')->where('size', '!=', '')->count() > 0;
    $colors = $product->variants->groupBy('color');
@endphp
{{-- Star Rating & Review Count --}}
@php
    $reviewsCount = $product->reviews->count();
    $avgRating = $reviewsCount ? $product->reviews->avg('rating') : 0;
    $rating = round($avgRating);

    $listPrice = (float) $product->list_price;
    $discount = $product->discount;
    $discountedPrice = $listPrice;
    $percentOff = 0;
    $hasDiscount = false;

    if ($discount && $listPrice > 0) {
        $discountAmount = (float) $discount->discount_amount;
        $isFixed = (int) $discount->is_fixed;

        if ($isFixed === 0) {
            // giảm theo %
            $percentOff = min(100, round($discountAmount));
            $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
        } else {
            // giảm theo số tiền
            $discountedPrice = max(0, $listPrice - $discountAmount);
            $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
        }

        $hasDiscount = $discountedPrice < $listPrice;
    }
@endphp

@section('page-style')
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .luxury-desc {
            color: #555;
            line-height: 1.6;
            margin-bottom: 25px;
            width: 70%;
        }

        .luxury-title-product {
            color: #0a2540;
            /* fallback */
            background: linear-gradient(120deg,
                    #0a2540 0%,
                    #0f3c91 35%,
                    #1e6bff 55%,
                    #6aa7ff 100%);
            background-size: 200% 200%;
            animation: luxuryGradient 6s ease infinite;

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .luxury-discount {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 999;

            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;

            color: #fff;
            background: linear-gradient(135deg, #0f3c91, #1e6bff);
            border-radius: 999px;

            box-shadow: 0 10px 30px rgba(30, 107, 255, 0.35);
        }

        .old-price {
            color: #999;
            font-size: 0.85rem;
            position: relative;
        }

        .old-price::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            height: 1.5px;
            background: #999;
        }

        .luxury-price {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            font-size: 26px;
        }

        /* Ảnh full width hiện đại */
        .banner-img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            border-radius: 20px;
            transition: transform 6s ease;
        }

        .swiper-slide-active .banner-img {
            transform: scale(1.05);
            /* Zoom nhẹ */
        }

        /* Overlay gradient đẹp */
        .banner-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 40px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0));
            border-radius: 0 0 20px 20px;
            color: white;
        }

        .banner-overlay h2 {
            font-size: 2.2rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        /* Nút CTA gradient */
        .btn-gradient {
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #007bff, #00c6ff);
            transform: translateY(-2px);
        }

        /* Navigation buttons */
        .swiper-button-next,
        .swiper-button-prev {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: #333;
            transition: all 0.3s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: #fff;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 20px;
            font-weight: bold;
        }

        /* Hiệu ứng hover scale cho item */
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Animation cho button */
        .animate-btn {
            transition: all 0.3s ease;
        }

        .animate-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Hiệu ứng cho ảnh */
        .cart-img {
            transition: transform 0.4s ease;
        }

        .cart-item:hover .cart-img {
            transform: rotate(-3deg) scale(1.05);
        }

        /* Nút xóa sản phẩm */
        .btn-remove {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #dc3545;
            background: #fff;
            color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 14px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            /* Bắt buộc để ripple không tràn ra ngoài */
        }

        .btn-remove:hover {
            background: #dc3545;
            color: #fff;
            transform: rotate(90deg) scale(1.1);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        /* Hiệu ứng ripple */
        .btn-remove .ripple-effect {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            background: rgba(255, 255, 255, 0.6);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
    <div class="container my-5" style="margin-top: 20px">
        <div class="row g-4" style="margin-top: 20px">

            {{-- Breadcrumb --}}
            <div class="col-12" style="margin-top: 80px">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home.index') }}"
                                class="text-decoration-none text-muted">Trang chủ</a></li>
                        @if ($product->category?->parent?->parent)
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.byCategory', $product->category->parent->parent->id) }}"
                                    class="text-decoration-none text-muted">
                                    {{ $product->category->parent->parent->categories_text }}
                                </a>
                            </li>
                        @endif
                        @if ($product->category?->parent)
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.byCategory', $product->category->parent->id) }}"
                                    class="text-decoration-none text-muted">
                                    {{ $product->category->parent->categories_text }}
                                </a>
                            </li>
                        @endif
                        @if ($product->category)
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.byCategory', $product->category->id) }}"
                                    class="text-decoration-none text-muted">
                                    {{ $product->category->categories_text }}
                                </a>
                            </li>
                        @endif
                        @if ($product->supplier)
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.byCategory', $product->category->id) }}"
                                    class="text-decoration-none text-muted">
                                    {{ $product->supplier->supplier_text }}
                                </a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active text-truncate fw-semibold text-dark" aria-current="page"
                            style="max-width:300px;">
                            {{ $product->product_name }}
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Product Image Gallery --}}
            <div class="col-lg-6">
                <div class="product-gallery">
                    <div class="main-image-display position-relative mb-3 rounded-4 overflow-hidden shadow-sm">

                        <img id="mainProductImage"
                            src="{{ Str::startsWith($product->image, ['http://', 'https://'])
                                ? $product->image
                                : asset('storage/uploads/products/' . $product->image) }}"
                            alt="{{ $product->product_name }}"
                            style="height:260px;object-fit:cover;transition: transform .3s;">
                        @if ($hasDiscount && $percentOff > 0)
                            <span class="luxury-discount">
                                -{{ $percentOff }}%
                            </span>
                        @endif
                    </div>

                    {{-- Thumbnails --}}
                    <div class="d-flex gap-2 flex-wrap justify-content-center justify-content-lg-start product-thumbnails">

                        <img src="{{ Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : asset('storage/uploads/products/' . $product->image) }}"
                            alt="{{ $product->product_name }}" class="img-thumbnail thumb-image active">

                        <div class="d-flex gap-2 flex-wrap mt-3">
                            @foreach ($product->images as $img)
                                @if ($img->image)
                                    @php
                                        $imageUrl = Str::startsWith($img->image, ['http://', 'https://'])
                                            ? $img->image
                                            : asset('storage/uploads/products/' . $img->image);
                                    @endphp

                                    <img src="{{ $imageUrl }}" data-image="{{ $imageUrl }}"
                                        alt="{{ $product->product_name }}" class="img-thumbnail thumb-image"
                                        style="width:80px;height:80px;object-fit:cover;cursor:pointer">
                                @endif
                            @endforeach
                        </div>


                    </div>
                </div>
            </div>

            {{-- Product Details --}}
            <div class="col-lg-6 d-flex flex-column">
                <div class="product-info-wrapper">
                    <h1 class="fw-bold mb-2 text-dark luxury-title-product">{{ $product->product_name }}</h1>

                    <div class="d-flex align-items-baseline mb-3">
                        <span class="fs-3 fw-bold text-danger me-2 product-price"></span>
                        <span class="text-muted text-decoration-line-through small fst-italic original-price"
                            style="text-decoration-thickness: 2px; text-decoration-color: #6c757d; display:none;text-decoration: line-through;"></span>
                    </div>

                    <div class="mb-2 luxury-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star luxury-star"></i>
                        @endfor

                        <small class="rating-text">
                            @if ($avgRating > 0)
                                ({{ number_format($avgRating, 1) }}/5)
                            @else
                                (Chưa có đánh giá)
                            @endif
                        </small>
                    </div>

                    <hr class="my-4">

                    <p class="luxury-desc text-gray-600 leading-relaxed line-clamp-3">

                        {{ $product->short_description }}
                    </p>
                    <div class="luxury-product">
                        <p class="card-product__price mb-0 luxury-price">
                            <span class="fs-5 fw-bold text-danger">
                                {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                            </span>

                            @if ($hasDiscount)
                                <span class=" old-price text-muted ms-2 text-decoration-line-through small fst-italic">
                                    {{ number_format($listPrice, 0, ',', '.') }} ₫
                                </span>
                            @endif
                        </p>
                    </div>
                    @if ($product->variants->count())


                        <div class="mb-4">
                            <label class="fw-semibold d-block mb-2">Màu sắc</label>

                            <div class="d-flex gap-3 flex-wrap">
                                @foreach ($colors as $color => $items)
                                    @php $firstVariant = $items->first(); @endphp

                                    <div class="color-option selectable" data-color="{{ $color }}"
                                        data-image="{{ $firstVariant->image }}" data-variant-id="{{ $firstVariant->id }}"
                                        data-price="{{ $firstVariant->price }}" role="button">

                                        <img src="{{ $firstVariant->image }}" class="rounded border variant-thumb"
                                            style="width:164px;height:164px;object-fit:cover;cursor:pointer">

                                        <div class="small mt-1 text-center">{{ $color }}</div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        @if ($hasSize)
                            <div class="mb-4">
                                <label class="fw-semibold d-block mb-2">Size</label>

                                <div class="d-flex gap-2 flex-wrap" id="sizeGrid">
                                    @foreach ($product->variants as $variant)
                                        <button type="button" class="btn btn-outline-dark size-option selectable"
                                            data-id="{{ $variant->id }}" data-color="{{ $variant->color }}"
                                            data-price="{{ $variant->price }}" @disabled($variant->stock_quantity <= 0)
                                            style="display:none">
                                            {{ $variant->size }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <input type="hidden" name="variant_id" id="selectedVariantId">
                    @endif
                    <script>
                        const hasSize = @json($hasSize);

                        document.querySelectorAll('.color-option').forEach(colorEl => {
                            colorEl.addEventListener('click', () => {
                                const color = colorEl.dataset.color;
                                const image = colorEl.dataset.image;
                                const variantId = colorEl.dataset.variantId;
                                const price = colorEl.dataset.price;

                                // active màu
                                document.querySelectorAll('.color-option').forEach(c => c.classList.remove('active'));
                                colorEl.classList.add('active');

                                // đổi ảnh
                                const mainImg = document.getElementById('mainProductImage');
                                if (mainImg) mainImg.src = image;

                                if (!hasSize) {
                                    // 👉 KHÔNG CÓ SIZE → chọn luôn variant
                                    document.getElementById('selectedVariantId').value = variantId;

                                    const priceBox = document.getElementById('productPrice');
                                    if (priceBox) {
                                        priceBox.innerText =
                                            new Intl.NumberFormat('vi-VN').format(price) + 'đ';
                                    }
                                    return;
                                }

                                // 👉 CÓ SIZE → show size theo màu
                                document.querySelectorAll('.size-option').forEach(btn => {
                                    btn.style.display = btn.dataset.color === color ? 'inline-block' : 'none';
                                    btn.classList.remove('active');
                                });
                            });
                        });

                        document.querySelectorAll('.size-option').forEach(btn => {
                            btn.addEventListener('click', () => {
                                document.querySelectorAll('.size-option').forEach(b => b.classList.remove('active'));
                                btn.classList.add('active');

                                document.getElementById('selectedVariantId').value = btn.dataset.id;

                                const priceBox = document.getElementById('productPrice');
                                if (priceBox) {
                                    priceBox.innerText =
                                        new Intl.NumberFormat('vi-VN').format(btn.dataset.price) + 'đ';
                                }
                            });
                        });
                    </script>
                    <script>
                        const mainImage = document.getElementById('mainProductImage');

                        /* CLICK ẢNH MÀU (VARIANT) */
                        document.querySelectorAll('.color-option img').forEach(img => {
                            img.addEventListener('click', () => {
                                const image = img.closest('.color-option').dataset.image;
                                if (mainImage && image) {
                                    mainImage.src = image;
                                }

                                // active UI
                                document.querySelectorAll('.variant-thumb').forEach(i => i.classList.remove('active'));
                                img.classList.add('active');
                            });
                        });

                        /* CLICK ẢNH PHỤ (GALLERY) */
                        document.querySelectorAll('.thumb-image').forEach(thumb => {
                            thumb.addEventListener('click', () => {
                                const image = thumb.dataset.image || thumb.src;
                                if (mainImage && image) {
                                    mainImage.src = image;
                                }

                                document.querySelectorAll('.thumb-image').forEach(t => t.classList.remove('active'));
                                thumb.classList.add('active');
                            });
                        });
                    </script>


                    {{-- Script chọn box --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const boxes = document.querySelectorAll('.variant-box');
                            const hiddenInput = document.getElementById('selectedVariantId');

                            boxes.forEach(box => {
                                box.addEventListener('click', function() {
                                    // Bỏ chọn các box khác
                                    boxes.forEach(b => b.classList.remove('border-primary', 'shadow'));
                                    // Chọn box hiện tại
                                    this.classList.add('border-primary', 'shadow');
                                    hiddenInput.value = this.dataset.id;
                                });
                            });
                        });
                    </script>




                    {{-- Quantity Control --}}
                    <div class="mb-4">
                        <label for="quantityInput" class="form-label fw-semibold text-dark">Số lượng:</label>
                        <div class="input-group quantity-control" style="width: 150px;">
                            <button class="btn btn-outline-secondary border-end-0" type="button" id="minusBtn">-</button>
                            <input type="text" class="form-control text-center border-start-0 border-end-0"
                                value="1" id="quantityInput" aria-label="Số lượng" readonly>
                            <button class="btn btn-outline-secondary border-start-0" type="button"
                                id="plusBtn">+</button>
                        </div>
                    </div>
                </div>

                {{-- Add to Cart Button --}}
                <button type="button" class="btn btn-primary btn-lg w-100 mt-auto py-3 add-to-cart"
                    data-id="{{ $product->id }}">
                    <i class="fas fa-cart-plus me-2"></i> Thêm vào giỏ hàng
                </button>
            </div>


            {{-- Product Tabs (Description & Reviews) --}}
            <div class="col-12 mt-5">
                <ul class="nav nav-tabs nav-fill flex-column flex-sm-row mb-4" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-uppercase" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button" role="tab" aria-controls="description"
                            aria-selected="true">Mô tả chi tiết</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-uppercase" id="reviews-tab" data-bs-toggle="tab"
                            data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews"
                            aria-selected="false">Đánh giá ({{ $reviewsCount }})</button>
                    </li>
                </ul>
                <div class="tab-content border-top pt-4" id="productTabsContent">
                    <ul class="list-group list-group-flush">
                        @foreach (preg_split("/\r\n|\n|\r/", $product->description) as $item)
                            @php
                                [$label, $value] = array_pad(explode(':', $item, 2), 2, null);
                            @endphp

                            <div class="row py-1">
                                <div class="col-4 fw-semibold">{{ $label }}</div>
                                <div class="col-8">{{ $value }}</div>
                            </div>
                        @endforeach

                    </ul>





                    {{-- Reviews Tab --}}
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="reviews-list">
                            @forelse($product->reviews as $review)
                                <div class="card mb-3 shadow-sm border-0 review-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="card-title mb-0 fw-bold text-dark">
                                                {{ $review->user->name ?? 'Khách' }}</h6>
                                            <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        <div class="text-warning mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else<i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="card-text text-secondary">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info text-center py-4" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> Chưa có đánh giá nào cho sản phẩm này. Hãy là
                                    người đầu tiên!
                                </div>
                            @endforelse
                        </div>

                        {{-- Review Form --}}
                        <div class="mt-5 p-4 border rounded-3 bg-light">
                            <h5 class="mb-3 text-dark fw-bold">Viết đánh giá của bạn</h5>
                            <form action="" method="POST" id="reviewForm"> {{-- Cần cập nhật action --}}
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="mb-3">
                                    <label for="rating" class="form-label fw-semibold">Xếp hạng:</label>
                                    <div class="d-flex gap-1 rating-stars-interactive" id="ratingStars">
                                        <i class="far fa-star text-warning fa-lg" data-rating="1"></i>
                                        <i class="far fa-star text-warning fa-lg" data-rating="2"></i>
                                        <i class="far fa-star text-warning fa-lg" data-rating="3"></i>
                                        <i class="far fa-star text-warning fa-lg" data-rating="4"></i>
                                        <i class="far fa-star text-warning fa-lg" data-rating="5"></i>
                                        <input type="hidden" name="rating" id="selectedRating" value="0"
                                            required>
                                    </div>
                                    <div class="invalid-feedback">Vui lòng chọn số sao.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="comment" class="form-label fw-semibold">Bình luận:</label>
                                    <textarea class="form-control" name="comment" id="comment" rows="5"
                                        placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..." required></textarea>
                                    <div class="invalid-feedback">Vui lòng nhập bình luận.</div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg mt-3">Gửi đánh giá</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Sản phẩm liên quan --}}
            @if ($relatedProducts->count())
                @include('frontend.includes.ProductSection', [
                    'title' => 'SẢN PHẨM LIÊN QUAN',
                    'screen' => $relatedProducts,
                ])
            @endif

        </div>
    </div>
    @include('frontend/includes/ChatBot')

    {{-- Dynamic CSS (can be moved to a separate file) --}}
    <style>
        .luxury-star {
            color: #0f3c91;
            text-shadow: 0 1px 2px rgba(15, 60, 145, 0.25);
        }

        :root {
            --bs-primary: #0f3c91;
            /* Example primary color */
            --bs-secondary: #6c757d;
            --bs-danger: #dc3545;
            --bs-warning: #0f3c91;
            --bs-light: #f8f9fa;
            --bs-dark: #212529;
        }

        /* General improvements */
        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--bs-dark);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: var(--bs-dark);
        }

        .container {
            max-width: 1300px;
            /* Wider container for a more spacious feel */
        }

        /* Breadcrumb styling */
        .breadcrumb-item a {
            color: var(--bs-secondary) !important;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--bs-primary) !important;
        }

        .breadcrumb-item.active {
            color: var(--bs-dark) !important;
        }

        /* Product Gallery */
        .main-image-display {
            height: 500px;
            /* Consistent height for main image */
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f2f5;
            /* Light background for images with transparency */
            border: 1px solid #e9ecef;
        }

        .main-image-display img {
            transition: transform 0.3s ease-in-out;
        }

        .thumb-image {
            width: 90px;
            height: 90px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #e9ecef;
            /* Lighter default border */
            border-radius: 8px;
            /* Slightly more rounded thumbnails */
            transition: all 0.2s ease-in-out;
            padding: 2px;
            /* Small padding inside border */
        }

        .thumb-image.active,
        .thumb-image:hover {
            border-color: var(--bs-primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            /* More subtle shadow */
            transform: scale(1.03);
            /* Slight zoom on hover/active */
        }

        /* Product Info */
        .product-info-wrapper {
            padding: 1rem 0;
        }

        .product-price {
            font-size: 2.5rem !important;
            /* Even larger price */
            letter-spacing: -0.5px;
            /* Tighter letter spacing */
        }

        .discounted-price {
            font-size: 1.1rem;
            /* Slightly larger strikethrough price */
        }

        .reviews-link {
            font-weight: 500;
            color: var(--bs-dark) !important;
        }

        .reviews-link:hover {
            color: var(--bs-primary) !important;
            text-decoration: underline !important;
        }

        .quantity-control .btn {
            border-radius: 0.25rem;
            /* Standard Bootstrap border-radius */
        }

        .quantity-control .form-control {
            border-radius: 0;
            /* Remove border radius for input in group */
        }

        /* Add to cart button */
        .add-to-cart-btn {
            border-radius: 0.75rem;
            /* More rounded button */
            font-size: 1.25rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
            /* Darker primary on hover */
            border-color: #0056b3;
            transform: translateY(-2px);
            /* Slight lift */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Tabs Styling */
        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
            /* Thicker, lighter bottom border */
        }

        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            /* Highlight active tab with thicker border */
            color: var(--bs-secondary);
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: var(--bs-primary);
            border-color: #ced4da;
            /* Subtle hover border */
        }

        .nav-tabs .nav-link.active {
            color: var(--bs-primary);
            border-color: var(--bs-primary);
            /* Active tab highlight */
            background-color: transparent;
        }

        .tab-content {
            background-color: #fff;
            padding: 1.5rem 0;
        }

        .product-description-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .product-description-content p {
            margin-bottom: 1rem;
        }

        /* Review Cards */
        .review-card {
            border-radius: 0.75rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .review-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        /* Review Form */
        #reviewForm .form-control:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        .rating-stars-interactive i {
            cursor: pointer;
            transition: color 0.15s ease, transform 0.15s ease;
        }

        .rating-stars-interactive i:hover {
            transform: scale(1.1);
        }

        .rating-stars-interactive i.fas {
            color: var(--bs-warning);
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .main-image-display {
                height: 350px;
            }

            .thumb-image {
                width: 70px;
                height: 70px;
            }

            .product-price {
                font-size: 2rem !important;
            }

            .add-to-cart-btn {
                font-size: 1.1rem;
                padding-top: 0.8rem;
                padding-bottom: 0.8rem;
            }

            .nav-tabs .nav-link {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .main-image-display {
                height: 300px;
            }

            .thumb-image {
                width: 60px;
                height: 60px;
            }

            .product-price {
                font-size: 1.8rem !important;
            }

            .nav-tabs.flex-column {
                flex-direction: row !important;
                /* Keep tabs horizontal on smaller screens too */
            }

            .nav-tabs .nav-item {
                flex: 1 1 auto;
                /* Distribute items evenly */
                text-align: center;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const select = document.getElementById("variantSelect");
            const priceEl = document.querySelector(".product-price");
            const originalPriceEl = document.querySelector(".original-price");
            const percentOffEl = document.querySelector(".percent-off");

            if (select) {
                function updatePrice() {
                    const option = select.options[select.selectedIndex];
                    const price = Number(option.dataset.price); // giá gốc (số thô)
                    const discountedPrice = Number(option.dataset.discountedPrice); // giá sau giảm
                    const hasDiscount = option.dataset.hasDiscount === "1";
                    const percentOff = Number(option.dataset.percentOff);

                    if (hasDiscount && discountedPrice < price) {
                        priceEl.textContent = discountedPrice.toLocaleString("vi-VN") + " ₫";
                        originalPriceEl.textContent = price.toLocaleString("vi-VN") + " ₫";
                        originalPriceEl.style.display = "inline";
                        percentOffEl.textContent = `- ${percentOff}%`;
                        percentOffEl.style.display = "inline-block";
                    } else {
                        priceEl.textContent = price.toLocaleString("vi-VN") + " ₫";
                        originalPriceEl.style.display = "none";
                        percentOffEl.style.display = "none";
                    }
                }

                select.addEventListener("change", updatePrice);
                updatePrice(); // chạy ngay khi load
            }
        });
    </script>
    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantSelect = document.getElementById('variantSelect');
            const productPriceSpan = document.querySelector('.product-price');
            const discountedPriceSpan = document.querySelector('.discounted-price');
            const mainImage = document.getElementById('mainImage');
            const thumbImages = document.querySelectorAll('.thumb-image');
            const quantityInput = document.getElementById('quantityInput');
            const minusBtn = document.getElementById('minusBtn');
            const plusBtn = document.getElementById('plusBtn');
            const addToCartBtn = document.querySelector('.add-to-cart-btn');
            const productTabs = new bootstrap.Tab(document.getElementById(
                'description-tab')); // Initialize Bootstrap Tab

            // --- Image Gallery Logic ---
            // Set initial active thumbnail
            if (thumbImages.length > 0) {
                thumbImages[0].classList.add('active');
            }

            // Thumbnail click event
            thumbImages.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    // Update main image source
                    mainImage.src = this.dataset.src;

                    // Remove active class from all thumbnails
                    thumbImages.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked thumbnail
                    this.classList.add('active');
                });
            });

            // --- Price & Variant Logic ---
            if (variantSelect) {
                variantSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = parseFloat(selectedOption.dataset.price);
                    const originalListPrice = parseFloat("{{ $listPrice }}"); // From controller
                    let displayedListPrice = originalListPrice; // Base for comparison

                    // If the selected variant itself has an original price (not just a discounted one)
                    // you would need another data attribute for that variant's original price.
                    // For now, we're assuming product's $listPrice is the general reference.

                    productPriceSpan.textContent = price.toLocaleString('vi-VN') + ' ₫';

                    if (discountedPriceSpan) {
                        // This logic assumes $listPrice is the *product's* original price
                        // If variants have distinct original prices, you'd need `data-original-price` on each option
                        if (price <
                            originalListPrice
                        ) { // Compare variant's discounted price with product's list price
                            discountedPriceSpan.style.display = 'inline';
                            discountedPriceSpan.textContent = originalListPrice.toLocaleString('vi-VN') +
                                ' ₫';
                        } else {
                            // If variant price is not lower than product's general list price, hide strikethrough
                            discountedPriceSpan.style.display = 'none';
                        }
                    }
                });
                // Trigger change on load to set initial price correctly if variants exist
                variantSelect.dispatchEvent(new Event('change'));
            }

            // --- Quantity Controls ---
            minusBtn.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value);
                if (quantity > 1) {
                    quantityInput.value = quantity - 1;
                }
            });

            plusBtn.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value);
                quantityInput.value = quantity + 1;
            });

            // --- Add to Cart Functionality (AJAX placeholder) ---
            addToCartBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.dataset.id;
                const selectedVariantId = variantSelect ? variantSelect.value : null;
                const quantity = quantityInput.value;

                // In a real application, you'd send an AJAX request here
                console.log(
                    `Adding Product ID: ${productId}, Variant ID: ${selectedVariantId}, Quantity: ${quantity} to cart.`
                );

                // Example using Fetch API
                /*
                fetch('/api/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // If using CSRF token
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        variant_id: selectedVariantId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Sản phẩm đã được thêm vào giỏ hàng!'); // Replace with a more elegant notification (e.g., Toast)
                        // Update cart count on the page
                    } else {
                        alert('Có lỗi xảy ra: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error adding to cart:', error);
                    alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
                });
                */
                alert(`Đã thêm ${quantity} sản phẩm vào giỏ hàng!`); // Placeholder for demonstration
            });

            // --- Rating Stars Interaction (for review form) ---
            const ratingStarsContainer = document.getElementById('ratingStars');
            const selectedRatingInput = document.getElementById('selectedRating');

            if (ratingStarsContainer) {
                const stars = ratingStarsContainer.querySelectorAll('i');

                stars.forEach(star => {
                    star.addEventListener('mouseover', function() {
                        const currentRating = parseInt(this.dataset.rating);
                        highlightStars(currentRating);
                    });

                    star.addEventListener('click', function() {
                        const clickedRating = parseInt(this.dataset.rating);
                        selectedRatingInput.value = clickedRating;
                        highlightStars(clickedRating); // Persist selection
                        ratingStarsContainer.classList.add(
                            'rated'); // Add a class to indicate it's rated
                    });
                });

                ratingStarsContainer.addEventListener('mouseleave', function() {
                    if (!ratingStarsContainer.classList.contains('rated')) {
                        highlightStars(0); // Reset if not yet rated
                    } else {
                        highlightStars(parseInt(selectedRatingInput.value)); // Restore selected rating
                    }
                });

                function highlightStars(rating) {
                    stars.forEach(s => {
                        if (parseInt(s.dataset.rating) <= rating) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                }

                // Initial state based on hidden input value (if form pre-filled)
                highlightStars(parseInt(selectedRatingInput.value));
            }

            // --- Scroll to Reviews Tab ---
            const reviewsLink = document.querySelector('.reviews-link');
            if (reviewsLink) {
                reviewsLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Activate the reviews tab
                    const reviewsTabButton = document.getElementById('reviews-tab');
                    const bsReviewsTab = new bootstrap.Tab(reviewsTabButton);
                    bsReviewsTab.show();

                    // Scroll to the tab content
                    document.getElementById('productTabs').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            }
        });
    </script>



    <script>
        $(document).ready(function() {
            $(document).on("click", ".btn-remove-favorite", function(e) {
                e.preventDefault();
                let item = $(this).closest(".favorite-item");
                let productId = item.data("id");

                $.ajax({
                    url: "{{ route('favorites.remove') }}",
                    type: "POST",
                    data: {
                        product_id: productId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            // Xoá sản phẩm khỏi DOM
                            item.remove();

                            // Cập nhật số yêu thích trên navbar
                            $(".nav-shop__circle").text(res.count);
                            $("#favorite-list").html(res.html);
                            // Nếu hết sản phẩm thì hiển thị thông báo
                            if (res.count === 0) {
                                $("#favorite-list").html(
                                    "<p>Chưa có sản phẩm yêu thích nào.</p>");
                            }

                            // Thông báo
                            Toastify({
                                text: "Đã xóa sản phẩm khỏi yêu thích",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#ff6b6b",
                            }).showToast();
                        }
                    },
                    error: function() {
                        Toastify({
                            text: "Có lỗi xảy ra!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#ff6b6b",
                        }).showToast();
                    }
                });
            });
        });
    </script>

    <script>
        function showSpinner() {
            document.getElementById("loading-overlay").style.display = "flex";
        }

        function hideSpinner() {
            document.getElementById("loading-overlay").style.display = "none";
        }

        // AJAX nút "Xem thêm"
        $("#load-more").on("click", function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).data("next-page"),
                method: "GET",
                beforeSend: function() {
                    showSpinner();
                },
                success: function(res) {
                    $("#product-list").append(res);
                },
                complete: function() {
                    hideSpinner();
                }
            });
        });

        // Spinner khi rời trang (reload / redirect)
        window.addEventListener("beforeunload", function() {
            showSpinner();
        });

        // Spinner khi click sort
        document.querySelectorAll('a[href*="?sort="]').forEach(link => {
            link.addEventListener("click", function() {
                showSpinner();
            });
        });
    </script>


@endsection

<style>
    #floating-buttons {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        z-index: 9999;
    }

    #floating-buttons .btn {
        width: 55px;
        height: 55px;
        font-size: 1.4rem;
        padding: 0;
        transition: all 0.3s ease-in-out;
    }

    /* Nút con ẩn mặc định */
    .contact-item {
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
        margin-bottom: 8px;
    }

    /* Khi hover vào contact-menu thì hiện nút con */
    .contact-menu:hover .contact-item {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    #floating-buttons .btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    #back-to-top {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
    }

    /* Khi active thì hiện ra */
    #back-to-top.show {
        opacity: 1;
        visibility: visible;
    }

    /* Nút con ẩn mặc định */
    .contact-item {
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
        margin-bottom: 8px;
    }

    /* Khi active thì hiện nút con */
    .contact-menu.active .contact-item {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .logo-slider-wrapper {
        position: relative;
        overflow: hidden;
    }

    .logo-slider {
        display: flex;
        gap: 60px;
        animation: scroll-left 25s linear infinite;
    }

    .logo-item img {
        height: 60px;
        width: auto;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .logo-item img:hover {
        filter: grayscale(0%);
        opacity: 1;
        transform: scale(1.1);
    }

    /* Hiệu ứng fade 2 bên */
    .logo-slider-wrapper::before,
    .logo-slider-wrapper::after {
        content: "";
        position: absolute;
        top: 0;
        width: 80px;
        height: 100%;
        z-index: 2;
        pointer-events: none;
    }

    .logo-slider-wrapper::before {
        left: 0;
        background: linear-gradient(to right, #fff, transparent);
    }

    .logo-slider-wrapper::after {
        right: 0;
        background: linear-gradient(to left, #fff, transparent);
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .card-product__img:hover img {
        transform: scale(1.05);
    }

    .card-product__imgOverlay button {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-product__imgOverlay button:hover {
        transform: scale(1.2);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .card-product__imgOverlay {
        opacity: 0;
        transition: all 0.3s ease;
    }

    .card-product__img:hover .card-product__imgOverlay {
        opacity: 1;
    }

    .card-product__imgOverlay button {
        width: 40px;
        height: 40px;
    }

    /* Overlay ẩn mặc định */
    .hero-carousel__slideOverlay {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
    }

    /* Khi active (slide đang hiển thị) thì hiện */
    .hero-carousel__slide.active .hero-carousel__slideOverlay {
        opacity: 1;
        transform: translateY(0);
    }

    /* Khung ảnh đồng bộ */
    .hero-image-wrapper {
        position: relative;
        width: 100%;
        height: 450px;
        /* Chiều cao cố định cho đồng đều */
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .hero-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Giữ tỷ lệ, lấp đầy khung */
        transition: transform 0.4s ease;
    }

    .hero-image-wrapper img:hover {
        transform: scale(1.08);
        /* zoom nhẹ khi hover */
    }

    /* Overlay mờ */
    .hero-carousel__slideOverlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 40%, rgba(0, 0, 0, 0.6) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        padding: 20px;
        text-align: center;
        color: #fff;
        opacity: 1;
        transition: background 0.3s ease;
    }

    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        position: relative;
        opacity: 0 !important;
        transition: opacity 1s;
    }

    .swiper-slide-active {
        opacity: 1 !important;
    }

    .hero-carousel__slideOverlay:hover {
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.2) 30%, rgba(0, 0, 0, 0.75) 100%);
    }

    .hero-carousel__slideOverlay h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .hero-carousel__slideOverlay p {
        font-size: 16px;
        opacity: 0.9;
    }

    .product-info {
        animation: fadeInLeft 1s ease;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .carousel-layout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
    }

    .product-info {
        width: 300px;
        padding: 20px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .product-info h2 {
        font-size: 22px;
        margin-bottom: 12px;
        color: #222;
    }

    .product-info p {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
    }

    .btn-buy {
        display: inline-block;
        padding: 10px 20px;
        background: #0072bc;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-buy:hover {
        background: #005b9f;
    }

    /* Vùng chứa toàn bộ carousel */
    .carousel-container {
        margin: auto;
        width: 100%;
        max-width: 1000px;
        height: 700px;
        position: relative;
        perspective: 2200px;
        overflow: hidden;
        user-select: none;
        overflow: visible;
        /* không cho bôi đen */
    }

    /* Carousel xoay */
    .carousel {
        width: 100%;
        height: 100%;
        position: absolute;
        transform-style: preserve-3d;
        transition: transform 1s ease-in-out;
        user-select: none;
    }

    /* Item sản phẩm */
    .item {
        position: absolute;
        width: 400px;
        height: 450px;
        left: 50%;
        top: 50%;
        transform-style: preserve-3d;
        transform-origin: center;
        margin: -225px 0 0 -200px;
        text-align: center;
        user-select: none;
    }

    .item img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        transition: transform 0.3s ease;
        pointer-events: none;
        /* fix click không chọn ảnh */
    }

    .item img:hover {
        transform: scale(1.05);
    }

    .item p {
        margin-top: 12px;
        background: rgba(0, 0, 0, 0.65);
        color: #fff;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 500;
        user-select: none;
        /* không cho bôi đen chữ */
    }
</style>

@section('user.js')
    <script>
        document.querySelectorAll('.btn-qty').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let id = this.dataset.id;
                let input = document.querySelector(`.qty-input[data-id="${id}"]`);
                let currentQty = parseInt(input.value);

                if (this.dataset.type === "plus") {
                    currentQty++;
                } else if (this.dataset.type === "minus" && currentQty > 1) {
                    currentQty--;
                }

                fetch(`/cart/update/${id}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            quantity: currentQty
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            input.value = data.quantity;

                            // update giá sản phẩm
                            let itemRow = document.querySelector(`.cart-item[data-id="${id}"]`);
                            itemRow.querySelector(".item-subtotal").innerText = data.subtotal;

                            // update tổng tiền
                            document.querySelector(".cart-total").innerText = data.total;
                        }
                    });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.ripple').forEach(button => {
            button.addEventListener('click', function(e) {
                const circle = document.createElement("span");
                circle.classList.add("ripple-effect");

                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                circle.style.width = circle.style.height = size + 'px';
                circle.style.left = e.clientX - rect.left - size / 2 + "px";
                circle.style.top = e.clientY - rect.top - size / 2 + "px";

                this.appendChild(circle);

                // Xóa ripple sau khi animation xong
                setTimeout(() => circle.remove(), 600);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".btn-remove-favorite").on("click", function() {
                let btn = $(this);
                let item = btn.closest(".favorite-item");
                let productId = item.data("id");

                $.ajax({
                    url: "/favorites/remove",
                    type: "POST",
                    data: {
                        product_id: productId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            item.remove();

                            Toastify({
                                text: "Đã xóa sản phẩm khỏi yêu thích",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#ff6b6b",
                            }).showToast();
                        }
                    },
                    error: function() {
                        Toastify({
                            text: "Có lỗi xảy ra!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#ff6b6b",
                        }).showToast();
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-favorite').on('click', function() {
                let btn = $(this);
                let productId = btn.data('id');

                $.ajax({
                    url: '/favorites/add', // Route Laravel thêm yêu thích
                    type: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            // Đổi màu icon tim
                            btn.find('i').addClass('text-primary');

                            // Kiểm tra trùng trước khi append dropdown
                            if ($('#favorite-list').find('[data-id="' + productId + '"]')
                                .length === 0) {
                                let product = res.product;
                                let html = `
                            <div class="d-flex align-items-center mb-2" data-id="${product.id}">
                                <img src="${product.image}" class="mr-2 rounded" alt="${product.name}" style="width:40px;height:40px;object-fit:cover;">
                                <div>
                                    <p class="mb-0 small">${product.name}</p>
                                    <span class="text-danger small">${product.price}</span>
                                </div>
                            </div>
                        `;
                                $('#favorite-list').prepend(html);
                            }

                            // Cập nhật số lượng
                            $('.nav-shop__circle').text($('#favorite-list > div').length);

                            // Hiển thị toast
                            Toastify({
                                text: `"${res.product.name}" đã thêm vào danh sách yêu thích`,
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#4fbe87",
                            }).showToast();
                        }
                    },
                    error: function() {
                        Toastify({
                            text: "Có lỗi xảy ra!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#ff6b6b",
                        }).showToast();
                    }
                });
            });

            // Hover dropdown show
            $('.nav-item.dropdown').hover(
                function() {
                    $(this).addClass('show');
                    $(this).find('.dropdown-menu').addClass('show');
                },
                function() {
                    $(this).removeClass('show');
                    $(this).find('.dropdown-menu').removeClass('show');
                }
            );
        });
    </script>




    <script>
        $(document).ready(function() {
            var $carousel = $(".hero-carousel");

            $carousel.owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                nav: true,
                dots: true
            });

            // Gắn class active cho slide hiện tại
            $carousel.on('changed.owl.carousel', function(event) {
                var index = event.item.index; // index slide hiện tại
                $(".hero-carousel__slide").removeClass("active");
                $(".owl-item").eq(index).find(".hero-carousel__slide").addClass("active");
            });

            // Kích hoạt slide đầu tiên khi load
            $(".owl-item.active .hero-carousel__slide").addClass("active");
        });
    </script>

    <script>
        new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            effect: "fade",
            speed: 1200
        });
    </script>
@endsection
