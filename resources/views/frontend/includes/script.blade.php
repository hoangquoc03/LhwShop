<script src="{{ asset('frontend/vendors/jquery/jquery-3.2.1.min.js') }}"></script>

<script>
    window.$ = window.jQuery;
</script>

<script src="{{ asset('frontend/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/vendors/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('frontend/vendors/skrollr.min.js') }}"></script>
<script src="{{ asset('frontend/vendors/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('frontend/vendors/mail-script.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>

<script src="{{ asset('libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('libs/jquery-validation/dist/localization/messages_vi.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const generateButton = document.getElementById("generateOutfit");
        const promptInput = document.getElementById("outfitPrompt");
        const loading = document.getElementById("loading");
        const result = document.getElementById("result");

        // Nếu trang không có AI Outfit thì bỏ qua
        if (!generateButton || !promptInput || !loading || !result) {
            return;
        }

        generateButton.addEventListener("click", async function() {

            const prompt = promptInput.value.trim();

            if (!prompt) {
                result.innerHTML = `
                <div class="alert alert-warning">
                    Vui lòng nhập yêu cầu outfit.
                </div>
            `;
                return;
            }

            generateButton.disabled = true;
            loading.style.display = "block";
            result.innerHTML = "";

            try {
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content");

                if (!csrfToken) {
                    throw new Error("Không tìm thấy CSRF token.");
                }

                const response = await fetch("{{ route('outfit.recommend') }}", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        prompt
                    })
                });

                const data = await response.json();

                result.innerHTML = `
                <div class="alert alert-success">
                    ${data.result ?? "Không có dữ liệu trả về."}
                </div>
            `;

            } catch (error) {
                result.innerHTML = `
                <div class="alert alert-danger">
                    ${error.message}
                </div>
            `;
            } finally {
                loading.style.display = "none";
                generateButton.disabled = false;
            }
        });

    });
</script>
