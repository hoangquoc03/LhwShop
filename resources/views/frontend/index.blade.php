@extends('frontend.master')
@section('title')
    Trang chủ bán hàng
@endsection

@section('page-style')
    <style>
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
            background: linear-gradient(135deg, rgba(15, 60, 145, 0.25), #00c6ff);
            color: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, rgba(15, 60, 145, 0.25), #00c6ff);
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
            background: linear-gradient(135deg, rgba(15, 60, 145, 0.25), #00c6ff);
            color: #fff;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
    @include('frontend/includes/CategorySection')
    @include('frontend/includes/HeroSection')
    @include('frontend/includes/ProductSection', [
        'title' => 'QUÀ TẶNG',
        'screen' => $screen,
    ])
    @include('frontend/includes/ImageCategory')
    @include('frontend.includes.PostImage', ['post_id' => 6])
    @include('frontend/includes/ProductSection', [
        'title' => 'TÚI XÁCH VÀ VÍ',
        'screen' => $bag,
    ])
    @include('frontend/includes/ProductSection', [
        'title' => 'ĐỒ NAM',
        'screen' => $outfit,
    ])
    @include('frontend.includes.PostImage', ['post_id' => 5])
    @include('frontend/includes/ProductSection', [
        'title' => 'ĐỒ NỮ',
        'screen' => $outfitNu,
    ])
    @include('frontend.includes.PostImage', ['post_id' => 3])
    @include('frontend/includes/ProductSection', [
        'title' => 'GIÀY',
        'screen' => $giay,
    ])
    @include('frontend/includes/ChatBot')

    <style>
        /* Khoảng cách giữa các ảnh */
        .custom-gap {
            gap: 30px;
            /* có thể điều chỉnh 20px, 25px, 30px tùy bạn muốn rộng bao nhiêu */
            padding: 10px 0;
        }

        /* Khung ảnh */
        .post-image-box {
            width: 280px;
            height: 180px;
            background: #f8f9fa;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 0 auto;
        }

        /* Hiệu ứng hover */
        .post-image-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
        }

        /* Ảnh bên trong */
        .post-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        /* Zoom nhẹ khi hover */
        .post-image-box:hover .post-image {
            transform: scale(1.05);
        }

        /* Responsive cho điện thoại */
        @media (max-width: 768px) {
            .post-image-box {
                width: 100%;
                height: 200px;
            }

            .custom-gap {
                gap: 15px;
            }
        }
    </style>









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
    /* Ảnh lớn */
    .banner-img-lg {
        width: 100%;
        height: 420px;
        object-fit: cover;
        border-radius: 16px;
        transition: transform 0.4s ease;
    }

    .banner-img-lg:hover {
        transform: scale(1.02);
    }

    /* Ảnh nhỏ */
    .banner-img-sm {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        transition: transform 0.4s ease;
    }

    .banner-img-sm:hover {
        transform: scale(1.03);
    }

    /* Overlay dưới cho ảnh lớn */
    .banner-overlay-bottom {
        position: absolute;
        bottom: 25px;
        left: 25px;
        color: #fff;
        text-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
    }

    .banner-overlay-bottom h2 {
        font-size: 2rem;
        font-weight: 700;
    }

    /* Overlay giữa cho ảnh nhỏ */
    .banner-overlay-center {
        position: absolute;
        inset: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        text-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        opacity: 0;
        background: rgba(0, 0, 0, 0.3);
        transition: opacity 0.3s ease;
    }

    .banner-wrapper-sm:hover .banner-overlay-center {
        opacity: 1;
    }

    /* Nút gradient */
    .btn-gradient {
        background: linear-gradient(45deg, #ff6b6b, #ff922b);
        color: #fff;
        border: none;
        padding: 10px 24px;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
    }



    /* Container bọc ảnh để làm border */
    .banner-wrapper {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        display: inline-block;
    }

    /* Hiệu ứng border gradient động */
    .banner-wrapper::before {
        content: "";
        position: absolute;
        inset: -2px;
        /* viền bao quanh */
        border-radius: 20px;
        padding: 2px;
        background: linear-gradient(45deg, #ff6b6b, #ff922b, #4facfe, #00f2fe);
        background-size: 300% 300%;
        animation: gradientBorder 6s ease infinite;
        -webkit-mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
        opacity: 0;
        /* ẩn khi chưa hover */
        transition: opacity 0.4s ease;
    }

    .banner-wrapper:hover::before {
        opacity: 1;
        /* hiện khi hover */
    }

    /* Animation gradient */
    @keyframes gradientBorder {
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

    /* Ảnh lớn */
    .banner-img-lg {
        width: 100%;
        height: 420px;
        object-fit: cover;
        transition: transform 0.6s ease;
        border-radius: 20px;
    }

    .banner-wrapper:hover .banner-img-lg {
        transform: scale(1.05);
    }

    /* Ảnh nhỏ */
    .banner-img-sm {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.6s ease;
        border-radius: 20px;
    }

    .banner-wrapper:hover .banner-img-sm {
        transform: scale(1.05);
    }


    .contact-item::after {
        content: attr(data-label);
        /* Lấy text từ attribute */
        position: absolute;
        right: 60px;
        /* khoảng cách so với nút */
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.75);
        color: #fff;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
    }

    /* Khi hover nút con thì hiện tooltip */
    .contact-item:hover::after {
        opacity: 1;
        visibility: visible;
        right: 70px;
    }

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

    .card-product__imgOverlay {
        background: rgba(255, 255, 255, 0.7);
        padding: 0.5rem;
        border-radius: 50px;
    }

    .card-product__imgOverlay li {
        list-style: none;
    }

    .card-product__imgOverlay button {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.2rem;
        /* Kích thước icon */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-product__imgOverlay button i {
        display: block;
        /* Ngăn icon bị kéo méo */
        line-height: 1;
    }
</style>

@section('user.js')
    <script>
        $("#load-more").on("click", function() {
            $.ajax({
                url: "/products/category/{{ $category->id }}?page=2",
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
    </script>

    <script>
        // Hiện spinner khi rời trang (chuyển route hoặc reload)
        window.addEventListener("beforeunload", function() {
            document.getElementById("loading-overlay").style.display = "flex";
        });

        // Hiện spinner khi click vào các nút sắp xếp (sort)
        document.querySelectorAll('a[href*="?sort="]').forEach(link => {
            link.addEventListener("click", function() {
                document.getElementById("loading-overlay").style.display = "flex";
            });
        });

        // Nếu bạn có AJAX "Xem thêm sản phẩm"
        const loadMoreBtn = document.getElementById("load-more");
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener("click", function() {
                document.getElementById("loading-overlay").style.display = "flex";
            });
        }
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const backToTop = document.getElementById("back-to-top");
            const contactMenu = document.getElementById("contact-menu");
            const contactToggle = document.getElementById("contact-toggle");

            // Hiện nút "Lên đầu"
            window.addEventListener("scroll", () => {
                if (window.scrollY > 300) {
                    backToTop.classList.add("show");
                } else {
                    backToTop.classList.remove("show");
                }
            });

            // Cuộn lên đầu
            backToTop.addEventListener("click", () => {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });

            // Toggle Liên hệ (Zalo + Chat)
            contactToggle.addEventListener("click", () => {
                contactMenu.classList.toggle("active");
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const carousel = document.getElementById("carousel");
            const items = carousel.querySelectorAll(".item");
            const total = items.length;
            const angle = 360 / total;

            let currdeg = 0;
            let currentIndex = 0;
            let startX = 0;
            let isDragging = false;

            const productName = document.getElementById("product-name");
            const productDesc = document.getElementById("product-desc");
            const productLink = document.getElementById("product-link");

            function updateInfo(index) {
                const item = items[index % total];
                productName.innerText = item.dataset.name;
                productDesc.innerText = item.dataset.desc;
                productLink.href = item.dataset.link;
            }

            // Desktop - kéo chuột
            carousel.addEventListener("mousedown", e => {
                isDragging = true;
                startX = e.clientX;
                e.preventDefault();
            });

            window.addEventListener("mouseup", e => {
                if (!isDragging) return;
                const endX = e.clientX;
                if (startX > endX + 50) { // kéo sang trái
                    currdeg -= angle;
                    currentIndex = (currentIndex + 1) % total;
                } else if (startX < endX - 50) { // kéo sang phải
                    currdeg += angle;
                    currentIndex = (currentIndex - 1 + total) % total;
                }
                carousel.style.transform = `translateZ(-700px) rotateY(${currdeg}deg)`;
                updateInfo(currentIndex);
                isDragging = false;
            });

            // Mobile - touch
            carousel.addEventListener("touchstart", e => startX = e.touches[0].clientX);
            carousel.addEventListener("touchend", e => {
                const endX = e.changedTouches[0].clientX;
                if (startX > endX + 50) {
                    currdeg -= angle;
                    currentIndex = (currentIndex + 1) % total;
                } else if (startX < endX - 50) {
                    currdeg += angle;
                    currentIndex = (currentIndex - 1 + total) % total;
                }
                carousel.style.transform = `translateZ(-700px) rotateY(${currdeg}deg)`;
                updateInfo(currentIndex);
            });

            // Click vào item cập nhật thông tin luôn
            items.forEach((item, idx) => {
                item.addEventListener("click", () => {
                    currentIndex = idx;
                    currdeg = -angle * idx;
                    carousel.style.transform = `translateZ(-700px) rotateY(${currdeg}deg)`;
                    updateInfo(currentIndex);
                });
            });

            // Khởi tạo thông tin ban đầu
            updateInfo(0);
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
        var swiperTop = new Swiper(".mySwiperTop", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            effect: "fade",
        });
    </script>
    {{-- 
    <script>
        $(document).ready(function() {

            // Click icon yêu thích
            $(document).on("click", ".btn-favorite", function(e) {
                e.preventDefault();

                let btn = $(this);
                let productId = btn.data("id");

                $.ajax({
                    url: "{{ route('favorites.add') }}", // route thêm yêu thích
                    type: "POST",
                    data: {
                        product_id: productId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            // ✅ Cập nhật số lượng navbar
                            $(".nav-favorites__count").text(res.count);

                            // ✅ Đổi màu icon (nếu muốn)
                            btn.find('i').addClass('text-primary');

                            // ✅ Thông báo Toastify
                            Toastify({
                                text: "Đã thêm sản phẩm vào yêu thích",
                                duration: 2000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#28a745",
                            }).showToast();
                        }
                    },
                    error: function() {
                        Toastify({
                            text: "Có lỗi xảy ra!",
                            duration: 2000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#ff6b6b",
                        }).showToast();
                    }
                });
            });

        });

        // Xóa sản phẩm khỏi yêu thích
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
                        // ✅ Xóa khỏi DOM
                        item.remove();

                        // ✅ Cập nhật số lượng navbar
                        $(".nav-favorites__count").text(res.count);

                        // Nếu hết sản phẩm, hiển thị thông báo
                        if (res.count === 0) {
                            $("#favorite-list").html("<p>Chưa có sản phẩm yêu thích nào.</p>");
                        }

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
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    let productId = this.dataset.id;

                    fetch("{{ route('cart.add') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // 1️⃣ Cập nhật số lượng navbar
                                document.querySelector('.nav-cart__count').textContent = data
                                    .cart_count;

                                // 2️⃣ Toast
                                Toastify({
                                    text: `"${data.product.name}" đã được thêm vào giỏ hàng!`,
                                    duration: 3000,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "#28a745",
                                    close: true
                                }).showToast();

                                // 3️⃣ Cập nhật dropdown
                                const cartItems = document.querySelector(
                                    '.cart-dropdown .cart-items');
                                const cartTotal = document.querySelector(
                                    '.cart-dropdown .cart-total');

                                if (cartItems) {
                                    const emptyMsg = cartItems.querySelector('.empty-cart');
                                    if (emptyMsg) emptyMsg.remove();

                                    let existingItem = cartItems.querySelector(
                                        `.cart-item[data-id="${data.product.id}"]`);
                                    if (existingItem) {
                                        existingItem.querySelector('.small.text-muted')
                                            .textContent = 'x' + data.product.quantity;
                                    } else {
                                        const newItem = document.createElement('div');
                                        newItem.className =
                                            'd-flex align-items-center mb-2 cart-item';
                                        newItem.setAttribute('data-id', data.product.id);
                                        newItem.innerHTML = `
                                    <img src="${data.product.image}" class="mr-2 rounded" style="width:40px;height:40px;object-fit:cover;">
                                    <div class="flex-grow-1">
                                        <p class="mb-0 small font-weight-bold">${data.product.name}</p>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-danger small">${data.product.price}</span>
                                            <span class="small text-muted">x${data.product.quantity}</span>
                                        </div>
                                    </div>
                                    <form method="POST" action="/cart/remove/${data.product.id}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-sm btn-link text-danger">
                                            <i class="ti-close"></i>
                                        </button>
                                    </form>`;
                                        cartItems.prepend(newItem);
                                    }

                                    if (cartTotal) {
                                        cartTotal.innerHTML = `
                                    <div class="dropdown-divider"></div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-weight-bold">Tổng:</span>
                                        <span class="text-danger font-weight-bold">${data.total}</span>
                                    </div>
                                    <a href="{{ route('cart.index') }}" class="btn btn-outline-primary btn-sm btn-block mb-2">
                                        <i class="ti-eye"></i> Xem giỏ hàng
                                    </a>
                                    <a href="#" class="btn btn-primary btn-sm btn-block">
                                        <i class="ti-credit-card"></i> Thanh toán
                                    </a>`;
                                    }
                                }
                            }
                        });
                });
            });
        });
    </script> --}}
@endsection
