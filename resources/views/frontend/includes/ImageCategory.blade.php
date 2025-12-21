<section class="supplier-editorial-flagship">
    <div class="editorial-slider">
        @foreach ($ImageCategories as $index => $item)
            <article class="editorial-row" style="--scroll-offset: {{ $index * 0.05 }};">
                <div class="editorial-image">
                    <img
                        src="{{ Str::startsWith($item->image, ['http://', 'https://'])
                            ? $item->image
                            : asset('storage/uploads/suppliers/' . $item->image) }}">
                </div>
                <div class="editorial-text">
                    <span class="editorial-index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h2>{{ $item->supplier_text }}</h2>
                    <p>Bộ sưu tập thể hiện tinh thần tối giản, phom dáng tinh tế và chất liệu cao cấp – dành cho phong
                        cách sống hiện đại.</p>
                    <a href="#">Khám phá bộ sưu tập</a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<style>
    .supplier-editorial-flagship {
        margin-top: 50px;
    }

    .editorial-slider {
        position: relative;
        width: 100%;
        height: 80vh;
        /* chiều cao hero */
    }

    .editorial-row {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 60px;
        align-items: center;
        height: 100%;
        opacity: 0;
        pointer-events: none;
        transition: opacity 1.6s ease, transform 8s ease;
    }

    .editorial-row.active {
        opacity: 1;
        pointer-events: auto;
        transform: scale(1.02);
    }

    .editorial-image {
        border-radius: 28px;
        overflow: hidden;
        width: 100%;
        height: 100%;
        /* full row height */
        transform: scale(0.95);
    }

    .editorial-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* ảnh phủ đầy container */
        transition: transform 8s ease;
    }

    .editorial-row.active .editorial-image img {
        transform: scale(1.12);
    }

    .editorial-text {
        opacity: 0;
        transform: translateY(40px);
        transition: all 1.4s ease;
    }

    .editorial-row.active .editorial-text {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .editorial-row {
            grid-template-columns: 1fr;
            height: auto;
            position: relative;
        }

        .editorial-image {
            height: 60vh;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const rows = document.querySelectorAll(".editorial-row");
        let current = 0;

        function showSlide(index) {
            rows.forEach((row, i) => {
                row.classList.remove("active");
            });
            rows[index].classList.add("active");
        }

        showSlide(current);

        setInterval(() => {
            current = (current + 1) % rows.length;
            showSlide(current);
        }, 5000); // 5s macro animation
    });
</script>
