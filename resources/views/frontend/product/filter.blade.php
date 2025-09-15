@extends('frontend.master')
@section('title',$category->categories_text ?? 'Sản phẩm')

@section('page-style')

<!-- Breadcrumb -->
<div class="container my-3">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0 breadcrumb-transparent">
      <li class="breadcrumb-item">
        <a href="/" class="text-decoration-none text-primary fw-bold">Trang chủ</a>
      </li>

      @if (!empty($queryText))
        <li class="breadcrumb-item active">
          Kết quả tìm kiếm cho: "{{ $queryText }}"
        </li>
      @else
        @if ($category)
          <li class="breadcrumb-item">
            <a href="{{ route('products.byCategory', $category->id) }}" class="text-decoration-none">
              {{ $category->categories_text }}
            </a>
          </li>
        @endif

        @if ($supplier)
          <li class="breadcrumb-item active">
            {{ $supplier->supplier_text }}
          </li>
        @endif
      @endif
    </ol>
  </nav>
</div>

<!-- Tiêu đề -->
<div class="container my-4">
  <h3 class="fw-bold">
    {{ $category?->categories_text ?? 'Tất cả sản phẩm' }}
    @if ($supplier) - {{ $supplier->supplier_text }} @endif
  </h3>
</div>

<!-- Bộ lọc & Sắp xếp -->
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <h6 class="fw-bold mb-0">Sắp xếp theo:</h6>

    <div class="d-flex gap-2 flex-wrap">
      <a href="?sort=popular" class="btn btn-outline-primary {{ request('sort') == 'popular' ? 'active' : '' }}">
        <i class="bi bi-stars me-1 text-warning"></i> Phổ biến
      </a>
      <a href="?sort=hot" class="btn btn-outline-danger {{ request('sort') == 'hot' ? 'active' : '' }}">
        <i class="bi bi-fire me-1 text-danger"></i> Khuyến mãi hot
      </a>
      <a href="?sort=price_asc" class="btn btn-outline-secondary {{ request('sort') == 'price_asc' ? 'active' : '' }}">
        <i class="bi bi-arrow-down-up me-1 text-primary"></i> Giá thấp → cao
      </a>
      <a href="?sort=price_desc" class="btn btn-outline-secondary {{ request('sort') == 'price_desc' ? 'active' : '' }}">
        <i class="bi bi-arrow-up-down me-1 text-success"></i> Giá cao → thấp
      </a>
      <a href="?sort=newest" class="btn btn-outline-dark {{ request('sort') == 'newest' ? 'active' : '' }}">
        <i class="bi bi-clock-history me-1 text-dark"></i> Mới nhất
      </a>
      <a href="?sort=best_seller" class="btn btn-outline-warning {{ request('sort') == 'best_seller' ? 'active' : '' }}">
        <i class="bi bi-lightning-charge me-1 text-warning"></i> Bán chạy
      </a>
      <a href="?sort=top_rated" class="btn btn-outline-success {{ request('sort') == 'top_rated' ? 'active' : '' }}">
        <i class="bi bi-star-fill me-1 text-success"></i> Đánh giá cao
      </a>
    </div>
  </div>
</div>

<!-- Danh sách sản phẩm -->
<div class="container">
  <div class="row g-4" id="product-list">
    @forelse ($products as $product)
      @include('frontend.category.partials.index', ['product' => $product])
    @empty
      <div class="col-12 text-center py-5">
        <p class="text-muted">Không tìm thấy sản phẩm phù hợp.</p>
      </div>
    @endforelse
  </div>

  <!-- Nút "Xem thêm" -->
  @if ($products->hasMorePages())
    @php
      $remaining = $products->total() - ($products->currentPage() * $products->perPage());
      $remaining = $remaining > 0 ? $remaining : 0;
    @endphp

    <div class="mt-4 text-center" id="load-more-wrapper">
      <button class="btn btn-primary px-4" id="load-more" data-next-page="{{ $products->nextPageUrl() }}">
        Xem thêm {{ $remaining }} sản phẩm nữa
      </button>
    </div>
  @endif
</div>


<div id="floating-buttons">
  <!-- Nút Back to Top -->
  <button id="back-to-top" 
          class="btn btn-primary rounded-circle shadow d-flex align-items-center justify-content-center">
    <i class="ti-angle-up"></i>
  </button>

  <!-- Menu Liên hệ -->
  <div id="contact-menu" class="contact-menu">

    <!-- Nút chính Liên hệ -->
    <button id="contact-toggle" 
            class="btn btn-success rounded-circle shadow d-flex align-items-center justify-content-center">
      <i class="ti-headphone-alt"></i>
    </button>

    <!-- Nút con: Zalo -->
    <a href="https://zalo.me/0123456789" target="_blank" 
       class="btn btn-info rounded-circle shadow d-flex align-items-center justify-content-center contact-item"
       data-label="Liên hệ Zalo">
      <i class="ti-comment-alt"></i>
    </a>

    <!-- Nút con: Chat nhân viên -->
    <a href="/chat" 
       class="btn btn-warning rounded-circle shadow d-flex align-items-center justify-content-center contact-item"
       data-label="Chat với nhân viên">
      <i class="ti-user"></i>
    </a>
  </div>
