<section class="section-margin calc-60px mt-4 pt-4">
    <div class="container position-relative">
        <div class="section-introc pb-4 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold mb-0">{{ $title ?? 'SẢN PHẨM' }}</h2>
            @php
                $suppliers = $screen->pluck('supplier')->filter()->unique('id');
                $wrapperId = $wrapperId ?? Str::slug($title) . '-wrapper';
            @endphp

            {{-- <div class="fw-bold d-flex flex-wrap gap-3">
                @foreach ($suppliers as $supplier)
                    <span class="chip">
                        {{ $supplier->supplier_text }}
                    </span>
                @endforeach
            </div> --}}
        </div>

        <style>
            .chip {
                display: inline-block;
                padding: 0.5rem 1rem;
                border: 1px solid #0f3c91;
                background-color: #f8f9fa;
                color: #0f3c91;
                font-weight: 500;
                font-size: 0.95rem;
                transition: all 0.2s ease-in-out;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .chip:hover {
                background-color: #0f3c91;
                color: #fff;
                transform: translateY(-2px);
                cursor: pointer;
            }

            /* Wrapper 2 hàng */
            .featured-products-wrapper {
                display: grid;
                grid-auto-flow: column;
                grid-template-columns: repeat(5, 1fr);
                grid-template-rows: repeat(2, 1fr);
                gap: 1rem;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                padding-bottom: 1rem;

                /* Ngăn bôi đen khi kéo */
                user-select: none;
                -webkit-user-drag: none;
            }

            .featured-products-wrapper::-webkit-scrollbar {
                display: none;
            }

            .card-product {
                width: 250px;
                scroll-snap-align: start;
                display: flex;
                flex-direction: column;
            }

            .card-product__img {
                position: relative;
                overflow: hidden;
            }

            .card-product__imgOverlay {
                opacity: 0;
                transition: all 0.3s ease;
            }

            .card-product__img:hover .card-product__imgOverlay {
                opacity: 1;
            }

            .nav-arrow {
                position: absolute;
                top: 40%;
                transform: translateY(-50%);
                background: white;
                border: none;
                border-radius: 50%;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                width: 40px;
                height: 40px;
                cursor: pointer;
                z-index: 20;
            }

            .nav-arrow.left {
                left: -20px;
            }

            .nav-arrow.right {
                right: -20px;
            }
        </style>
        <!-- Buttons -->
        <button class="nav-arrow left" data-target="{{ $wrapperId }}"
            onclick="scrollProducts(event, -1)">&#8249;</button>
        <button class="nav-arrow right" data-target="{{ $wrapperId }}"
            onclick="scrollProducts(event, 1)">&#8250;</button>

        <!-- Wrapper -->
        <div class="products-container featured-products-wrapper" id="{{ $wrapperId }}">
            @foreach ($screen as $product)
                @php
                    $avgRating = (float) ($product->reviews_avg_rating ?? 0);
                    $rating = (int) round($avgRating);

                    // Lấy thông tin giảm giá
                    $discount = $product->discount;
                    $listPrice = (float) $product->list_price;

                    $discountedPrice = $listPrice;
                    $percentOff = 0;
                    $hasDiscount = false;

                    if ($discount && $listPrice > 0) {
                        $discountAmount = (float) ($discount->discount_amount ?? 0);
                        $isPercent = (int) ($discount->is_fixed ?? 0);

                        if ($isPercent === 0 && $discountAmount > 0) {
                            // 0 = giảm theo %
                            $percentOff = min(100, round($discountAmount));
                            $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
                        } elseif ($isPercent === 1 && $discountAmount > 0) {
                            // 1 = giảm theo số tiền cố định
                            $discountedPrice = max(0, $listPrice - $discountAmount);
                            $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
                        }

                        $hasDiscount = $discountedPrice < $listPrice;
                    }
                @endphp
                <div class="card card-product h-100 border-0 shadow-sm rounded-3 overflow-hidden position-relative">

                    {{-- Badge % giảm giá --}}
                    @if ($hasDiscount && $percentOff > 0)
                        <span class="position-absolute top-0 start-0 m-2 badge rounded-pill shadow"
                            style="background: linear-gradient(135deg,#0f3c91,#1e6bff); font-size:0.95rem; padding:0.4rem 0.7rem;z-index: 10;color: #fff;">
                            -{{ $percentOff }}%
                        </span>
                    @endif
                    {{-- Ảnh sản phẩm --}}
                    <div class="card-product__img position-relative overflow-hidden">

                        <img src="{{ Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : asset('storage/uploads/products/' . $product->image) }}"
                            alt="{{ $product->product_name }}"
                            style="height:260px;object-fit:cover;transition: transform .3s;">
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
                                <button class="btn btn-light rounded-circle shadow-sm add-to-cart"
                                    data-id="{{ $product->id }}">
                                    <i class="ti-shopping-cart"></i>
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="btn btn-light rounded-circle shadow-sm btn-favorite"
                                    data-id="{{ $product->id }}" type="button">
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
                                <span class="text-muted ms-2 text-decoration-line-through small fst-italic"
                                    style="text-decoration: line-through; text-decoration-thickness: 2px; text-decoration-color: #6c757d;">
                                    {{ number_format($listPrice, 0, ',', '.') }} ₫
                                </span>
                            @endif
                        </p>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function scrollProducts(event, direction) {
        const targetId = event.currentTarget.dataset.target;
        const container = document.getElementById(targetId);
        if (!container) return;

        const card = container.querySelector('.card-product');
        if (!card) return;

        const gap = parseFloat(getComputedStyle(container).gap) || 16;
        const scrollAmount = (card.offsetWidth + gap) * 5;

        container.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let productId = $(this).data('id');

            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(res) {
                    if (res.success) {
                        $('.cart-count').text(res.cart_count).show();

                        Toastify({
                            text: "Thêm sản phẩm thành công",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#28a745",
                        }).showToast();
                    }
                }, // ✅ DẤU PHẨY QUAN TRỌNG
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

    });
</script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.btn-favorite', function(e) {
            e.preventDefault();

            let productId = $(this).data('id');
            let icon = $(this).find('i');

            $.ajax({
                url: "{{ route('favorites.add') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(res) {
                    if (res.success) {

                        // ❤️ đổi màu tim
                        icon.addClass('text-primary');

                        // ❤️ cập nhật số trên navbar
                        $('#favorite-count')
                            .text(res.count)
                            .show();

                        Toastify({
                            text: "Đã thêm vào yêu thích",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#e91e63",
                        }).showToast();
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

    });
</script>
