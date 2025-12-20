<!DOCTYPE html>
<html lang="en">
@include('frontend/includes/head')
@toastifyCss

<body>
    <style>
        /* ===== GLOBAL LUXURY BLUE BACKGROUND ===== */
        body {
            position: relative;
            background: #ffffff;
        }

        /* Background layer */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: 0;

            background-image:
                /* Grid cực nhẹ */
                linear-gradient(to right,
                    rgba(226, 232, 240, 0.6) 1px,
                    transparent 1px),
                linear-gradient(to bottom,
                    rgba(226, 232, 240, 0.6) 1px,
                    transparent 1px),

                /* Blue glow trái trên */
                radial-gradient(circle 700px at 18% 18%,
                    rgba(37, 99, 235, 0.12),
                    transparent 60%),

                /* Blue glow phải dưới */
                radial-gradient(circle 700px at 82% 82%,
                    rgba(14, 165, 233, 0.10),
                    transparent 60%);

            background-size:
                56px 56px,
                56px 56px,
                100% 100%,
                100% 100%;

            pointer-events: none;
        }

        /* Ensure content above background */
        header,
        main,
        footer {
            position: relative;
            z-index: 1;
        }

        /* Banner */
        .top-banner {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1031;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .navbar-fixed {
            position: fixed;
            top: 40px;
            /* có banner */
            width: 100%;
            z-index: 1030;
            transition: transform 0.35s ease, top 0.35s ease;
            will-change: transform;
        }

        /* Khi banner biến mất */
        .top-banner.hide-banner {
            transform: translateY(-100%);
            opacity: 0;
        }

        /* Navbar dính lên trên khi banner mất */
        .navbar-fixed.banner-gone {
            top: 0;
        }

        /* Ẩn navbar */
        .navbar-hide {
            transform: translateY(-100%);
        }

        /* Body mặc định (có banner) */
        body {
            padding-top: 120px;
            /* banner + navbar */
        }

        /* Khi banner mất */
        body.banner-hidden {
            padding-top: 80px;
            /* chỉ còn navbar */
        }
    </style>

    <!--================ Start Header Menu Area =================-->
    <header class="header_area ">
        <!-- Banner TOP -->
        <div class="top-banner">
            <div class="w-100 py-2 text-sm text-white text-center"
                style="background: linear-gradient(to right, #4F39F6, #FDFEFF);">
                <p class="mb-0">
                    <span class="px-3 py-1 rounded bg-white  me-2 fw-semibold" style="color: #4F39F6">
                        Ưu đãi ra mắt
                    </span>
                    Khám phá thời trang Luxury cao cấp – Ưu đãi độc quyền cho khách hàng mới
                </p>
            </div>
        </div>

        <!-- Navbar -->
        <div class="navbar-fixed" id="navbar">
            @include('frontend/includes/nav')
        </div>
    </header>

    <!--================ End Header Menu Area =================-->

    <main class="site-main">
        @yield('page-style')

    </main>

    <!--================ Start footer Area  =================-->
    @include('frontend/includes/footer')

    <!--================ End footer Area  =================-->
    @include('frontend/includes/script')
    @yield('user.js')

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('navbar');
        const banner = document.querySelector('.top-banner');
        const body = document.body;

        let lastScroll = window.pageYOffset;
        let bannerHidden = false;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            /* Ẩn banner khi rời top */
            if (currentScroll > 20 && !bannerHidden) {
                banner.classList.add('hide-banner');
                navbar.classList.add('banner-gone');
                body.classList.add('banner-hidden');
                bannerHidden = true;
            }

            /* Navbar ẩn / hiện */
            if (currentScroll > lastScroll && currentScroll > 120) {
                navbar.classList.add('navbar-hide');
            } else {
                navbar.classList.remove('navbar-hide');
            }

            lastScroll = currentScroll;
        });
    });
</script>



</html>
