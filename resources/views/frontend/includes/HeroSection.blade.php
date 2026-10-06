@php
    $luxuryProducts = $newProducts->take(4)->values();
    $firstProduct = $luxuryProducts->first();
@endphp

<section class="luxury-section" id="luxuryCollection">

    {{-- =========================================================
        BACKGROUND
    ========================================================== --}}
    <div class="luxury-bg" id="luxuryBg"></div>
    <div class="luxury-bg-overlay"></div>
    <div class="luxury-bg-vignette"></div>


    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="luxury-header">

        <div class="luxury-tag">
            <span class="luxury-tag-line"></span>
            LWSHOP GIỚI THIỆU
        </div>

        <h1 class="luxury-section-title">
            Bộ sưu tập thời trang
            <span>Luxury mới nhất</span>
        </h1>

        <p class="luxury-section-sub">
            Tinh hoa thiết kế cao cấp – Khẳng định phong cách sang trọng
        </p>

    </div>


    @if ($luxuryProducts->count())

        {{-- =====================================================
            MAIN CONTAINER
        ====================================================== --}}
        <div class="luxury-container">


            {{-- =================================================
                LEFT - IMAGES
            ================================================== --}}
            <div class="luxury-images">

                {{-- Decorative number --}}
                <div class="luxury-watermark">
                    LWSHOP
                </div>


                {{-- Discount badge --}}
                <div class="luxury-discount" id="luxuryDiscount">
                    -0%
                </div>


                {{-- Image stage --}}
                <div class="luxury-image-stage" id="luxuryImageStage">

                    @foreach ($luxuryProducts as $index => $product)
                        <img src="{{ Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : asset('storage/uploads/products/' . $product->image) }}"
                            alt="{{ $product->product_name }}" class="luxury-image {{ $index === 0 ? 'active' : '' }}"
                            data-slot="{{ $index }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                    @endforeach

                    {{-- Image glow --}}
                    <div class="luxury-image-glow"></div>

                </div>


                {{-- =================================================
                    NAVIGATION
                ================================================== --}}
                <div class="luxury-navigation">

                    <button type="button" class="luxury-nav-button luxury-prev" aria-label="Sản phẩm trước">
                        <span>←</span>
                    </button>


                    <div class="luxury-progress">

                        <span class="luxury-current-number" id="luxuryCurrentNumber">
                            01
                        </span>

                        <span class="luxury-progress-line">
                            <span id="luxuryProgressBar"></span>
                        </span>

                        <span class="luxury-total-number">
                            {{ str_pad($luxuryProducts->count(), 2, '0', STR_PAD_LEFT) }}
                        </span>

                    </div>


                    <button type="button" class="luxury-nav-button luxury-next" aria-label="Sản phẩm tiếp theo">
                        <span>→</span>
                    </button>

                </div>


                {{-- =================================================
                    DOTS
                ================================================== --}}
                <div class="luxury-dots" id="luxuryDots">

                    @foreach ($luxuryProducts as $index => $product)
                        <button type="button" class="luxury-dot {{ $index === 0 ? 'active' : '' }}"
                            data-slide="{{ $index }}" aria-label="Xem sản phẩm {{ $index + 1 }}"></button>
                    @endforeach

                </div>

            </div>


            {{-- =================================================
                RIGHT - CONTENT
            ================================================== --}}
            <div class="luxury-content">

                <div class="luxury-content-inner" id="luxuryContent">


                    {{-- Product number --}}
                    <div class="luxury-product-number">
                        <span id="luxuryProductNumber">01</span>
                        <span class="luxury-number-separator">/</span>
                        <span>
                            {{ str_pad($luxuryProducts->count(), 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>


                    {{-- Product title --}}
                    <h2 class="luxury-title-product" id="luxuryProductName">
                        {{ $firstProduct->product_name }}
                    </h2>


                    {{-- Description --}}
                    <div class="luxury-desc" id="luxuryProductDescription">
                        {{ $firstProduct->short_description }}
                    </div>


                    {{-- Rating --}}
                    <div class="luxury-rating" id="luxuryRating">

                        @php
                            $initialRating = (int) round((float) ($firstProduct->reviews_avg_rating ?? 0));
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $initialRating ? 'fas' : 'far' }} fa-star luxury-star"></i>
                        @endfor

                        <span class="rating-text">

                            @if (($firstProduct->reviews_avg_rating ?? 0) > 0)
                                ({{ number_format($firstProduct->reviews_avg_rating, 1) }}/5)
                            @else
                                (Chưa có đánh giá)
                            @endif

                        </span>

                    </div>


                    {{-- Price --}}
                    <div class="luxury-product">

                        <div class="luxury-price">

                            <span id="luxuryProductPrice" class="luxury-current-price">
                                {{ number_format($firstProduct->list_price, 0, ',', '.') }} ₫
                            </span>


                            <span id="luxuryOldPrice" class="luxury-old-price" style="display:none;"></span>

                        </div>

                    </div>


                    {{-- CTA --}}
                    <a href="#" id="luxuryProductLink" class="lv-btn">

                        <span>Xem sản phẩm</span>

                        <span class="arrow">
                            →
                        </span>

                    </a>


                    {{-- Bottom decorative line --}}
                    <div class="luxury-content-line"></div>

                </div>

            </div>

        </div>
    @else
        <div class="text-center py-20">
            Chưa có sản phẩm.
        </div>

    @endif

</section>


<style>
    /* ============================================================
   LUXURY SECTION
============================================================ */

    .luxury-section {
        --luxury-blue: #0a2540;
        --luxury-blue-light: #1e6bff;
        --luxury-text: #0a2540;

        position: relative;
        overflow: hidden;

        min-height: 850px;

        padding: 130px 5vw 100px;

        background: #f8f9fb;

        font-family:
            "Helvetica Neue",
            Helvetica,
            Arial,
            sans-serif;

        isolation: isolate;
    }


    /* ============================================================
   DYNAMIC BACKGROUND
============================================================ */

    .luxury-bg {
        position: absolute;
        inset: -30px;

        z-index: -3;

        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;

        filter:
            blur(18px) saturate(0.65);

        transform: scale(1.08);

        opacity: 0.18;

        transition:
            background-image 0.7s ease,
            opacity 0.7s ease,
            transform 1.5s ease;
    }


    .luxury-section:hover .luxury-bg {
        transform: scale(1.12);
    }


    .luxury-bg-overlay {
        position: absolute;
        inset: 0;

        z-index: -2;

        background:
            linear-gradient(90deg,
                rgba(255, 255, 255, 0.98) 0%,
                rgba(255, 255, 255, 0.94) 42%,
                rgba(255, 255, 255, 0.82) 100%);
    }


    .luxury-bg-vignette {
        position: absolute;
        inset: 0;

        z-index: -1;

        pointer-events: none;

        background:
            radial-gradient(circle at 30% 50%,
                rgba(255, 255, 255, 0),
                rgba(255, 255, 255, 0.65) 80%);
    }


    /* ============================================================
   HEADER
============================================================ */

    .luxury-header {
        position: relative;

        max-width: 1560px;

        margin: 0 auto 75px;

        z-index: 5;
    }


    .luxury-tag {
        display: flex;
        align-items: center;
        gap: 12px;

        margin-bottom: 18px;

        color: #777;

        font-size: 11px;
        font-weight: 600;

        letter-spacing: 3px;
        text-transform: uppercase;
    }


    .luxury-tag-line {
        width: 38px;
        height: 1px;

        background: #0a2540;

        display: inline-block;
    }


    .luxury-section-title {
        max-width: 900px;

        margin: 0;

        color: #0a2540;

        font-size: clamp(38px, 5vw, 64px);

        font-weight: 500;

        line-height: 1.08;

        letter-spacing: -2px;
    }


    .luxury-section-title span {
        display: block;

        background:
            linear-gradient(110deg,
                #0a2540,
                #174d99,
                #1e6bff,
                #0a2540);

        background-size: 300% 100%;

        -webkit-background-clip: text;
        background-clip: text;

        -webkit-text-fill-color: transparent;

        animation:
            luxuryTitleGradient 7s ease infinite;
    }


    @keyframes luxuryTitleGradient {

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


    .luxury-section-sub {
        max-width: 620px;

        margin: 20px 0 0;

        color: #777;

        font-size: 15px;

        line-height: 1.7;
    }


    /* ============================================================
   MAIN CONTAINER
============================================================ */

    .luxury-container {
        position: relative;
        z-index: 3;

        max-width: 1560px;

        margin: auto;

        display: grid;

        grid-template-columns:
            minmax(0, 1.05fr) minmax(0, 0.95fr);

        align-items: center;

        gap: clamp(50px, 7vw, 130px);
    }


    /* ============================================================
   IMAGE AREA
============================================================ */

    .luxury-images {
        position: relative;

        min-height: 540px;

        perspective: 1800px;
    }


    /* Watermark */

    .luxury-watermark {
        position: absolute;

        top: 50%;
        left: 50%;

        transform:
            translate(-50%, -50%) rotate(-90deg);

        color: rgba(10, 37, 64, 0.035);

        font-size: clamp(80px, 12vw, 180px);

        font-weight: 800;

        letter-spacing: 15px;

        white-space: nowrap;

        pointer-events: none;

        z-index: 0;
    }


    /* ============================================================
   DISCOUNT
============================================================ */

    .luxury-discount {
        position: absolute;

        top: 15px;
        left: 15px;

        z-index: 50;

        display: none;

        padding: 9px 17px;

        border-radius: 999px;

        color: #fff;

        background:
            linear-gradient(135deg,
                #0a2540,
                #1e6bff);

        box-shadow:
            0 15px 35px rgba(30, 107, 255, 0.25);

        font-size: 11px;

        font-weight: 700;

        letter-spacing: 1.5px;

        backdrop-filter: blur(8px);

        animation:
            luxuryBadgeIn 0.5s ease both;
    }


    @keyframes luxuryBadgeIn {

        from {
            opacity: 0;
            transform: translateY(-10px) scale(0.9);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

    }


    /* ============================================================
   IMAGE STAGE
============================================================ */

    .luxury-image-stage {
        position: relative;

        width: 100%;
        height: 520px;

        display: flex;

        align-items: center;
        justify-content: center;

        transform-style: preserve-3d;

        z-index: 5;
    }


    /* Image */

    .luxury-image {
        position: absolute;

        top: 50%;
        left: 50%;

        width: min(330px, 42%);

        height: 460px;

        object-fit: cover;

        border-radius: 4px;

        transform-origin: center center;

        transform:
            translate(-50%, -50%) translateX(-220px) scale(0.70) rotateY(-48deg);

        opacity: 0.22;

        filter:
            blur(1.5px) saturate(0.75);

        box-shadow:
            0 35px 80px rgba(10, 37, 64, 0.12);

        transition:
            transform 0.85s cubic-bezier(.16, 1, .3, 1),
            opacity 0.7s ease,
            filter 0.7s ease,
            box-shadow 0.7s ease;

        will-change:
            transform,
            opacity;

        backface-visibility: hidden;

        cursor: pointer;
    }


    /* Active */

    .luxury-image.active {
        transform:
            translate(-50%, -50%) translateX(30px) scale(1) rotateY(0deg);

        opacity: 1;

        filter:
            blur(0) saturate(1);

        z-index: 10;

        box-shadow:
            0 45px 90px rgba(10, 37, 64, 0.20);
    }


    /* Second image */

    .luxury-image:nth-child(2):not(.active) {
        transform:
            translate(-50%, -50%) translateX(-155px) scale(0.82) rotateY(-28deg);

        opacity: 0.45;

        z-index: 4;
    }


    /* Third image */

    .luxury-image:nth-child(3):not(.active) {
        transform:
            translate(-50%, -50%) translateX(-260px) scale(0.67) rotateY(-45deg);

        opacity: 0.22;

        z-index: 3;
    }


    /* Fourth image */

    .luxury-image:nth-child(4):not(.active) {
        transform:
            translate(-50%, -50%) translateX(-330px) scale(0.55) rotateY(-58deg);

        opacity: 0.12;

        z-index: 2;
    }


    /* Hover */

    .luxury-image.active:hover {
        transform:
            translate(-50%, -50%) translateX(30px) scale(1.025) rotateY(0deg);

        box-shadow:
            0 50px 100px rgba(10, 37, 64, 0.25);
    }


    /* ============================================================
   SLIDE ANIMATION
============================================================ */

    .luxury-image-stage.is-next .luxury-image {
        opacity: 0;

        transform:
            translate(-50%, -50%) translateX(-260px) scale(0.68) rotateY(-55deg);
    }


    .luxury-image-stage.is-prev .luxury-image {
        opacity: 0;

        transform:
            translate(-50%, -50%) translateX(260px) scale(0.68) rotateY(55deg);
    }


    /* ============================================================
   IMAGE GLOW
============================================================ */

    .luxury-image-glow {
        position: absolute;

        left: 50%;
        top: 58%;

        width: 360px;
        height: 160px;

        transform:
            translate(-50%, -50%);

        border-radius: 50%;

        background:
            radial-gradient(ellipse,
                rgba(30, 107, 255, 0.17),
                rgba(30, 107, 255, 0) 70%);

        filter: blur(25px);

        z-index: -1;

        pointer-events: none;
    }


    /* ============================================================
   NAVIGATION
============================================================ */

    .luxury-navigation {
        position: absolute;

        left: 50%;
        bottom: 0;

        transform: translateX(-50%);

        width: 100%;

        display: flex;

        align-items: center;
        justify-content: center;

        gap: 25px;

        z-index: 30;
    }


    .luxury-nav-button {
        width: 48px;
        height: 48px;

        display: flex;

        align-items: center;
        justify-content: center;

        border: 1px solid rgba(10, 37, 64, 0.2);

        border-radius: 50%;

        background: rgba(255, 255, 255, 0.6);

        color: #0a2540;

        font-size: 18px;

        cursor: pointer;

        transition:
            transform 0.3s ease,
            background 0.3s ease,
            color 0.3s ease,
            box-shadow 0.3s ease;

        backdrop-filter: blur(12px);
    }


    .luxury-nav-button:hover {
        background: #0a2540;

        color: #fff;

        transform: scale(1.08);

        box-shadow:
            0 12px 30px rgba(10, 37, 64, 0.18);
    }


    .luxury-nav-button:active {
        transform: scale(0.94);
    }


    .luxury-nav-button span {
        transition:
            transform 0.3s ease;
    }


    .luxury-nav-button:hover span {
        transform: translateX(2px);
    }


    /* ============================================================
   PROGRESS
============================================================ */

    .luxury-progress {
        display: flex;

        align-items: center;

        gap: 12px;

        min-width: 145px;
    }


    .luxury-current-number,
    .luxury-total-number {
        font-size: 11px;

        font-weight: 600;

        letter-spacing: 1px;

        color: #0a2540;
    }


    .luxury-total-number {
        color: #999;
    }


    .luxury-number-separator {
        color: #aaa;
    }


    .luxury-progress-line {
        position: relative;

        width: 70px;
        height: 1px;

        overflow: hidden;

        background: rgba(10, 37, 64, 0.15);
    }


    .luxury-progress-line span {
        position: absolute;

        left: 0;
        top: 0;

        width: 25%;
        height: 100%;

        background: #0a2540;

        transition:
            width 0.6s cubic-bezier(.16, 1, .3, 1);
    }


    /* ============================================================
   DOTS
============================================================ */

    .luxury-dots {
        position: absolute;

        right: 30px;
        bottom: 5px;

        display: flex;

        align-items: center;

        gap: 7px;

        z-index: 30;
    }


    .luxury-dot {
        width: 6px;
        height: 6px;

        padding: 0;

        border: 0;

        border-radius: 50%;

        background: rgba(10, 37, 64, 0.2);

        cursor: pointer;

        transition:
            width 0.35s ease,
            background 0.35s ease,
            transform 0.35s ease;
    }


    .luxury-dot.active {
        width: 26px;

        border-radius: 999px;

        background: #0a2540;
    }


    /* ============================================================
   CONTENT
============================================================ */

    .luxury-content {
        position: relative;

        min-width: 0;
    }


    .luxury-content-inner {
        max-width: 620px;

        transition:
            opacity 0.35s ease,
            transform 0.5s cubic-bezier(.16, 1, .3, 1);
    }


    .luxury-content-inner.is-changing {
        opacity: 0;

        transform:
            translateY(18px);
    }


    .luxury-product-number {
        display: flex;

        align-items: center;

        gap: 6px;

        margin-bottom: 18px;

        color: #888;

        font-size: 11px;

        letter-spacing: 2px;
    }


    .luxury-product-number #luxuryProductNumber {
        color: #0a2540;

        font-weight: 700;
    }


    .luxury-number-separator {
        color: #bbb;
    }


    /* ============================================================
   PRODUCT TITLE
============================================================ */

    .luxury-title-product {
        position: relative;

        margin: 0 0 25px;

        color: #0a2540;

        font-size: clamp(36px, 4vw, 58px);

        font-weight: 500;

        line-height: 1.08;

        letter-spacing: -1.8px;

        max-width: 600px;

        background:
            linear-gradient(110deg,
                #0a2540 0%,
                #0f3c91 40%,
                #1e6bff 65%,
                #0a2540 100%);

        background-size: 220% 100%;

        -webkit-background-clip: text;
        background-clip: text;

        -webkit-text-fill-color: transparent;

        animation:
            luxuryProductGradient 8s ease infinite;
    }


    @keyframes luxuryProductGradient {

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


    /* ============================================================
   DESCRIPTION
============================================================ */

    .luxury-desc {
        max-width: 570px;

        margin-bottom: 25px;

        color: #606060;

        font-size: 15px;

        line-height: 1.8;

        display: -webkit-box;

        -webkit-line-clamp: 4;

        -webkit-box-orient: vertical;

        overflow: hidden;
    }


    /* ============================================================
   RATING
============================================================ */

    .luxury-rating {
        display: flex;

        align-items: center;

        gap: 4px;

        margin-bottom: 22px;
    }


    .luxury-star {
        color: #0f3c91;

        font-size: 13px;

        filter:
            drop-shadow(0 2px 3px rgba(15, 60, 145, 0.15));
    }


    .luxury-rating .rating-text {
        margin-left: 7px;

        color: #777;

        font-size: 12px;
    }


    /* ============================================================
   PRICE
============================================================ */

    .luxury-price {
        display: flex;

        align-items: baseline;

        gap: 13px;

        min-height: 38px;

        margin-top: 10px;
    }


    .luxury-current-price {
        color: #d92323;

        font-size: 25px;

        font-weight: 700;

        letter-spacing: -0.5px;
    }


    .luxury-old-price {
        position: relative;

        color: #999;

        font-size: 14px;
    }


    .luxury-old-price::after {
        content: "";

        position: absolute;

        left: 0;
        right: 0;

        top: 50%;

        height: 1px;

        background: #999;
    }


    /* ============================================================
   BUTTON
============================================================ */

    .lv-btn {
        position: relative;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: 15px;

        margin-top: 35px;

        padding: 15px 34px;

        overflow: hidden;

        background: #0a2540;

        color: #fff;

        text-decoration: none;

        font-size: 12px;

        font-weight: 500;

        letter-spacing: 2px;

        text-transform: uppercase;

        transition:
            color 0.35s ease,
            transform 0.35s ease,
            box-shadow 0.35s ease;
    }


    .lv-btn::before {
        content: "";

        position: absolute;

        left: -120%;

        top: 0;

        width: 100%;
        height: 100%;

        background:
            linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.18),
                transparent);

        transform: skewX(-20deg);

        transition:
            left 0.6s ease;
    }


    .lv-btn:hover {
        color: #fff;

        transform: translateY(-2px);

        box-shadow:
            0 15px 35px rgba(10, 37, 64, 0.2);
    }


    .lv-btn:hover::before {
        left: 120%;
    }


    .lv-btn .arrow {
        display: inline-block;

        transition:
            transform 0.35s ease;
    }


    .lv-btn:hover .arrow {
        transform:
            translateX(5px);
    }


    /* ============================================================
   DECORATIVE LINE
============================================================ */

    .luxury-content-line {
        width: 100px;
        height: 1px;

        margin-top: 55px;

        background:
            linear-gradient(90deg,
                #0a2540,
                transparent);
    }


    /* ============================================================
   REVEAL
============================================================ */

    .luxury-header,
    .luxury-images,
    .luxury-content {
        opacity: 0;

        transition:
            opacity 1s ease,
            transform 1s cubic-bezier(.16, 1, .3, 1),
            filter 1s ease;

        filter: blur(8px);
    }


    .luxury-header {
        transform:
            translateY(35px);
    }


    .luxury-images {
        transform:
            translateX(-70px);
    }


    .luxury-content {
        transform:
            translateX(70px);
    }


    .luxury-section.is-visible .luxury-header,
    .luxury-section.is-visible .luxury-images,
    .luxury-section.is-visible .luxury-content {
        opacity: 1;

        filter: blur(0);

        transform:
            translate(0, 0);
    }


    .luxury-section.is-visible .luxury-images {
        transition-delay: 0.15s;
    }


    .luxury-section.is-visible .luxury-content {
        transition-delay: 0.3s;
    }


    /* ============================================================
   RESPONSIVE
============================================================ */

    @media (max-width: 1100px) {

        .luxury-section {
            padding:
                100px 35px 80px;
        }

        .luxury-container {
            gap: 35px;
        }

        .luxury-image {
            width: 280px;
            height: 420px;
        }

    }


    @media (max-width: 850px) {

        .luxury-section {
            padding:
                80px 25px 90px;
        }

        .luxury-header {
            margin-bottom: 50px;
        }

        .luxury-section-title {
            font-size: 42px;

            letter-spacing: -1.2px;
        }

        .luxury-container {
            grid-template-columns: 1fr;

            gap: 55px;
        }

        .luxury-images {
            min-height: 500px;
        }

        .luxury-image-stage {
            height: 470px;
        }

        .luxury-content {
            padding:
                0 10px;
        }

        .luxury-dots {
            right: 15px;
        }

    }


    @media (max-width: 550px) {

        .luxury-section {
            min-height: auto;

            padding:
                65px 18px 70px;
        }

        .luxury-section-title {
            font-size: 34px;
        }

        .luxury-section-sub {
            font-size: 14px;
        }

        .luxury-images {
            min-height: 430px;
        }

        .luxury-image-stage {
            height: 400px;
        }

        .luxury-image {
            width: 220px;
            height: 330px;
        }

        .luxury-image.active {
            transform:
                translate(-50%, -50%) translateX(15px) scale(1) rotateY(0);
        }

        .luxury-image:nth-child(2):not(.active) {
            transform:
                translate(-50%, -50%) translateX(-100px) scale(0.78) rotateY(-25deg);
        }

        .luxury-image:nth-child(3):not(.active) {
            transform:
                translate(-50%, -50%) translateX(-170px) scale(0.62) rotateY(-40deg);
        }

        .luxury-image:nth-child(4):not(.active) {
            transform:
                translate(-50%, -50%) translateX(-220px) scale(0.5) rotateY(-50deg);
        }

        .luxury-navigation {
            bottom: -5px;
        }

        .luxury-progress {
            min-width: 100px;
        }

        .luxury-progress-line {
            width: 40px;
        }

        .luxury-dots {
            position: relative;

            right: auto;
            bottom: auto;

            justify-content: center;

            margin-top: 25px;
        }

        .luxury-title-product {
            font-size: 36px;
        }

        .luxury-desc {
            font-size: 14px;
        }

        .luxury-current-price {
            font-size: 22px;
        }

    }


    /* ============================================================
   REDUCED MOTION
============================================================ */

    @media (prefers-reduced-motion: reduce) {

        .luxury-section *,
        .luxury-section *::before,
        .luxury-section *::after {
            animation-duration: 0.01ms !important;

            animation-iteration-count: 1 !important;

            transition-duration: 0.01ms !important;
        }

    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ========================================================
           DATA
        ======================================================== */

        const products = @json($luxuryProducts);

        if (!Array.isArray(products) || products.length === 0) {
            return;
        }


        /* ========================================================
           ELEMENTS
        ======================================================== */

        const section =
            document.getElementById('luxuryCollection');

        const imageStage =
            document.getElementById('luxuryImageStage');

        const images =
            Array.from(
                document.querySelectorAll(
                    '#luxuryImageStage .luxury-image'
                )
            );

        const title =
            document.getElementById('luxuryProductName');

        const description =
            document.getElementById(
                'luxuryProductDescription'
            );

        const rating =
            document.getElementById('luxuryRating');

        const currentPrice =
            document.getElementById(
                'luxuryProductPrice'
            );

        const oldPrice =
            document.getElementById(
                'luxuryOldPrice'
            );

        const discountBadge =
            document.getElementById(
                'luxuryDiscount'
            );

        const productNumber =
            document.getElementById(
                'luxuryProductNumber'
            );

        const currentNumber =
            document.getElementById(
                'luxuryCurrentNumber'
            );

        const progressBar =
            document.getElementById(
                'luxuryProgressBar'
            );

        const productLink =
            document.getElementById(
                'luxuryProductLink'
            );

        const bg =
            document.getElementById(
                'luxuryBg'
            );

        const content =
            document.getElementById(
                'luxuryContent'
            );

        const dots =
            Array.from(
                document.querySelectorAll(
                    '#luxuryDots .luxury-dot'
                )
            );

        const nextButton =
            document.querySelector(
                '#luxuryCollection .luxury-next'
            );

        const prevButton =
            document.querySelector(
                '#luxuryCollection .luxury-prev'
            );


        /* ========================================================
           STATE
        ======================================================== */

        let currentIndex = 0;

        let isAnimating = false;

        let autoplayTimer = null;

        const animationDuration = 650;

        const autoplayDuration = 5500;


        /* ========================================================
           IMAGE URL
        ======================================================== */

        function getImageUrl(product) {

            if (!product || !product.image) {
                return '';
            }

            const image = String(product.image);

            if (
                image.startsWith('http://') ||
                image.startsWith('https://')
            ) {
                return image;
            }

            return '/storage/uploads/products/' + image;
        }


        /* ========================================================
           FORMAT PRICE
        ======================================================== */

        function formatPrice(value) {

            return new Intl.NumberFormat('vi-VN')
                .format(Number(value || 0)) + ' ₫';

        }


        /* ========================================================
           CALCULATE DISCOUNT
        ======================================================== */

        function calculatePrice(product) {

            const listPrice =
                Number(product.list_price || 0);

            let discountedPrice = listPrice;

            let percentOff = 0;

            let hasDiscount = false;

            const discount = product.discount;


            if (
                discount &&
                listPrice > 0
            ) {

                const amount =
                    Number(
                        discount.discount_amount || 0
                    );

                const isFixed =
                    Number(
                        discount.is_fixed || 0
                    );


                if (isFixed === 0) {

                    percentOff =
                        Math.min(
                            100,
                            Math.round(amount)
                        );

                    discountedPrice =
                        Math.max(
                            0,
                            listPrice *
                            (1 - amount / 100)
                        );

                } else {

                    discountedPrice =
                        Math.max(
                            0,
                            listPrice - amount
                        );

                    percentOff =
                        Math.min(
                            100,
                            Math.round(
                                (amount / listPrice) * 100
                            )
                        );

                }


                hasDiscount =
                    discountedPrice < listPrice;
            }


            return {
                listPrice,
                discountedPrice,
                percentOff,
                hasDiscount
            };

        }


        /* ========================================================
           UPDATE RATING
        ======================================================== */

        function updateRating(product) {

            if (!rating) {
                return;
            }

            const avgRating =
                Number(
                    product.reviews_avg_rating || 0
                );

            const rounded =
                Math.round(avgRating);


            let html = '';


            for (let i = 1; i <= 5; i++) {

                html +=
                    i <= rounded ?
                    '<i class="fas fa-star luxury-star"></i>' :
                    '<i class="far fa-star luxury-star"></i>';

            }


            html += `
            <span class="rating-text">
                ${
                    avgRating > 0
                        ? `(${avgRating.toFixed(1)}/5)`
                        : '(Chưa có đánh giá)'
                }
            </span>
        `;


            rating.innerHTML = html;

        }


        /* ========================================================
           UPDATE PRICE
        ======================================================== */

        function updatePrice(product) {

            const {
                listPrice,
                discountedPrice,
                percentOff,
                hasDiscount
            } = calculatePrice(product);


            if (currentPrice) {

                currentPrice.textContent =
                    formatPrice(
                        discountedPrice
                    );

            }


            if (oldPrice) {

                if (hasDiscount) {

                    oldPrice.style.display =
                        'inline-block';

                    oldPrice.textContent =
                        formatPrice(
                            listPrice
                        );

                } else {

                    oldPrice.style.display =
                        'none';

                    oldPrice.textContent = '';

                }

            }


            if (discountBadge) {

                if (hasDiscount) {

                    discountBadge.style.display =
                        'block';


                    const discount =
                        product.discount;


                    if (
                        discount &&
                        Number(discount.is_fixed) === 1
                    ) {

                        discountBadge.textContent =
                            '-' +
                            formatPrice(
                                discount.discount_amount
                            );

                    } else {

                        discountBadge.textContent =
                            '-' +
                            percentOff +
                            '%';

                    }

                } else {

                    discountBadge.style.display =
                        'none';

                }

            }

        }


        /* ========================================================
           UPDATE BACKGROUND
        ======================================================== */

        function updateBackground(product) {

            if (!bg || !product) {
                return;
            }

            const imageUrl =
                getImageUrl(product);


            if (!imageUrl) {
                return;
            }


            bg.style.backgroundImage =
                `url("${imageUrl}")`;

        }


        /* ========================================================
           UPDATE IMAGES
        ======================================================== */

        function updateImages(index) {

            if (!images.length) {
                return;
            }


            images.forEach(function(img, slot) {

                const productIndex =
                    (index + slot) %
                    products.length;


                const product =
                    products[productIndex];


                if (!product) {
                    return;
                }


                img.src =
                    getImageUrl(product);

                img.alt =
                    product.product_name || '';

                img.classList.toggle(
                    'active',
                    slot === 0
                );

            });

        }


        /* ========================================================
           UPDATE DOTS
        ======================================================== */

        function updateDots(index) {

            dots.forEach(function(dot, i) {

                dot.classList.toggle(
                    'active',
                    i === index
                );

            });

        }


        /* ========================================================
           UPDATE NUMBER
        ======================================================== */

        function updateNumbers(index) {

            const number =
                String(index + 1)
                .padStart(2, '0');


            if (productNumber) {
                productNumber.textContent =
                    number;
            }


            if (currentNumber) {
                currentNumber.textContent =
                    number;
            }


            if (progressBar) {

                const progress =
                    ((index + 1) /
                        products.length) *
                    100;

                progressBar.style.width =
                    progress + '%';

            }

        }


        /* ========================================================
           UPDATE CONTENT
        ======================================================== */

        function updateContent(index) {

            const product =
                products[index];


            if (!product) {
                return;
            }


            if (title) {

                title.textContent =
                    product.product_name || '';

            }


            if (description) {

                description.textContent =
                    product.short_description || '';

            }


            updateRating(product);

            updatePrice(product);

            updateImages(index);

            updateDots(index);

            updateNumbers(index);

            updateBackground(product);


            /*
             * Nếu sau này bạn có route chi tiết sản phẩm,
             * có thể thay href ở đây bằng route/product URL.
             */
            if (productLink) {

                if (product.id) {

                    productLink.dataset.productId =
                        product.id;

                }

            }

        }


        /* ========================================================
           SLIDE
        ======================================================== */

        function slide(direction = 'next') {

            if (
                isAnimating ||
                products.length <= 1
            ) {
                return;
            }


            isAnimating = true;


            /*
             * Animation OUT
             */

            imageStage.classList.remove(
                'is-next',
                'is-prev'
            );


            void imageStage.offsetWidth;


            imageStage.classList.add(
                direction === 'next' ?
                'is-next' :
                'is-prev'
            );


            if (content) {

                content.classList.add(
                    'is-changing'
                );

            }


            setTimeout(function() {

                if (direction === 'next') {

                    currentIndex =
                        (currentIndex + 1) %
                        products.length;

                } else {

                    currentIndex =
                        (currentIndex - 1 +
                            products.length) %
                        products.length;

                }


                /*
                 * Update data
                 */

                updateContent(
                    currentIndex
                );


                /*
                 * Reset animation
                 */

                imageStage.classList.remove(
                    'is-next',
                    'is-prev'
                );


                /*
                 * Animation IN
                 */

                requestAnimationFrame(function() {

                    requestAnimationFrame(function() {

                        if (content) {

                            content.classList.remove(
                                'is-changing'
                            );

                        }

                    });

                });


                isAnimating = false;

            }, animationDuration);

        }


        /* ========================================================
           BUTTON EVENTS
        ======================================================== */

        if (nextButton) {

            nextButton.addEventListener(
                'click',
                function() {

                    slide('next');

                    restartAutoplay();

                }
            );

        }


        if (prevButton) {

            prevButton.addEventListener(
                'click',
                function() {

                    slide('prev');

                    restartAutoplay();

                }
            );

        }


        /* ========================================================
           DOT EVENTS
        ======================================================== */

        dots.forEach(function(dot) {

            dot.addEventListener(
                'click',
                function() {

                    const target =
                        Number(
                            dot.dataset.slide
                        );


                    if (
                        target === currentIndex ||
                        isAnimating ||
                        target < 0 ||
                        target >= products.length
                    ) {
                        return;
                    }


                    const direction =
                        target > currentIndex ?
                        'next' :
                        'prev';


                    /*
                     * Nếu click dot xa hơn 1 sản phẩm,
                     * đổi trực tiếp index sau animation.
                     */

                    isAnimating = true;


                    imageStage.classList.add(
                        direction === 'next' ?
                        'is-next' :
                        'is-prev'
                    );


                    if (content) {

                        content.classList.add(
                            'is-changing'
                        );

                    }


                    setTimeout(function() {

                        currentIndex =
                            target;


                        updateContent(
                            currentIndex
                        );


                        imageStage.classList.remove(
                            'is-next',
                            'is-prev'
                        );


                        requestAnimationFrame(
                            function() {

                                if (content) {

                                    content.classList.remove(
                                        'is-changing'
                                    );

                                }

                            }
                        );


                        isAnimating = false;

                    }, animationDuration);


                    restartAutoplay();

                }
            );

        });


        /* ========================================================
           AUTOPLAY
        ======================================================== */

        function startAutoplay() {

            stopAutoplay();


            if (products.length <= 1) {
                return;
            }


            autoplayTimer =
                setInterval(function() {

                    slide('next');

                }, autoplayDuration);

        }


        function stopAutoplay() {

            if (autoplayTimer) {

                clearInterval(
                    autoplayTimer
                );

                autoplayTimer = null;

            }

        }


        function restartAutoplay() {

            stopAutoplay();

            startAutoplay();

        }


        /* ========================================================
           PAUSE WHEN HOVER
        ======================================================== */

        section.addEventListener(
            'mouseenter',
            function() {

                stopAutoplay();

            }
        );


        section.addEventListener(
            'mouseleave',
            function() {

                startAutoplay();

            }
        );


        /* ========================================================
           KEYBOARD
        ======================================================== */

        document.addEventListener(
            'keydown',
            function(event) {

                /*
                 * Không bắt phím khi user đang nhập form
                 */

                const tag =
                    document.activeElement?.tagName;


                if (
                    tag === 'INPUT' ||
                    tag === 'TEXTAREA' ||
                    tag === 'SELECT'
                ) {
                    return;
                }


                if (event.key === 'ArrowRight') {

                    slide('next');

                    restartAutoplay();

                }


                if (event.key === 'ArrowLeft') {

                    slide('prev');

                    restartAutoplay();

                }

            }
        );


        /* ========================================================
           TOUCH / SWIPE
        ======================================================== */

        let touchStartX = 0;

        let touchEndX = 0;


        section.addEventListener(
            'touchstart',
            function(event) {

                touchStartX =
                    event.changedTouches[0].screenX;

            }, {
                passive: true
            }
        );


        section.addEventListener(
            'touchend',
            function(event) {

                touchEndX =
                    event.changedTouches[0].screenX;


                const distance =
                    touchEndX -
                    touchStartX;


                if (Math.abs(distance) < 50) {
                    return;
                }


                if (distance < 0) {

                    slide('next');

                } else {

                    slide('prev');

                }


                restartAutoplay();

            }, {
                passive: true
            }
        );


        /* ========================================================
           IMAGE CLICK
        ======================================================== */

        images.forEach(function(image, slot) {

            image.addEventListener(
                'click',
                function() {

                    if (slot === 0) {
                        return;
                    }


                    /*
                     * Click ảnh phía sau để chuyển tới ảnh đó.
                     */

                    const target =
                        (currentIndex + slot) %
                        products.length;


                    if (target === currentIndex) {
                        return;
                    }


                    currentIndex =
                        target;


                    updateContent(
                        currentIndex
                    );


                    restartAutoplay();

                }
            );

        });


        /* ========================================================
           REVEAL ON SCROLL
        ======================================================== */

        const observer =
            new IntersectionObserver(
                function(entries) {

                    entries.forEach(
                        function(entry) {

                            if (
                                entry.isIntersecting
                            ) {

                                section.classList.add(
                                    'is-visible'
                                );

                                observer.unobserve(
                                    section
                                );

                            }

                        }
                    );

                }, {
                    threshold: 0.15
                }
            );


        observer.observe(section);


        /* ========================================================
           INITIALIZE
        ======================================================== */

        updateContent(0);

        startAutoplay();

    });
</script>