</div>
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

<div id="floating-buttons">
  <!-- Nút Back to Top -->
  <button id="back-to-top" 
          class="btn btn-primary rounded-circle shadow d-flex align-items-center justify-content-center">
    <i class="ti-angle-up"></i>
  </button>

  <!-- Menu Liên hệ -->
  <div id="contact-menu" class="contact-menu">

    <!-- Nút chính Liên hệ -->
    <button id="contact-toggle" 
            class="btn btn-success rounded-circle shadow d-flex align-items-center justify-content-center">
      <i class="ti-headphone-alt"></i>
    </button>

    <!-- Nút con: Zalo -->
    <a href="https://zalo.me/0123456789" target="_blank" 
       class="btn btn-info rounded-circle shadow d-flex align-items-center justify-content-center contact-item"
       data-label="Liên hệ Zalo">
      <i class="ti-comment-alt"></i>
    </a>

    <!-- Nút con: Chat nhân viên -->
    <a href="/chat" 
       class="btn btn-warning rounded-circle shadow d-flex align-items-center justify-content-center contact-item"
       data-label="Chat với nhân viên">
      <i class="ti-user"></i>
    </a>
  </div>
</div>

@endsection
<style>
    /* Tooltip chung cho nút con */
  .contact-item::after {
    content: attr(data-label); /* Lấy text từ attribute */
    position: absolute;
    right: 60px; /* khoảng cách so với nút */
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
    box-shadow: 0 6px 12px rgba(0,0,0,0.2);
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

  .section-intro h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, #007bff, #00c6ff);
    display: inline-block;
    padding: 10px 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
  }


    /* Box nổi bật */
  .highlight-box {
    background: linear-gradient(135deg, #007bff, #00c6ff); /* xanh dương gradient */
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
  }

  /* Chữ trong khung */
  .highlight-box h2 {
    color: #fff;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

    /* Reset chiều cao Swiper wrapper */
  .featuredSwiper {
    height: auto !important;
    padding-bottom: 1rem; /* tạo khoảng cách nhỏ đẹp mắt, không bị to */
  }

  /* Swiper wrapper auto fit */
  .featuredSwiper .swiper-wrapper {
    height: auto !important;
    align-items: stretch; /* các card bằng nhau theo chiều cao lớn nhất */
  }

  /* Slide cũng auto */
  .featuredSwiper .swiper-slide {
    height: auto !important;
    display: flex;
    justify-content: center;
  }
  /* Slide giữ căn giữa */
  .featuredSwiper .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: flex-start; /* không stretch nữa */
    height: auto !important;
  }

  /* Card gọn gàng */
  .featuredSwiper .card-product {
    max-width: 260px;
    height: auto;        /* không kéo giãn */
    display: flex;
    flex-direction: column;
    border-radius: 16px;
    transition: transform .3s ease, box-shadow .3s ease;
  }

  /* Ảnh đồng bộ */
  .featuredSwiper .card-product__img img {
    height: 220px;
    object-fit: contain;
    background: #f8f9fa;
    padding: 12px;
    border-bottom: 1px solid #eee;
  }

  /* Body giữ cân bằng */
  .featuredSwiper .card-body {
    flex: 1 1 auto;
    min-height: 160px; /* để card đều nhau */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .swiper-slide {
    display: flex;
    justify-content: center;
  }
  .card-product {
    border: 2px solid #007bff;   /* viền xanh dương */
  border-radius: 12px;         /* bo góc mềm */
  overflow: hidden;            /* giữ nội dung không tràn */
  background: #fff;            /* nền trắng gọn gàng */
  transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
  }
  .card-product:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0,123,255,.2);
  }
  .transition-icons { opacity: 0; transform: scale(0.8); transition: all .3s; }
  .card-product:hover .transition-icons { opacity: 1; transform: scale(1); }

  .filter-buttons .btn {
    min-width: 150px;        /* Đảm bảo nút đều nhau */
    text-align: center;
    border-radius: 25px;     /* Bo tròn mềm mại */
    font-weight: 500;
    transition: all 0.3s ease;
  }
  .filter-buttons .dropdown .btn {
    min-width: 180px;
  }

  .filter-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }

  .filter-buttons .dropdown-menu {
    min-width: auto;
    border-radius: 8px;
  }
  .breadcrumb-transparent {
    background-color: transparent !important; /* bỏ nền */
    padding: 0; /* bỏ padding mặc định */
    margin: 0; /* nếu muốn sát container */
  }

  .breadcrumb-transparent .breadcrumb-item + .breadcrumb-item::before {
    color: #6c757d; /* màu dấu phân cách / */
  }

  .breadcrumb-transparent .breadcrumb-item a {
    color: #0d6efd; /* màu link */
    transition: color 0.3s ease;
  }

  .breadcrumb-transparent .breadcrumb-item a:hover {
    color: #ff416c; /* màu hover */
  }

  .breadcrumb-transparent .breadcrumb-item.active {
    color: #6c757d; /* màu chữ active */
  }

  /* Container logo */
  .supplier-logos-wrapper {
    padding: 1rem 0;
  }

  /* Logo container scroll ngang */
  .supplier-logos {
    justify-content: flex-start; /* căn trái */
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,0.2) transparent;
  }

  /* Logo hover & card */
  .supplier-logo {
    flex: 0 0 auto;
    width: 120px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
    border-radius: 12px;
    background-color: #f8f9fa;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
  }

  .supplier-logo:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  }

  /* Logo image */
  .supplier-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    display: block;
  }

  /* Scrollbar đẹp cho webkit */
  .supplier-logos::-webkit-scrollbar {
    height: 6px;
  }
  .supplier-logos::-webkit-scrollbar-track {
    background: transparent;
  }
  .supplier-logos::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
  }

  /* Responsive nhỏ */
  @media (max-width: 768px) {
    .supplier-logo {
      width: 100px;
      height: 50px;
    }
  }
  @media (max-width: 576px) {
    .supplier-logo {
      width: 80px;
      height: 40px;
    }
  }
  /* Hover effect cho card và ảnh */
  .card-product:hover .card-product__img img {
    transform: scale(1.1);
  }
  .card-product:hover .card-product__imgOverlay {
    opacity: 1;
  }
  .card-product__imgOverlay button {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .card-product__imgOverlay button:hover {
    transform: scale(1.2);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
  }
  /* Cải thiện typography */
  .section-intro h2 {
    font-size: 2rem;
    letter-spacing: 0.5px;
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
    font-size: 1.2rem; /* Kích thước icon */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card-product__imgOverlay button i {
    display: block; /* Ngăn icon bị kéo méo */
    line-height: 1;
  }
  .card-product:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
  }
  .card-product__price .text-danger {
    background: rgba(255, 77, 77, 0.1);
    padding: 0 0.3rem;
    border-radius: 4px;
  }
    /* Khung ảnh */
  .card-product__img {
    position: relative;
    overflow: hidden;   /* giữ icon trong vùng ảnh */
    border-bottom: 1px solid #eee;
  }

  /* Ảnh sản phẩm */
  .card-product__img img {
    width: 100%;
    height: 220px;
    object-fit: contain;
    background: #fff;
    transition: transform 0.3s ease;
  }

  /* Overlay icon */
  .card-product__imgOverlay {
    bottom: 10px; /* dịch xuống trong ảnh */
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s ease, transform 0.3s ease;
  }

  /* Hover: hiện icon */
  .card-product__img:hover .card-product__imgOverlay {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }

</style>
@section('user.js')
<script>
  $("#load-more").on("click", function() {
    $.ajax({
      let categoryId = {{ $category ? $category->id : 'null' }};
      let url = categoryId ? `/products/category/${categoryId}?page=2` : "{{ route('products.filter') }}?page=2";
      method: "GET",
      beforeSend: function() { showSpinner(); },
      success: function(res) {
        $("#product-list").append(res);
      },
      complete: function() { hideSpinner(); }
    });
  });
</script>

<script>
  // Hiện spinner khi rời trang (chuyển route hoặc reload)
  window.addEventListener("beforeunload", function () {
    document.getElementById("loading-overlay").style.display = "flex";
  });

  // Hiện spinner khi click vào các nút sắp xếp (sort)
  document.querySelectorAll('a[href*="?sort="]').forEach(link => {
    link.addEventListener("click", function () {
      document.getElementById("loading-overlay").style.display = "flex";
    });
  });

  // Nếu bạn có AJAX "Xem thêm sản phẩm"
  const loadMoreBtn = document.getElementById("load-more");
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", function () {
      document.getElementById("loading-overlay").style.display = "flex";
    });
  }
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
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
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  // Toggle Liên hệ (Zalo + Chat)
  contactToggle.addEventListener("click", () => {
    contactMenu.classList.toggle("active");
  });
});
</script>

