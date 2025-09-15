<!DOCTYPE html>
<html lang="en">
@include('frontend/includes/head')
@toastifyCss
<body>
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
        beforeSend: function() { showSpinner(); },
        success: function(res) {
          $("#product-list").append(res);
        },
        complete: function() { hideSpinner(); }
      });
    });

    // Spinner khi rời trang (reload / redirect)
    window.addEventListener("beforeunload", function () {
      showSpinner();
    });

    // Spinner khi click sort
    document.querySelectorAll('a[href*="?sort="]').forEach(link => {
      link.addEventListener("click", function () {
        showSpinner();
      });
    });
  </script>

  <!-- Spinner Overlay -->
  <div id="loading-overlay" 
      style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
              background:rgba(255,255,255,0.8); z-index:9999; 
              align-items:center; justify-content:center;">
    <div class="spinner-border text-primary" style="width:3rem; height:3rem;" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <!--================ Start footer Area  =================-->	
  @include('frontend/includes/footer')
	
	<!--================ End footer Area  =================-->
	@include('frontend/includes/script')
  @yield('user.js')
</body>
</html>