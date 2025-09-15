<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('/libs/jquery.min.js') }}"></script>
<script src="{{ asset('/static/assets/charts.js') }}"></script>
<script src="{{ asset('/static/assets/constants.js') }}"></script>
<script src="{{ asset('/static/assets/index.js') }}"></script>
<script src="{{ asset('/static/assets/sidebar.js') }}"></script>
<script src="{{ asset('/static/dist/main.bundle.js.map') }}"></script>
<script src="{{ asset('/static/dist/main.bundle.js') }}"></script>
<script src="{{ asset('/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/libs/jquery-validation/dist/localization/messages_vi.min.js') }}"></script>
<script src="{{ asset('/libs/dropzone.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const path = window.location.pathname;
        const menuLinks = document.querySelectorAll("aside a");

        menuLinks.forEach((link) => {
            if (link.getAttribute("href") === path) {
                link.classList.add("bg-gray-100", "dark:bg-gray-700");
            } else {
                link.classList.remove("bg-gray-100", "dark:bg-gray-700");
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggleSidebarMobile");
        const sidebar = document.getElementById("sidebar");
        const iconOpen = document.getElementById("toggleSidebarMobileHamburger");
        const iconClose = document.getElementById("toggleSidebarMobileClose");

        toggleBtn.addEventListener("click", function () {
            const isHidden = sidebar.classList.contains("hidden");

            sidebar.classList.toggle("hidden");
            iconOpen.classList.toggle("hidden", !isHidden);
            iconClose.classList.toggle("hidden", isHidden);
        });
    });
</script>

