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
            padding-top: 120px;
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
    </style>

    <!--================ Start Header Menu Area =================-->
    <header class="header_area">

        <div class="main_menu">
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

</html>
