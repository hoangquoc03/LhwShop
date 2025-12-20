@php
    $firstProduct = $newProducts->first();
@endphp

<section class="luxury-section reveal">

    <div class="luxury-container">



        @if ($firstProduct)
            @php
                $avgRating = (float) ($firstProduct->reviews_avg_rating ?? 0);
                $rating = (int) round($avgRating);

                $discount = $firstProduct->discount;
                $listPrice = (float) $firstProduct->list_price;

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


            @if ($hasDiscount)
                <span class="luxury-discount">
                    @if ($discount->is_fixed)
                        -{{ number_format($discount->discount_amount, 0, ',', '.') }}₫
                    @else
                        -{{ $percentOff }}%
                    @endif
                </span>
            @endif

        @endif

        <div class="luxury-images reveal-left">



            <div class="luxury-image-stack">
                @foreach ($newProducts->take(4) as $index => $product)
                    <img src="{{ Str::startsWith($product->image, ['http://', 'https://'])
                        ? $product->image
                        : asset('storage/uploads/products/' . $product->image) }}"
                        alt="{{ $product->product_name }}" class="luxury-image {{ $index === 0 ? 'active' : '' }}"
                        data-index="{{ $index }}">
                @endforeach
            </div>

            <!-- NAV BUTTONS -->
            <div class="luxuryNav">
                <button class="luxury-nav-button luxury-prev">‹</button>
                <button class="luxury-nav-button luxury-next">›</button>
            </div>

        </div>



        @if ($firstProduct)
            <div class="luxury-content reveal-right">

                <h2 class="luxury-title ">
                    {{ $firstProduct->product_name }}
                </h2>



                <p class="luxury-desc text-gray-600 leading-relaxed line-clamp-3">
                    {{ $firstProduct->short_description }}
                </p>
                {{-- Rating --}}
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

                <div class="luxury-product">
                    <p class="card-product__price mb-0 luxury-price">
                        <span class="fs-5 fw-bold text-danger">
                            {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                        </span>

                        @if ($hasDiscount)
                            <span
                                class=" old-price text-muted ms-2 text-decoration-line-through small fst-italic luxury-discount">
                                {{ number_format($listPrice, 0, ',', '.') }} ₫
                            </span>
                        @endif
                    </p>
                </div>


                <a href="" class="lv-btn">
                    Xem thêm <span class="arrow">→</span>
                </a>

            </div>
        @endif

    </div>
</section>

<style>
    .luxury-star {
        color: #0f3c91;
        text-shadow: 0 1px 2px rgba(15, 60, 145, 0.25);
    }


    .luxury-rating .rating-text {
        color: #6c757d;
        margin-left: 4px;
        font-size: 0.85rem;
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

    .luxury-images {
        position: relative;
        /* QUAN TRỌNG */
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

    .luxury-image:nth-child(1) {
        transition-delay: 0.2s;
    }

    .luxury-image:nth-child(2) {
        transition-delay: 0.35s;
    }

    .luxury-image:nth-child(3) {
        transition-delay: 0.5s;
    }

    .luxury-image:nth-child(4) {
        transition-delay: 0.65s;
    }

    /* ===== REVEAL BASE ===== */
    .reveal,
    .reveal-left,
    .reveal-right {
        opacity: 0;
        filter: blur(8px);
        transition:
            opacity 1s ease,
            filter 1s ease;
    }

    /* reveal whole section */
    .reveal {
        transform: translateY(40px);
    }

    /* image side */
    .reveal-left {
        transform: translateX(-60px);
    }

    /* content side */
    .reveal-right {
        transform: translateX(60px);
    }

    /* ACTIVE */
    .reveal.show,
    .reveal-left.show,
    .reveal-right.show {
        opacity: 1;
        filter: blur(0);
        transform: translate(0, 0);
    }


    .luxury-title {
        font-size: 44px;
        font-weight: 500;
        margin: 18px 0 24px;
        letter-spacing: -0.3px;
        line-height: 1.15;
        transition-delay: 0.4s;
        background: linear-gradient(120deg,
                #0a2540 0%,
                #0f3c91 35%,
                #1e6bff 55%,
                #6aa7ff 100%);

        background-size: 200% 200%;
        animation: luxuryGradient 6s ease infinite;

        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;

        position: relative;
    }

    /* underline mảnh, rất sang */
    .luxury-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 56px;
        height: 2px;

        background: linear-gradient(90deg,
                #0f3c91,
                #1e6bff);

        border-radius: 2px;
        opacity: 0.85;
    }

    /* animation gradient */
    @keyframes luxuryGradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }


    .luxury-section {
        position: relative;
        padding: 120px 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: background-image 0.8s ease;
    }

    /* Overlay tối + luxury */
    .luxury-section::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        z-index: 1;
    }

    .luxury-section::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at center,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.4) 70%,
                rgba(255, 255, 255, 0.7) 100%);
        z-index: 1;
    }

    /* Đảm bảo content nổi trên nền */
    .luxury-container {
        position: relative;
        z-index: 2;
    }

    .luxury-images,
    .luxury-content {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .luxuryNav {
        position: absolute;
        bottom: 20px;
        left: 100%;
        transform: translateX(-50%);
        display: flex;
        gap: 16px;
        z-index: 20;
    }

    .luxury-nav-button {
        position: relative;
        /* QUAN TRỌNG */
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: transparent;
        border: none;
        color: #050505;
        font-size: 26px;
        cursor: pointer;
        transition: 0.3s;
    }

    .luxury-section {
        padding: 180px 0;
        background-color: #ffffff;
        font-family: 'Helvetica Neue', sans-serif;
    }

    .luxury-container {
        max-width: 1560px;
        margin: auto;
        display: flex;
        align-items: center;
        gap: 60px;
    }

    /* LEFT IMAGES */
    /* ===== SLIDE ANIMATION ===== */
    /* ===== SLIDE STATES ===== */
    .luxury-images.sliding-left .luxury-image {
        opacity: 0;
        transform:
            translate(-50%, -50%) translateX(-380px) scale(0.65) rotateY(-80deg);
    }

    .luxury-images.sliding-right .luxury-image {
        opacity: 0;
        transform:
            translate(-50%, -50%) translateX(160px) scale(0.65) rotateY(35deg);
    }


    /* easing luxury */
    .luxury-image {
        backface-visibility: hidden;
        transform-style: preserve-3d;
        will-change: transform, opacity;
    }

    .luxury-images {
        position: relative;
        height: 520px;
        perspective: 2600px;
        /* sâu hơn nữa */
        overflow: visible;
    }

    /* Base image */
    .luxury-image {
        position: absolute;
        top: 50%;
        left: 70%;
        /* tâm cụm */
        transform-origin: left center;
        /* xoè sang phải */
        transform:
            translate(-50%, -50%) translateX(-300px) scale(0.78) rotateY(-70deg);

        width: 280px;
        height: 420px;
        object-fit: cover;
        border-radius: 18px;
        opacity: 0.3;
        filter: blur(1.4px);
        transition: all 0.8s cubic-bezier(.4, 0, .2, 1);
        cursor: pointer;
    }

    /* Active image */
    .luxury-image.active {
        transform:
            translate(-50%, -50%) translateX(40px) scale(1.08) rotateY(0deg);

        opacity: 1;
        filter: blur(0);
        z-index: 10;
    }

    /* Ảnh thứ 2 */
    .luxury-image:nth-child(2):not(.active) {
        transform:
            translate(-50%, -50%) translateX(-120px) scale(0.88) rotateY(-30deg);

        opacity: 0.55;
        z-index: 4;
    }

    /* Ảnh thứ 3 */
    .luxury-image:nth-child(3):not(.active) {
        transform:
            translate(-50%, -50%) translateX(-200px) scale(0.72) rotateY(-45deg);

        opacity: 0.35;
        z-index: 3;
    }

    /* Ảnh thứ 4 */
    .luxury-image:nth-child(4):not(.active) {
        transform:
            translate(-50%, -50%) translateX(-260px) scale(0.6) rotateY(-60deg);

        opacity: 0.2;
        z-index: 2;
    }

    .luxury-image:hover {
        opacity: 0.7;
    }



    /* RIGHT CONTENT */
    .luxury-content {
        flex: 1;

    }

    .luxury-tag {
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #888;
    }

    .luxury-content h2 {
        font-size: 42px;
        margin: 15px 0;
        font-weight: 500;
    }

    .luxury-desc {
        color: #555;
        line-height: 1.6;
        margin-bottom: 25px;
        width: 70%;
    }

    .luxury-product h3 {
        font-size: 22px;
        margin-bottom: 8px;
    }

    .luxury-price {
        display: block;
        margin-top: 10px;
        font-weight: bold;
        font-size: 18px;
    }

    .lv-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 14px 42px;
        margin-top: 36px;

        background-color: #0a2540;

        /* LV black */
        color: #ffffff;

        font-size: 13px;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 400;

        text-decoration: none;

        border-color: #0a2540;
        transition: all 0.25s ease;

        position: relative;
    }

    /* hover rất nhẹ – LV style */
    .lv-btn:hover {
        background-color: transparent;
        color: #0a2540;
    }

    /* focus / active tinh tế */
    .lv-btn::after {
        content: "";
        position: absolute;
        inset: 0;
        border: 1px solid #050505;
        opacity: 0;
        transition: 0.25s ease;
    }

    .lv-btn:hover::after {
        opacity: 1;
    }

    .lv-btn .arrow {
        margin-left: 12px;
        transition: transform 0.25s ease;
    }

    .lv-btn:hover .arrow {
        transform: translateX(4px);
    }



    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    function calculatePrice(product) {
        let listPrice = Number(product.list_price);
        let discountedPrice = listPrice;
        let percentOff = 0;
        let hasDiscount = false;

        if (product.discount && listPrice > 0) {
            const amount = Number(product.discount.discount_amount);
            const isFixed = Number(product.discount.is_fixed);

            if (isFixed === 0) {
                percentOff = Math.min(100, Math.round(amount));
                discountedPrice = Math.max(0, listPrice * (1 - amount / 100));
            } else {
                discountedPrice = Math.max(0, listPrice - amount);
                percentOff = Math.min(100, Math.round((amount / listPrice) * 100));
            }

            hasDiscount = discountedPrice < listPrice;
        }

        return {
            listPrice,
            discountedPrice,
            percentOff,
            hasDiscount
        };
    }

    const products = @json($newProducts);
    const images = document.querySelectorAll('.luxury-image');
    const section = document.querySelector('.luxury-section');
    const containerImages = document.querySelector('.luxury-images');

    const title = document.querySelector('.luxury-content h2');
    const desc = document.querySelector('.luxury-desc');
    const price = document.querySelector('.luxury-price');

    let currentProductIndex = 0;
    let isAnimating = false;

    function getImageUrl(product) {
        return product.image.startsWith('http') ?
            product.image :
            `/storage/uploads/products/${product.image}`;
    }

    function updateContent(index) {
        const p = products[index];

        /* ===== TEXT ===== */
        title.innerText = p.product_name;
        desc.innerText = p.short_description;

        /* ===== PRICE ===== */
        const {
            listPrice,
            discountedPrice,
            percentOff,
            hasDiscount
        } = calculatePrice(p);

        let priceHtml = `
        <span class="fs-5 fw-bold text-danger">
            ${new Intl.NumberFormat('vi-VN').format(discountedPrice)} ₫
        </span>
    `;

        if (hasDiscount) {
            priceHtml += `
            <span class="old-price text-muted ms-2 text-decoration-line-through small fst-italic">
                ${new Intl.NumberFormat('vi-VN').format(listPrice)} ₫
            </span>
        `;
        }

        document.querySelector('.luxury-price').innerHTML = priceHtml;

        /* ===== DISCOUNT BADGE ===== */
        const discountBadge = document.querySelector('.luxury-discount');
        if (discountBadge) {
            if (hasDiscount) {
                discountBadge.style.display = 'inline-block';
                discountBadge.innerText = p.discount.is_fixed ?
                    `-${new Intl.NumberFormat('vi-VN').format(p.discount.discount_amount)}₫` :
                    `-${percentOff}%`;
            } else {
                discountBadge.style.display = 'none';
            }
        }

        /* ===== RATING ===== */
        const ratingBox = document.querySelector('.luxury-rating');
        const avgRating = Number(p.reviews_avg_rating || 0);
        const rounded = Math.round(avgRating);

        let ratingHtml = '';
        for (let i = 1; i <= 5; i++) {
            ratingHtml += i <= rounded ?
                '<i class="fas fa-star luxury-star"></i>' :
                '<i class="far fa-star luxury-star"></i>';

        }

        ratingHtml += `
        <small class="text-muted ms-2">
            ${avgRating > 0 ? `(${avgRating.toFixed(1)}/5)` : ''}
        </small>
    `;

        ratingBox.innerHTML = ratingHtml;
    }


    function updateBackground(index) {
        section.style.backgroundImage = `url(${getImageUrl(products[index])})`;
    }

    /* ===== CORE SLIDE ===== */
    function slide(direction = 'next') {
        if (isAnimating) return;
        isAnimating = true;

        containerImages.classList.add(
            direction === 'next' ? 'sliding-left' : 'sliding-right'
        );

        setTimeout(() => {
            // update index
            currentProductIndex =
                direction === 'next' ?
                (currentProductIndex + 1) % products.length :
                (currentProductIndex - 1 + products.length) % products.length;

            images.forEach((img, i) => {
                const productIndex =
                    (currentProductIndex + i) % products.length;

                img.src = getImageUrl(products[productIndex]);
                img.classList.toggle('active', i === 0);
            });

            updateContent(currentProductIndex);
            updateBackground(currentProductIndex);

            containerImages.classList.remove('sliding-left', 'sliding-right');
            isAnimating = false;
        }, 450); // khớp với CSS timing
    }

    /* Buttons */
    document.querySelector('.luxury-next').addEventListener('click', () => slide('next'));
    document.querySelector('.luxury-prev').addEventListener('click', () => slide('prev'));

    /* init */
    updateContent(0);
    updateBackground(0);
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const reveals = document.querySelectorAll(
            ".reveal, .reveal-left, .reveal-right"
        );

        const observer = new IntersectionObserver(
            entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                    }
                });
            }, {
                threshold: 0.25
            }
        );

        reveals.forEach(el => observer.observe(el));
    });

    function slide(direction = 'next') {
        if (isAnimating) return;
        isAnimating = true;

        containerImages.classList.add(
            direction === 'next' ? 'sliding-left' : 'sliding-right'
        );

        // ĐỢI animation fade-out xong
        setTimeout(() => {

            currentProductIndex =
                direction === 'next' ?
                (currentProductIndex + 1) % products.length :
                (currentProductIndex - 1 + products.length) % products.length;

            images.forEach((img, i) => {
                const productIndex =
                    (currentProductIndex + i) % products.length;

                img.style.transition = 'none';
                img.src = getImageUrl(products[productIndex]);
                img.classList.toggle('active', i === 0);

                // force reflow
                img.offsetHeight;

                img.style.transition = '';
            });

            updateContent(currentProductIndex);
            updateBackground(currentProductIndex);

            containerImages.classList.remove('sliding-left', 'sliding-right');

            isAnimating = false;

        }, 520); // khớp timing CSS
    }
</script>
