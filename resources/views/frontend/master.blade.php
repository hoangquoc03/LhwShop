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


    <div id="avatarSelectModal" class="avatar-modal" style="display:none;">

        <div class="avatar-modal-overlay"></div>

        <div class="avatar-modal-content">

            <div class="avatar-modal-header">

                <div>
                    <h5 class="fw-bold mb-1">
                        🧍 Chọn Avatar
                    </h5>

                    <small class="text-muted">
                        Chọn avatar để thử outfit AI
                    </small>
                </div>

                <button type="button" id="closeAvatarModal" class="btn-close">
                </button>

            </div>


            <div class="avatar-modal-body">

                <div class="text-center mb-4">

                    <div class="fw-semibold">
                        Bạn muốn thử outfit trên avatar nào?
                    </div>

                    <div class="small text-muted mt-1">
                        Chọn avatar để tiếp tục vào phòng thử đồ 3D.
                    </div>

                </div>


                <div class="row g-3">

                    <!-- AVATAR NAM -->

                    <div class="col-6">

                        <div class="avatar-option" data-avatar="male" data-model="/models/avatar/avatar.glb">

                            <div class="avatar-preview">
                                <div class="avatar-placeholder">
                                    👨
                                </div>
                            </div>

                            <div class="text-center mt-3">

                                <div class="fw-bold">
                                    Avatar Nam
                                </div>

                                <small class="text-muted">
                                    Dáng nam
                                </small>

                            </div>

                        </div>

                    </div>


                    <!-- AVATAR NỮ -->

                    <div class="col-6">

                        <div class="avatar-option" data-avatar="female" data-model="/models/avatar/avatar.glb">

                            <div class="avatar-preview">
                                <div class="avatar-placeholder">
                                    👩
                                </div>
                            </div>

                            <div class="text-center mt-3">

                                <div class="fw-bold">
                                    Avatar Nữ
                                </div>

                                <small class="text-muted">
                                    Dáng nữ
                                </small>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- OUTFIT -->

                <div class="mt-4 p-3"
                    style="
                    background:#f8f8f8;
                    border-radius:12px;
                 ">

                    <div class="fw-bold mb-2">
                        👗 Outfit sẽ thử
                    </div>

                    <div id="selectedAvatarOutfit" class="small text-muted">
                        Chưa chọn outfit
                    </div>

                </div>

            </div>


            <div class="avatar-modal-footer">

                <button type="button" id="cancelAvatarModal" class="btn btn-light">
                    Hủy
                </button>

                <button type="button" id="continueToFitting" class="btn btn-dark" disabled>
                    Tiếp tục →
                </button>

            </div>

        </div>

    </div>
    <div class="modal fade" id="avatarSelectModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg" style="border-radius:18px; overflow:hidden;">

                <!-- HEADER -->

                <div class="modal-header">

                    <div>

                        <h5 class="modal-title fw-bold mb-1">
                            🧍 Chọn Avatar
                        </h5>

                        <small class="text-muted">
                            Chọn avatar để thử outfit AI
                        </small>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- BODY -->

                <div class="modal-body">

                    <div class="text-center mb-4">

                        <div class="fw-semibold">
                            Bạn muốn thử outfit trên avatar nào?
                        </div>

                        <div class="small text-muted mt-1">
                            Sau khi chọn avatar, hệ thống sẽ mở phòng thử đồ 3D.
                        </div>

                    </div>


                    <!-- AVATAR -->

                    <div class="row g-3">

                        <!-- NAM -->

                        <div class="col-6">

                            <div class="avatar-option" data-avatar="male" data-model="/models/avatar/avatar.glb">

                                <div class="avatar-preview">

                                    <div class="avatar-placeholder">
                                        👨
                                    </div>

                                </div>

                                <div class="text-center mt-3">

                                    <div class="fw-bold">
                                        Avatar Nam
                                    </div>

                                    <small class="text-muted">
                                        Dáng nam
                                    </small>

                                </div>

                            </div>

                        </div>


                        <!-- NỮ -->

                        <div class="col-6">

                            <div class="avatar-option" data-avatar="female" data-model="/models/avatar/avatar.glb">

                                <div class="avatar-preview">

                                    <div class="avatar-placeholder">
                                        👩
                                    </div>

                                </div>

                                <div class="text-center mt-3">

                                    <div class="fw-bold">
                                        Avatar Nữ
                                    </div>

                                    <small class="text-muted">
                                        Dáng nữ
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- OUTFIT -->

                    <div class="mt-4 p-3"
                        style="
                        background:#f8f8f8;
                        border-radius:12px;
                     ">

                        <div class="fw-bold mb-2">
                            👗 Outfit sẽ thử
                        </div>

                        <div id="selectedAvatarOutfit" class="small text-muted">
                            Chưa chọn outfit
                        </div>

                    </div>

                </div>


                <!-- FOOTER -->

                <div class="modal-footer">

                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Hủy
                    </button>

                    <button type="button" id="continueToFitting" class="btn btn-dark" disabled>
                        Tiếp tục →
                    </button>

                </div>

            </div>

        </div>

    </div>



    <style>
        .avatar-modal {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .avatar-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .55);
        }

        .avatar-modal-content {
            position: relative;
            z-index: 10001;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
        }

        .avatar-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid #eee;
        }

        .avatar-modal-body {
            padding: 24px;
        }

        .avatar-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px;
            border-top: 1px solid #eee;
        }

        .avatar-option {
            border: 2px solid #e5e5e5;
            border-radius: 16px;
            padding: 12px;
            cursor: pointer;
            background: #fff;
            transition: all .2s ease;
        }

        .avatar-option:hover {
            border-color: #333;
            transform: translateY(-2px);
        }

        .avatar-option.selected {
            border-color: #111;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, .08);
        }

        .avatar-preview {
            height: 180px;
            border-radius: 12px;
            background: linear-gradient(180deg,
                    #f8f8f8,
                    #ededed);

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-placeholder {
            font-size: 90px;
        }
    </style>
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