<script>
$(document).on('click', '#load-more', function(e) {
    e.preventDefault();
    let button = $(this);
    let nextPageUrl = button.data('next-page');

    if (!nextPageUrl) return;

    button.prop('disabled', true).text('Đang tải...');

    $.ajax({
        url: nextPageUrl,
        type: 'GET',
        dataType: 'html',
        success: function(response) {
            // Append sản phẩm mới vào danh sách
            $('#product-list').append(response);

            // Lấy URL trang kế tiếp từ pagination Laravel
            let newNextPageUrl = nextPageUrl.replace(/page=\d+/, function(match) {
                let currentPage = parseInt(match.split('=')[1]);
                return 'page=' + (currentPage + 1);
            });

            // Cập nhật URL nút "Xem thêm"
            if (newNextPageUrl.includes('page=' + ({{ $products->lastPage() }} + 1))) {
                $('#load-more-wrapper').remove(); // hết sản phẩm
            } else {
                button.prop('disabled', false).text('Xem thêm sản phẩm nữa');
                button.data('next-page', newNextPageUrl);
            }
        },
        error: function() {
            button.prop('disabled', false).text('Thử lại');
        }
    });
});
</script>
<script>
  const swiper = new Swiper(".featuredSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    grabCursor: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    breakpoints: {
      576: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      1200: { slidesPerView: 4 },
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    }
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector(".carousel");
    let currdeg = 0;
    let startX = 0;

    function rotate(direction) {
      if (direction === "next") {
        currdeg -= 360 / {{ max(1, $products->count()) }};
      } else {
        currdeg += 360 / {{ max(1, $products->count()) }};
      }
      carousel.style.transform = `rotateY(${currdeg}deg)`;
    }

    // Vuốt mobile
    carousel.addEventListener("touchstart", e => {
      startX = e.touches[0].clientX;
    });

    carousel.addEventListener("touchend", e => {
      let endX = e.changedTouches[0].clientX;
      if (startX > endX + 50) {
        rotate("next");
      } else if (startX < endX - 50) {
        rotate("prev");
      }
    });

    // Kéo chuột desktop
    let isDragging = false;
    carousel.addEventListener("mousedown", e => {
      isDragging = true;
      startX = e.clientX;
      e.preventDefault(); // chặn bôi đen
    });
    window.addEventListener("mouseup", e => {
      if (isDragging) {
        let endX = e.clientX;
        if (startX > endX + 50) rotate("next");
        else if (startX < endX - 50) rotate("prev");
        isDragging = false;
      }
    });
  });
  let carousel = document.getElementById("carousel");
  let currdeg = 0;
  let currentIndex = 0;
  let items = document.querySelectorAll(".carousel .item");
  let total = items.length;
  let angle = 360 / total;

  // cập nhật thông tin sản phẩm
  function updateInfo(index) {
    let item = items[index % total];
    document.getElementById("product-name").innerText = item.dataset.name;
    document.getElementById("product-desc").innerText = item.dataset.desc;
    document.getElementById("product-link").setAttribute("href", item.dataset.link);
  }

  // lướt trái/phải bằng chuột
  let startX = 0;
  carousel.addEventListener("mousedown", e => startX = e.pageX);
  carousel.addEventListener("mouseup", e => {
    if (e.pageX < startX - 50) { // vuốt trái
      currdeg -= angle;
      currentIndex = (currentIndex + 1) % total;
    } else if (e.pageX > startX + 50) { // vuốt phải
      currdeg += angle;
      currentIndex = (currentIndex - 1 + total) % total;
    }
    carousel.style.transform = `rotateY(${currdeg}deg)`;
    updateInfo(currentIndex);
  });

  // hỗ trợ touch mobile
  carousel.addEventListener("touchstart", e => startX = e.touches[0].pageX);
  carousel.addEventListener("touchend", e => {
    let endX = e.changedTouches[0].pageX;
    if (endX < startX - 50) {
      currdeg -= angle;
      currentIndex = (currentIndex + 1) % total;
    } else if (endX > startX + 50) {
      currdeg += angle;
      currentIndex = (currentIndex - 1 + total) % total;
    }
    carousel.style.transform = `rotateY(${currdeg}deg)`;
    updateInfo(currentIndex);
  });
  $('#bestSellerCarousel').owlCarousel({
    loop: true,
    margin: 20,
    nav: true,
    dots: false,
    autoplay: true,
    autoplayTimeout: 3000,
    responsive: {
      0:   { items: 1 },
      576: { items: 2 },
      768: { items: 3 },
      992: { items: 4 }
    }
  });

</script>
<script>
$(document).ready(function(){
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

@endsection