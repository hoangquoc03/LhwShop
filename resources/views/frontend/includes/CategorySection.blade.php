<section class="luxury-hero">
    @foreach ($heroCategories as $category)
        <div class="luxury-hero-slide">

            <img src="{{ Str::startsWith($category->image, ['http://', 'https://'])
                ? $category->image
                : asset('storage/uploads/categories/' . $category->image) }}"
                alt="{{ $category->categories_text }}" class="luxury-hero-img">

            <div class="luxury-overlay">
                <span class="luxury-subtitle">Luxury Collection</span>
                <h1 class="luxury-title">{{ $category->categories_text }}</h1>

                <a href="#" class="luxury-btn">Khám phá</a>
            </div>

        </div>
    @break

    {{-- chỉ lấy 1 hero đầu --}}
@endforeach
</section>


<style>
/* HERO WRAPPER */
.luxury-hero {
    width: 100%;
    height: 100vh;
    position: relative;
    overflow: hidden;
}

/* SLIDE */
.luxury-hero-slide {
    width: 100%;
    height: 100%;
    position: relative;
}

/* IMAGE – QUAN TRỌNG NHẤT */
.luxury-hero-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* KHÔNG VỠ */
    object-position: center;
    transform: scale(1.03);
}

/* OVERLAY */
.luxury-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom,
            rgba(0, 0, 0, 0.25),
            rgba(0, 0, 0, 0.6));
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-left: 8%;
    color: #fff;
}

/* TEXT */
.luxury-subtitle {
    font-size: 13px;
    letter-spacing: 5px;
    text-transform: uppercase;
    opacity: 0.85;
    margin-bottom: 18px;
}

.luxury-title {
    font-size: 64px;
    font-weight: 400;
    max-width: 600px;
    line-height: 1.1;
    margin-bottom: 32px;
}

/* BUTTON */
.luxury-btn {
    padding: 14px 42px;
    border: 1px solid rgba(255, 255, 255, 0.8);
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    letter-spacing: 2px;
    width: fit-content;
    transition: all 0.4s ease;
}

.luxury-btn:hover {
    background: #fff;
    color: #000;
}
</style>
