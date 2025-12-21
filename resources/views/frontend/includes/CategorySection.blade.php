<section class="luxury-hero">
    @foreach ($heroCategories as $index => $category)
        <div class="luxury-hero-slide {{ $index === 0 ? 'active' : '' }}"
            style="background-image: url('{{ Str::startsWith($category->image, ['http://', 'https://'])
                ? $category->image
                : asset('storage/uploads/categories/' . $category->image) }}')">

            <div class="luxury-overlay">
                <div class="luxury-content">
                    <span class="luxury-subtitle ">LWShop · Luxury Fashion</span>
                    <h1 class="luxury-title-category ">
                        {{ $category->categories_text }}
                    </h1>

                    <a href="#" class="luxury-btn">Khám phá bộ sưu tập</a>
                </div>
            </div>

        </div>
    @endforeach
</section>
<style>
    .luxury-title-category {
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

    /* =====================
HERO WRAPPER
===================== */
    .luxury-hero {
        width: 100%;
        min-height: 85vh;
        max-height: 980px;
        position: relative;
        overflow: hidden;
        background: #000;
    }

    .luxury-hero-slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;

        opacity: 0;
        transition: opacity 3s ease-in-out;
    }

    /* MACRO IMAGE EFFECT */
    .luxury-hero-slide::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: inherit;
        background-size: cover;
        background-position: center;
        transform: scale(1);
        transition: transform 8s ease;
    }

    /* ACTIVE */
    .luxury-hero-slide.active {
        opacity: 1;
        z-index: 1;
    }

    .luxury-hero-slide.active::before {
        transform: scale(1.08);
        /* ZOOM MACRO */
    }

    /* =====================
OVERLAY
===================== */
    .luxury-overlay {
        position: absolute;
        inset: 0;
        z-index: 2;
        background: linear-gradient(90deg,
                rgba(0, 0, 0, 0.8) 0%,
                rgba(0, 0, 0, 0.5) 40%,
                rgba(0, 0, 0, 0.25) 70%,
                rgba(0, 0, 0, 0) 100%);
        display: flex;
        align-items: center;
    }

    /* =====================
CONTENT (TEXT ANIMATION)
===================== */
    .luxury-content {
        padding-left: clamp(32px, 10vw, 140px);
        max-width: 640px;
        color: #fff;
    }

    .luxury-subtitle,
    .luxury-title,
    .luxury-btn {
        opacity: 0;
        transform: translateY(30px);
    }

    /* ACTIVE TEXT */
    .luxury-hero-slide.active .luxury-subtitle {
        animation: fadeUp 1.2s ease forwards;
        animation-delay: 0.6s;
    }

    .luxury-hero-slide.active .luxury-title {
        animation: fadeUp 1.4s ease forwards;
        animation-delay: 1s;
    }

    .luxury-hero-slide.active .luxury-btn {
        animation: fadeUp 1.6s ease forwards;
        animation-delay: 1.4s;
    }

    /* =====================
TEXT STYLE
===================== */
    .luxury-subtitle {
        font-size: 11px;
        letter-spacing: 7px;
        text-transform: uppercase;
        opacity: 0.85;
        margin-bottom: 32px;
    }

    .luxury-title {
        font-size: 60px;
        font-weight: 300;
        line-height: 1.12;
        margin-bottom: 36px;
    }

    /* =====================
BUTTON
===================== */
    .luxury-btn {
        padding: 16px 52px;
        border: 1px solid #fff;
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        letter-spacing: 3px;
        text-transform: uppercase;
        transition: all 0.35s ease;
        margin-top: 20px;
    }

    .luxury-btn:hover {
        background: #fff;
        color: #000;
    }

    /* =====================
ANIMATION KEYFRAMES
===================== */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* =====================
RESPONSIVE
===================== */
    @media (max-width: 992px) {
        .luxury-title {
            font-size: 44px;
        }
    }

    @media (max-width: 576px) {
        .luxury-title {
            font-size: 34px;
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const slides = document.querySelectorAll(".luxury-hero-slide");
        let current = 0;

        setInterval(() => {
            slides[current].classList.remove("active");

            current = (current + 1) % slides.length;

            slides[current].classList.add("active");
        }, 5000); // 5s / slide (3s fade + 2s đứng)
    });
</script>
