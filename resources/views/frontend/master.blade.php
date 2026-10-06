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

    <div id="aiModal" class="ai-modal" style="display: none;">
        <button id="openAiModal" class="btn btn-dark">
            ✨ AI Gợi ý Outfit
        </button>
        <div class="ai-modal-content">

            <div class="ai-header">


                <span id="closeAiModal" style="cursor:pointer;">
                    &times;
                </span>
            </div>

            <textarea id="outfitPrompt" class="form-control" rows="5"
                placeholder="Ví dụ: Tôi muốn mặc đi cafe với bạn vào buổi tối, phong cách Hàn Quốc..."></textarea>

            <button type="button" id="generateOutfit" class="btn btn-dark w-100 mt-3">
                Tạo gợi ý
            </button>

            <div id="loading" class="mt-3" style="display:none;">
                AI đang suy nghĩ...
            </div>

            <div id="result" class="mt-4"></div>

        </div>
    </div>
    <div class="modal fade" id="tryOnModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        ✨ Phòng thử đồ AI
                    </h5>

                    <button class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <p id="selectedProductName"></p>

                    <input type="file" id="personImage" accept="image/*" class="form-control mb-3">

                    <div id="tryOnLoading" class="text-center d-none">

                        <div class="spinner-border text-dark"></div>

                        <p class="mt-2">
                            AI đang tạo ảnh...
                        </p>

                    </div>

                    <img id="tryOnResult" class="img-fluid rounded d-none">

                </div>

                <div class="modal-footer">

                    <button id="generateTryOn" class="btn btn-dark">

                        Tạo ảnh mặc thử
                    </button>

                </div>

            </div>

        </div>

    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navbar = document.getElementById("navbar");
        const banner = document.querySelector(".top-banner");

        if (!navbar || !banner) return;

        let lastScroll = window.pageYOffset;
        let bannerHidden = false;

        window.addEventListener("scroll", function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 20 && !bannerHidden) {
                banner.classList.add("hide-banner");
                navbar.classList.add("banner-gone");
                document.body.classList.add("banner-hidden");
                bannerHidden = true;
            }

            if (currentScroll > lastScroll && currentScroll > 120) {
                navbar.classList.add("navbar-hide");
            } else {
                navbar.classList.remove("navbar-hide");
            }

            lastScroll = currentScroll;
        });
    });
</script>



</html>
