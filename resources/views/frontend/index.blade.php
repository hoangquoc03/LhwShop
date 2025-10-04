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
    transform: scale(1.05); /* Zoom nhẹ */
  }

  /* Overlay gradient đẹp */
  .banner-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 40px;
    background: linear-gradient(to top, rgba(0,0,0,0.65), rgba(0,0,0,0));
    border-radius: 0 0 20px 20px;
    color: white;
  }
  .banner-overlay h2 {
    font-size: 2.2rem;
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
  }

  /* Nút CTA gradient */
  .btn-gradient {
    background: linear-gradient(135deg,#007bff,#00c6ff);
    color: #fff;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
  }
  .btn-gradient:hover {
    background: linear-gradient(135deg,#007bff,#00c6ff);
    transform: translateY(-2px);
  }

  /* Navigation buttons */
  .swiper-button-next,
  .swiper-button-prev {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.7);
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    color: #333;
    transition: all 0.3s ease;
  }
  .swiper-button-next:hover,
  .swiper-button-prev:hover {
    background: linear-gradient(135deg,#007bff,#00c6ff);
    color: #fff;
  }
  .swiper-button-next::after,
  .swiper-button-prev::after {
    font-size: 20px;
    font-weight: bold;
  }
</style>

<section class="container my-5 mt-6" style="margin-top: 200px;">
    <div class="row g-3">
        <!-- Banner lớn trên -->
        <div class="col-12 mb-4 mt-5">
            <div class="swiper mySwiperTop rounded-4 shadow-lg overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach($bannerPosts->take(1) as $post)
                        <div class="swiper-slide">
                            <a href="#" class="d-block position-relative">
                                <img src="{{ asset('storage/uploads/posts/images/' . $post->post_image) }}"
                                     class="banner-img-lg"
                                     alt="{{ $post->post_title }}">
                                
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 2 Banner nhỏ dưới -->
        @foreach($bannerPosts->skip(1)->take(2) as $post)
            <div class="col-md-6">
                <a href="#" class="d-block position-relative rounded-4 shadow-sm overflow-hidden">
                    <img src="{{ asset('storage/uploads/posts/images/' . $post->post_image) }}"
                         class="banner-img-sm"
                         alt="{{ $post->post_title }}">
                </a>
            </div>
        @endforeach
    </div>
</section>


<section class="section-margin calc-60px mt-3">
  <div class="container highlight-box">
    <div class="section-intro pb-4 text-center">
      <h2 class="fw-bold">GỢI Ý CHO BẠN</h2>
    </div>

    <div class="featured-products-wrapper" style="display:flex; overflow-x:auto; gap:1rem; scroll-snap-type:x mandatory; padding-bottom:1rem;">
        @foreach ($featuredProducts as $product)
            @php
                $avgRating = (float) ($product->reviews_avg_rating ?? 0);
                $rating    = (int) round($avgRating);

                $discount = $product->discount;
                $listPrice = (float) $product->list_price;

                $discountedPrice = $listPrice;
                $percentOff = 0;
                $hasDiscount = false;

                if ($discount && $listPrice > 0) {
                    $discountAmount = (float) ($discount->discount_amount ?? 0);
                    $isPercent = (int) ($discount->is_fixed ?? 0);

                    if ($isPercent === 0 && $discountAmount > 0) {
                        $percentOff = min(100, round($discountAmount));
                        $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
                    } elseif ($isPercent === 1 && $discountAmount > 0) {
                        $discountedPrice = max(0, $listPrice - $discountAmount);
                        $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
                    }

                    $hasDiscount = $discountedPrice < $listPrice;
                }
            @endphp

            <div class="card card-product h-100 border-0 shadow-sm rounded-3 overflow-hidden position-relative"
                 style="flex:0 0 auto; width:250px; scroll-snap-align:start;">
                 
                {{-- Badge % giảm giá --}}
                @if ($hasDiscount && $percentOff > 0)
                  <span class="position-absolute top-0 start-0 m-2 badge rounded-pill shadow"
                        style="background: linear-gradient(135deg,#007bff,#00c6ff); font-size:0.95rem; padding:0.4rem 0.7rem;z-index: 10;">
                    -{{ $percentOff }}%
                  </span>
                @endif      

                {{-- Ảnh sản phẩm --}}
                <div class="card-product__img position-relative overflow-hidden">
                  <img class="card-img-top"
                       src="{{ asset('storage/uploads/products/'.$product->image) }}"
                       alt="{{ $product->product_name }}"
                       style="height:200px; object-fit:cover; transition: transform .3s;">
                  <ul class="card-product__imgOverlay list-unstyled d-flex justify-content-center gap-2 position-absolute top-50 start-50 translate-middle opacity-0 transition-icons">
                    <li>
                        <a href="/product/{{ $product->id }}">
                            <button class="btn btn-light rounded-circle shadow-sm">
                                <i class="ti-search"></i>
                            </button>
                        </a>
                    </li>
                    <li>
                        <button class="btn btn-light rounded-circle shadow-sm add-to-cart" data-id="{{ $product->id }}">
                            <i class="ti-shopping-cart"></i>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-light rounded-circle shadow-sm btn-favorite" data-id="{{ $product->id }}">
                            <i class="ti-heart {{ in_array($product->id, session('favorites', [])) ? 'text-primary' : '' }}"></i>
                        </button> 
                    </li>
                  </ul>
                </div>

                {{-- Thông tin sản phẩm --}}
                <div class="card-body text-center">
                  <p class="text-muted small mb-1">{{ $product->category->categories_text ?? 'Danh mục' }}</p>
                  <h5 class="card-title fw-semibold">
                    <a href="/product/{{ $product->id }}" class="text-dark text-decoration-none">
                      {{ $product->product_name }}
                    </a>
                  </h5>

                  {{-- Rating --}}
                  <div class="mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                      @if ($i <= $rating) <i class="fas fa-star text-warning"></i>
                      @else              <i class="far fa-star text-warning"></i>
                      @endif
                    @endfor
                    <small class="text-muted">
                      @if ($avgRating > 0) ({{ number_format($avgRating,1) }}/5) @else (Chưa có đánh giá) @endif
                    </small>
                  </div>

                  {{-- Giá --}}
                  <p class="card-product__price mb-0">
                    <span class="fs-5 fw-bold text-danger">
                      {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                    </span>
                    @if ($hasDiscount)
                      <span class="text-muted ms-2 text-decoration-line-through small fst-italic"
                      style="text-decoration: line-through; text-decoration-thickness: 2px; text-decoration-color: #6c757d;">
                        {{ number_format($listPrice, 0, ',', '.') }} ₫
                      </span>
                    @endif
                  </p>

                </div>
            </div>
        @endforeach
    </div>
  </div>
</section>

<script>
  const slider = document.querySelector('.featured-products-wrapper'); // khai báo slider
  let isDown = false;
  let startX;
  let scrollLeft;

  // Khi nhấn chuột
  slider.addEventListener('mousedown', (e) => {
    isDown = true;
    slider.classList.add('active');
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
    slider.style.userSelect = 'none'; // tắt chọn text
  });

  // Khi nhả chuột
  slider.addEventListener('mouseup', () => {
    isDown = false;
    slider.classList.remove('active');
    slider.style.userSelect = 'auto'; // bật lại chọn text
  });

  // Khi chuột rời slider
  slider.addEventListener('mouseleave', () => {
    isDown = false;
    slider.classList.remove('active');
    slider.style.userSelect = 'auto';
  });

  // Khi di chuyển chuột
  slider.addEventListener('mousemove', (e) => {
    if(!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 2; // tốc độ kéo
    slider.scrollLeft = scrollLeft - walk;
  });
</script>

<style>
  .featured-products-wrapper {
    overflow-x: auto;
    scroll-behavior: smooth;
    display: flex;
    gap: 1rem;
    scroll-snap-type: x mandatory;

    /* Ẩn scrollbar */
    -ms-overflow-style: none;  /* IE 10+ */
    scrollbar-width: none;     /* Firefox */
  }

  .featured-products-wrapper::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
  }


  .featured-products-wrapper.active {
    cursor: grabbing;
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
 .card-title a {
    display: block;
    white-space: nowrap;       /* chỉ 1 dòng */
    overflow: hidden;          /* ẩn phần dư */
    text-overflow: ellipsis;   /* hiện ... */
  } 
</style>

<section class="ad-banner py-8 bg-gray-100">
  <div class="container mx-auto text-center mb-8 "style="padding-top: 20px;">
    <h2 class="text-3xl font-bold text-gray-800 tracking-wide flex items-center justify-center gap-3 ">
      Những sản phẩm nổi bật
    </h2>
  </div>
  <div class="carousel-layout">
    

  <div class="product-info 
              bg-white/90 dark:bg-gray-900/70
              backdrop-blur-lg 
              border border-gray-200/40 dark:border-white/10
              p-8 rounded-2xl shadow-lg 
              max-w-lg mx-auto text-center
              transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl">

    <h2 id="product-name" 
        class="text-2xl font-bold text-gray-800 dark:text-white mb-3">
      {{ $products[0]->product_name ?? '' }}
    </h2>

    <p id="product-desc" 
      class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
      {{ $products[0]->short_description ?? '' }}
    </p>

    <a id="product-link" 
      href="" 
      class="btn-buy inline-flex items-center gap-2 
            bg-gradient-to-r from-blue-500 to-indigo-500 
            text-white font-semibold px-6 py-3 rounded-xl 
            hover:from-blue-600 hover:to-indigo-600 
            transition-all duration-300 shadow-md hover:shadow-lg">
      <i class="fas fa-shopping-cart"></i> 
      Xem chi tiết
    </a>
  </div>


    <div class="carousel-container">
      <div class="carousel" id="carousel">
        @php
          $angle = 360 / max(1, $products->count());
          $distance = 700; // xa hơn để đẹp
        @endphp

        @foreach($products as $key => $product)
          <div class="item" 
               data-name="{{ $product->product_name }}"
               data-desc="{{ $product->short_description }}"
               data-link="/product/{{ $product->id }}"
               data-color="{{ $product->dominant_color ?? '#ffffff' }}"
               style="transform: rotateY({{ $key * $angle }}deg) translateZ({{ $distance }}px)">
            <img src="{{ asset('storage/uploads/products/'.$product->image) }}" alt="{{ $product->product_name }}">
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
<style>
  
  /* Nền gradient động */
  @keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .animate-gradient {
    background-size: 200% 200%;
    animation: gradientMove 12s ease infinite;
  }
  .carousel-layout {
    display: flex;
    flex-direction: column-reverse;   /* sắp xếp theo chiều dọc */
    justify-content: center;  /* căn giữa dọc */
    align-items: center;      /* căn giữa ngang */
    gap: 30px;                /* khoảng cách giữa carousel và info */
    padding: 20px;
    text-align: center;
  }

  .carousel-container {
    position: relative;
    width: 500px;    /* chỉnh theo ý */
    height: 400px;   /* chỉnh chiều cao khung */
    perspective: 1500px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .carousel {
    width: 100%;
    height: 100%;
    position: relative;
    transform-style: preserve-3d;
    transition: transform 1s;
  }

  .item {
    position: absolute;
    top: 50%;
    left: 50%;
    transform-origin: center center;
    transform-style: preserve-3d;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .item img {
    max-width: 250px;
    max-height: 250px;
    object-fit: contain;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }

  /* Khung thông tin */
  .product-info {
    max-width: 600px;
    text-align: center;   /* căn giữa chữ */
  }

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>
<script>
  const banner = document.querySelector(".ad-banner");
  const items = document.querySelectorAll(".carousel .item img");
  const colorThief = new ColorThief();
  let currentColor1 = "#f0f4f8"; 
  let currentColor2 = "#ffffff"; 

  items.forEach(img => {
    if (img.complete) {
      setColor(img);
    } else {
      img.addEventListener('load', () => setColor(img));
    }
  });

  function setColor(img) {
    try {
      const color = colorThief.getColor(img); 
      const palette = colorThief.getPalette(img, 3);
      const rgb1 = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
      const rgb2 = palette[1] 
        ? `rgb(${palette[1][0]}, ${palette[1][1]}, ${palette[1][2]})`
        : `rgba(255,255,255,0.9)`;
      img.parentElement.dataset.color = rgb1;
      img.parentElement.dataset.color2 = rgb2;
    } catch (e) {
      console.warn("Color extract failed:", e);
    }
  }

  // hover đổi màu nền
  document.querySelectorAll(".item").forEach(item => {
    item.addEventListener("mouseenter", () => {
      const color1 = item.dataset.color || "#ffffff";
      const color2 = item.dataset.color2 || "#f5f5f5";
      banner.style.transition = "background 1s ease-in-out";
      banner.style.background = `linear-gradient(135deg, ${color1} 0%, ${color2} 100%)`;

      // lưu màu cuối cùng
      currentColor1 = color1;
      currentColor2 = color2;
    });
  });

  // khi rời khỏi carousel -> giữ nguyên màu cuối
  document.querySelector(".carousel").addEventListener("mouseleave", () => {
    banner.style.background = `linear-gradient(135deg, ${currentColor1} 0%, ${currentColor2} 100%)`;
  });
</script>

<section class="section-margin calc-60px mt-4">
  <div class="container">
    <div class="section-introc pb-4 text-center">
      <p class="text-muted">Mặt hàng mới trên thị trường</p>
      <h2 class="fw-bold">Sản phẩm <span class="section-intro__style">Mới</span></h2>
    </div>

    <div class="row g-4">
      @foreach ($newProducts as $product)
        @php
            $avgRating = (float) ($product->reviews_avg_rating ?? 0);
            $rating    = (int) round($avgRating);

            // Lấy thông tin giảm giá
            $discount = $product->discount;
            $listPrice = (float) $product->list_price;

            $discountedPrice = $listPrice;
            $percentOff = 0;
            $hasDiscount = false;

            if ($discount && $listPrice > 0) {
                $discountAmount = (float) ($discount->discount_amount ?? 0);
                $isPercent = (int) ($discount->is_fixed ?? 0);

                if ($isPercent === 0 && $discountAmount > 0) {
                    // 0 = giảm theo %
                    $percentOff = min(100, round($discountAmount));
                    $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
                } elseif ($isPercent === 1 && $discountAmount > 0) {
                    // 1 = giảm theo số tiền cố định
                    $discountedPrice = max(0, $listPrice - $discountAmount);
                    $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
                }

                $hasDiscount = $discountedPrice < $listPrice;
            }
        @endphp
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card card-product h-100 border-0 shadow-sm rounded-3 overflow-hidden position-relative">

            {{-- Badge % giảm giá --}}
            @if ($hasDiscount && $percentOff > 0)
              <span class="position-absolute top-0 start-0 m-2 badge rounded-pill shadow"
                    style="background: linear-gradient(135deg,#007bff,#00c6ff);color: #fff; font-size:0.95rem; padding:0.4rem 0.7rem;z-index: 10;">
                -{{ $percentOff }}%
              </span>
            @endif      
            {{-- Ảnh sản phẩm --}}
            <div class="card-product__img position-relative overflow-hidden">
              <img class="card-img-top"
                   src="{{ asset('storage/uploads/products/'.$product->image) }}"
                   alt="{{ $product->product_name }}"
                   style="height:260px;object-fit:cover;transition: transform .3s;">
              <ul class="card-product__imgOverlay list-unstyled d-flex justify-content-center gap-2 position-absolute top-50 start-50 translate-middle opacity-0 transition-icons">
                <li>
                    <a href="/product/{{ $product->id }}">
                        <button class="btn btn-light rounded-circle shadow-sm">
                            <i class="ti-search"></i>
                        </button>
                    </a>
                </li>


                <li>
                    <button class="btn btn-light rounded-circle shadow-sm add-to-cart" data-id="{{ $product->id }}">
                        <i class="ti-shopping-cart"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-light rounded-circle shadow-sm btn-favorite" data-id="{{ $product->id }}">
                        <i class="ti-heart {{ in_array($product->id, session('favorites', [])) ? 'text-primary' : '' }}"></i>
                    </button> 
                </li>
              </ul>
            </div>

            {{-- Thông tin sản phẩm --}}
            <div class="card-body text-center">
              <p class="text-muted small mb-1">{{ $product->category->categories_text ?? 'Danh mục' }}</p>
              <h5 class="card-title fw-semibold">
                <a href="/product/{{ $product->id }}" class="text-dark text-decoration-none">
                  {{ $product->product_name }}
                </a>
              </h5>

              {{-- Rating --}}
              <div class="mb-2">
                @for ($i = 1; $i <= 5; $i++)
                  @if ($i <= $rating) <i class="fas fa-star text-warning"></i>
                  @else              <i class="far fa-star text-warning"></i>
                  @endif
                @endfor
                <small class="text-muted">
                  @if ($avgRating > 0) ({{ number_format($avgRating,1) }}/5) @else (Chưa có đánh giá) @endif
                </small>
              </div>

              {{-- Giá --}}
              <p class="card-product__price mb-0">
                <span class="fs-5 fw-bold text-danger">
                  {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                </span>
                @if ($hasDiscount)
                  <span class="text-muted ms-2 text-decoration-line-through small fst-italic"
                  style="text-decoration: line-through; text-decoration-thickness: 2px; text-decoration-color: #6c757d;">
                    {{ number_format($listPrice, 0, ',', '.') }} ₫
                  </span>
                @endif
              </p>

            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>



<section class="py-5 bg-white relative">
  <div class="container">
    <div class="logo-slider-wrapper">
      <div class="logo-slider">
        @foreach ($suppliers as $supplier)
          @if ($supplier->image)
            <div class="logo-item">
              <img src="{{ asset('storage/uploads/suppliers/logo/'.$supplier->image) }}"
                   alt="{{ $supplier->supplier_text }}"
                   loading="lazy">
            </div>
          @endif
        @endforeach
        {{-- nhân đôi để tạo hiệu ứng lặp vô tận --}}
        @foreach ($suppliers as $supplier)
          @if ($supplier->image)
            <div class="logo-item">
              <img src="{{ asset('storage/uploads/suppliers/logo/'.$supplier->image) }}"
                   alt="{{ $supplier->supplier_text }}"
                   loading="lazy">
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
</section>

<section class="section-margin calc-60px mt-4 pt-4">
  <div class="container position-relative">
    <div class="section-introc pb-4 d-flex justify-content-between align-items-center">
      <h2 class="fw-bold mb-0">ĐỒNG HỒ THÔNG MINH</h2>
      @php
          $suppliers = $watch->pluck('supplier')->filter()->unique('id');
      @endphp

      <div class="fw-bold d-flex flex-wrap gap-3">
          @foreach($suppliers as $supplier)
              <span class="chip">
                  {{ $supplier->supplier_text }}
              </span>
          @endforeach
      </div>
    </div>

    <style>
      .chip {
          display: inline-block;
          padding: 0.5rem 1rem;
          border: 1px solid #0d6efd;
          background-color: #f8f9fa;
          color: #0d6efd;
          font-weight: 500;
          font-size: 0.95rem;
          transition: all 0.2s ease-in-out;
          box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      }
      .chip:hover {
          background-color: #0d6efd;
          color: #fff;
          transform: translateY(-2px);
          cursor: pointer;
      }

      /* Wrapper 2 hàng */
      .featured-products-wrapper {
          display: grid;
          grid-auto-flow: column;
          grid-template-rows: repeat(2, 1fr);
          gap: 1rem;
          overflow-x: auto;
          scroll-snap-type: x mandatory;
          padding-bottom: 1rem;

          /* Ngăn bôi đen khi kéo */
          user-select: none;
          -webkit-user-drag: none;
      }
      .featured-products-wrapper::-webkit-scrollbar {
          display: none;
      }

      .card-product {
          width: 250px;
          scroll-snap-align: start;
          display: flex;
          flex-direction: column;
      }

      .card-product__img {
          position: relative;
          overflow: hidden;
      }
      .card-product__imgOverlay {
          opacity: 0;
          transition: all 0.3s ease;
      }
      .card-product__img:hover .card-product__imgOverlay {
          opacity: 1;
      }

      .nav-arrow {
          position: absolute;
          top: 40%;
          transform: translateY(-50%);
          background: white;
          border: none;
          border-radius: 50%;
          box-shadow: 0 2px 8px rgba(0,0,0,0.2);
          width: 40px;
          height: 40px;
          cursor: pointer;
          z-index: 20;
      }
      .nav-arrow.left {
          left: -20px;
      }
      .nav-arrow.right {
          right: -20px;
      }
    </style>
    <!-- Buttons -->
    <button class="nav-arrow left" onclick="scrollProducts(-1)">&#8249;</button>
    <button class="nav-arrow right" onclick="scrollProducts(1)">&#8250;</button>

    <!-- Wrapper -->
    <div class="products-container featured-products-wrapper">
        @foreach ($watch as $product)
        @php
            $avgRating = (float) ($product->reviews_avg_rating ?? 0);
            $rating    = (int) round($avgRating);

            // Lấy thông tin giảm giá
            $discount = $product->discount;
            $listPrice = (float) $product->list_price;

            $discountedPrice = $listPrice;
            $percentOff = 0;
            $hasDiscount = false;

            if ($discount && $listPrice > 0) {
                $discountAmount = (float) ($discount->discount_amount ?? 0);
                $isPercent = (int) ($discount->is_fixed ?? 0);

                if ($isPercent === 0 && $discountAmount > 0) {
                    // 0 = giảm theo %
                    $percentOff = min(100, round($discountAmount));
                    $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
                } elseif ($isPercent === 1 && $discountAmount > 0) {
                    // 1 = giảm theo số tiền cố định
                    $discountedPrice = max(0, $listPrice - $discountAmount);
                    $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
                }

                $hasDiscount = $discountedPrice < $listPrice;
            }
        @endphp
          <div class="card card-product h-100 border-0 shadow-sm rounded-3 overflow-hidden position-relative">

            {{-- Badge % giảm giá --}}
            @if ($hasDiscount && $percentOff > 0)
              <span class="position-absolute top-0 start-0 m-2 badge rounded-pill shadow"
                    style="background: linear-gradient(135deg,#007bff,#00c6ff); font-size:0.95rem; padding:0.4rem 0.7rem;z-index: 10;">
                -{{ $percentOff }}%
              </span>
            @endif      
            {{-- Ảnh sản phẩm --}}
            <div class="card-product__img position-relative overflow-hidden">
              <img class="card-img-top"
                   src="{{ asset('storage/uploads/products/'.$product->image) }}"
                   alt="{{ $product->product_name }}"
                   style="height:260px;object-fit:cover;transition: transform .3s;">
              <ul class="card-product__imgOverlay list-unstyled d-flex justify-content-center gap-2 position-absolute top-50 start-50 translate-middle opacity-0 transition-icons">
                <li>
                    <a href="/product/{{ $product->id }}">
                        <button class="btn btn-light rounded-circle shadow-sm">
                            <i class="ti-search"></i>
                        </button>
                    </a>
                </li>


                <li>
                    <button class="btn btn-light rounded-circle shadow-sm add-to-cart" data-id="{{ $product->id }}">
                        <i class="ti-shopping-cart"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-light rounded-circle shadow-sm btn-favorite" data-id="{{ $product->id }}">
                        <i class="ti-heart {{ in_array($product->id, session('favorites', [])) ? 'text-primary' : '' }}"></i>
                    </button> 
                </li>
              </ul>
            </div>

            {{-- Thông tin sản phẩm --}}
            <div class="card-body text-center">
              <p class="text-muted small mb-1">{{ $product->category->categories_text ?? 'Danh mục' }}</p>
              <h5 class="card-title fw-semibold">
                <a href="/product/{{ $product->id }}" class="text-dark text-decoration-none">
                  {{ $product->product_name }}
                </a>
              </h5>

              {{-- Rating --}}
              <div class="mb-2">
                @for ($i = 1; $i <= 5; $i++)
                  @if ($i <= $rating) <i class="fas fa-star text-warning"></i>
                  @else              <i class="far fa-star text-warning"></i>
                  @endif
                @endfor
                <small class="text-muted">
                  @if ($avgRating > 0) ({{ number_format($avgRating,1) }}/5) @else (Chưa có đánh giá) @endif
                </small>
              </div>

              {{-- Giá --}}
              <p class="card-product__price mb-0">
                <span class="fs-5 fw-bold text-danger">
                  {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                </span>
                @if ($hasDiscount)
                  <span class="text-muted ms-2 text-decoration-line-through small fst-italic"
                  style="text-decoration: line-through; text-decoration-thickness: 2px; text-decoration-color: #6c757d;">
                    {{ number_format($listPrice, 0, ',', '.') }} ₫
                  </span>
                @endif
              </p>

            </div>
          </div>
      @endforeach
    </div>
  </div>
</section>



<section class="section-margin calc-60px mt-4 pt-4">
  <div class="container position-relative">
    <div class="section-introc pb-4 d-flex justify-content-between align-items-center">
      <h2 class="fw-bold mb-0">MÀN HÌNH MÁY TÍNH</h2>
      @php
          $suppliers = $screen->pluck('supplier')->filter()->unique('id');
      @endphp

      <div class="fw-bold d-flex flex-wrap gap-3">
          @foreach($suppliers as $supplier)
              <span class="chip">
                  {{ $supplier->supplier_text }}
              </span>
          @endforeach
      </div>
    </div>

    <style>
      .chip {
          display: inline-block;
          padding: 0.5rem 1rem;
          border: 1px solid #0d6efd;
          background-color: #f8f9fa;
          color: #0d6efd;
          font-weight: 500;
          font-size: 0.95rem;
          transition: all 0.2s ease-in-out;
          box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      }
      .chip:hover {
          background-color: #0d6efd;
          color: #fff;
          transform: translateY(-2px);
          cursor: pointer;
      }

      /* Wrapper 2 hàng */
      .featured-products-wrapper {
          display: grid;
          grid-auto-flow: column;
          grid-template-rows: repeat(2, 1fr);
          gap: 1rem;
          overflow-x: auto;
          scroll-snap-type: x mandatory;
          padding-bottom: 1rem;

          /* Ngăn bôi đen khi kéo */
          user-select: none;
          -webkit-user-drag: none;
      }
      .featured-products-wrapper::-webkit-scrollbar {
          display: none;
      }

      .card-product {
          width: 250px;
          scroll-snap-align: start;
          display: flex;
          flex-direction: column;
      }

      .card-product__img {
          position: relative;
          overflow: hidden;
      }
      .card-product__imgOverlay {
          opacity: 0;
          transition: all 0.3s ease;
      }
      .card-product__img:hover .card-product__imgOverlay {
          opacity: 1;
      }

      .nav-arrow {
          position: absolute;
          top: 40%;
          transform: translateY(-50%);
          background: white;
          border: none;
          border-radius: 50%;
          box-shadow: 0 2px 8px rgba(0,0,0,0.2);
          width: 40px;
          height: 40px;
          cursor: pointer;
          z-index: 20;
      }
      .nav-arrow.left {
          left: -20px;
      }
      .nav-arrow.right {
          right: -20px;
      }
    </style>
    <!-- Buttons -->
    <button class="nav-arrow left" onclick="scrollProducts(-1)">&#8249;</button>
    <button class="nav-arrow right" onclick="scrollProducts(1)">&#8250;</button>

    <!-- Wrapper -->
    <div  class="products-container featured-products-wrapper">
        @foreach ($screen as $product)
        @php
            $avgRating = (float) ($product->reviews_avg_rating ?? 0);
            $rating    = (int) round($avgRating);

            // Lấy thông tin giảm giá
            $discount = $product->discount;
            $listPrice = (float) $product->list_price;

            $discountedPrice = $listPrice;
            $percentOff = 0;
            $hasDiscount = false;

            if ($discount && $listPrice > 0) {
                $discountAmount = (float) ($discount->discount_amount ?? 0);
                $isPercent = (int) ($discount->is_fixed ?? 0);

                if ($isPercent === 0 && $discountAmount > 0) {
                    // 0 = giảm theo %
                    $percentOff = min(100, round($discountAmount));
                    $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
                } elseif ($isPercent === 1 && $discountAmount > 0) {
                    // 1 = giảm theo số tiền cố định
                    $discountedPrice = max(0, $listPrice - $discountAmount);
                    $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
                }

                $hasDiscount = $discountedPrice < $listPrice;
            }
        @endphp
          <div class="card card-product h-100 border-0 shadow-sm rounded-3 overflow-hidden position-relative">

            {{-- Badge % giảm giá --}}
            @if ($hasDiscount && $percentOff > 0)
              <span class="position-absolute top-0 start-0 m-2 badge rounded-pill shadow"
                    style="background: linear-gradient(135deg,#007bff,#00c6ff); font-size:0.95rem; padding:0.4rem 0.7rem;z-index: 10;">
                -{{ $percentOff }}%
              </span>
            @endif      
            {{-- Ảnh sản phẩm --}}
            <div class="card-product__img position-relative overflow-hidden">
              <img class="card-img-top"
                   src="{{ asset('storage/uploads/products/'.$product->image) }}"
                   alt="{{ $product->product_name }}"
                   style="height:260px;object-fit:cover;transition: transform .3s;">
              <ul class="card-product__imgOverlay list-unstyled d-flex justify-content-center gap-2 position-absolute top-50 start-50 translate-middle opacity-0 transition-icons">
                <li>
                    <a href="/product/{{ $product->id }}">
                        <button class="btn btn-light rounded-circle shadow-sm">
                            <i class="ti-search"></i>
                        </button>
                    </a>
                </li>


                <li>
                    <button class="btn btn-light rounded-circle shadow-sm add-to-cart" data-id="{{ $product->id }}">
                        <i class="ti-shopping-cart"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-light rounded-circle shadow-sm btn-favorite" data-id="{{ $product->id }}">
                        <i class="ti-heart {{ in_array($product->id, session('favorites', [])) ? 'text-primary' : '' }}"></i>
                    </button> 
                </li>
              </ul>
            </div>

            {{-- Thông tin sản phẩm --}}
            <div class="card-body text-center">
              <p class="text-muted small mb-1">{{ $product->category->categories_text ?? 'Danh mục' }}</p>
              <h5 class="card-title fw-semibold">
                <a href="/product/{{ $product->id }}" class="text-dark text-decoration-none">
                  {{ $product->product_name }}
                </a>
              </h5>

              {{-- Rating --}}
              <div class="mb-2">
                @for ($i = 1; $i <= 5; $i++)
                  @if ($i <= $rating) <i class="fas fa-star text-warning"></i>
                  @else              <i class="far fa-star text-warning"></i>
                  @endif
                @endfor
                <small class="text-muted">
                  @if ($avgRating > 0) ({{ number_format($avgRating,1) }}/5) @else (Chưa có đánh giá) @endif
                </small>
              </div>

              {{-- Giá --}}
              <p class="card-product__price mb-0">
                <span class="fs-5 fw-bold text-danger">
                  {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                </span>
                @if ($hasDiscount)
                  <span class="text-muted ms-2 text-decoration-line-through small fst-italic"
                  style="text-decoration: line-through; text-decoration-thickness: 2px; text-decoration-color: #6c757d;">
                    {{ number_format($listPrice, 0, ',', '.') }} ₫
                  </span>
                @endif
              </p>

            </div>
          </div>
      @endforeach
    </div>
  </div>
</section>


<section class="section-margin calc-60px mt-4 pt-4">
  <div class="container position-relative">
    <div class="section-introc pb-4 d-flex justify-content-between align-items-center">
      <h2 class="fw-bold mb-0">MÁY TÍNH BẢNG</h2>
      @php
          $suppliers = $screenIpad->pluck('supplier')->filter()->unique('id');
      @endphp

      <div class="fw-bold d-flex flex-wrap gap-3">
          @foreach($suppliers as $supplier)
              <span class="chip">
                  {{ $supplier->supplier_text }}
              </span>
          @endforeach
      </div>
    </div>
    <!-- Buttons -->
    <button class="nav-arrow left" onclick="scrollProducts(-1)">&#8249;</button>
    <button class="nav-arrow right" onclick="scrollProducts(1)">&#8250;</button>

    <!-- Wrapper -->
    <div  class="products-container featured-products-wrapper">
        @foreach ($screenIpad as $product)
        @php
            $avgRating = (float) ($product->reviews_avg_rating ?? 0);
            $rating    = (int) round($avgRating);

            // Lấy thông tin giảm giá
            $discount = $product->discount;
            $listPrice = (float) $product->list_price;

            $discountedPrice = $listPrice;
            $percentOff = 0;
            $hasDiscount = false;

            if ($discount && $listPrice > 0) {
                $discountAmount = (float) ($discount->discount_amount ?? 0);
                $isPercent = (int) ($discount->is_fixed ?? 0);

                if ($isPercent === 0 && $discountAmount > 0) {
                    // 0 = giảm theo %
                    $percentOff = min(100, round($discountAmount));
                    $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
                } elseif ($isPercent === 1 && $discountAmount > 0) {
                    // 1 = giảm theo số tiền cố định
                    $discountedPrice = max(0, $listPrice - $discountAmount);
                    $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
                }

                $hasDiscount = $discountedPrice < $listPrice;
            }
        @endphp
          <div class="card card-product h-100 border-0 shadow-sm rounded-3 overflow-hidden position-relative">

            {{-- Badge % giảm giá --}}
            @if ($hasDiscount && $percentOff > 0)
              <span class="position-absolute top-0 start-0 m-2 badge rounded-pill shadow"
                    style="background: linear-gradient(135deg,#007bff,#00c6ff); font-size:0.95rem; padding:0.4rem 0.7rem;z-index: 10;">
                -{{ $percentOff }}%
              </span>
            @endif      
            {{-- Ảnh sản phẩm --}}
            <div class="card-product__img position-relative overflow-hidden">
              <img class="card-img-top"
                   src="{{ asset('storage/uploads/products/'.$product->image) }}"
                   alt="{{ $product->product_name }}"
                   style="height:260px;object-fit:cover;transition: transform .3s;">
              <ul class="card-product__imgOverlay list-unstyled d-flex justify-content-center gap-2 position-absolute top-50 start-50 translate-middle opacity-0 transition-icons">
                <li>
                    <a href="/product/{{ $product->id }}">
                        <button class="btn btn-light rounded-circle shadow-sm">
                            <i class="ti-search"></i>
                        </button>
                    </a>
                </li>


                <li>
                    <button class="btn btn-light rounded-circle shadow-sm add-to-cart" data-id="{{ $product->id }}">
                        <i class="ti-shopping-cart"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-light rounded-circle shadow-sm btn-favorite" data-id="{{ $product->id }}">
                        <i class="ti-heart {{ in_array($product->id, session('favorites', [])) ? 'text-primary' : '' }}"></i>
                    </button> 
                </li>
              </ul>
            </div>

            {{-- Thông tin sản phẩm --}}
            <div class="card-body text-center">
              <p class="text-muted small mb-1">{{ $product->category->categories_text ?? 'Danh mục' }}</p>
              <h5 class="card-title fw-semibold">
                <a href="/product/{{ $product->id }}" class="text-dark text-decoration-none">
                  {{ $product->product_name }}
                </a>
              </h5>

              {{-- Rating --}}
              <div class="mb-2">
                @for ($i = 1; $i <= 5; $i++)
                  @if ($i <= $rating) <i class="fas fa-star text-warning"></i>
                  @else              <i class="far fa-star text-warning"></i>
                  @endif
                @endfor
                <small class="text-muted">
                  @if ($avgRating > 0) ({{ number_format($avgRating,1) }}/5) @else (Chưa có đánh giá) @endif
                </small>
              </div>

              {{-- Giá --}}
              <p class="card-product__price mb-0">
                <span class="fs-5 fw-bold text-danger">
                  {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                </span>
                @if ($hasDiscount)
                  <span class="text-muted ms-2 text-decoration-line-through small fst-italic"
                  style="text-decoration: line-through; text-decoration-thickness: 2px; text-decoration-color: #6c757d;">
                    {{ number_format($listPrice, 0, ',', '.') }} ₫
                  </span>
                @endif
              </p>

            </div>
          </div>
      @endforeach
    </div>
  </div>
</section>


<section class="section-margin calc-60px mt-4 pt-4">
  <div class="container position-relative">
    <div class="section-introc pb-4 d-flex justify-content-between align-items-center">
      <h2 class="fw-bold mb-0">LAPTOP</h2>
      @php
          $suppliers = $LAPTOP->pluck('supplier')->filter()->unique('id');
      @endphp

      <div class="fw-bold d-flex flex-wrap gap-3">
          @foreach($suppliers as $supplier)
              <span class="chip">
                  {{ $supplier->supplier_text }}
              </span>
          @endforeach
      </div>
    </div>
    <!-- Buttons -->
    <button class="nav-arrow left" onclick="scrollProducts(-1)">&#8249;</button>
    <button class="nav-arrow right" onclick="scrollProducts(1)">&#8250;</button>

    <!-- Wrapper -->
    <div  class="products-container featured-products-wrapper">
        @foreach ($LAPTOP as $product)
        @php
            $avgRating = (float) ($product->reviews_avg_rating ?? 0);
            $rating    = (int) round($avgRating);

            // Lấy thông tin giảm giá
            $discount = $product->discount;
            $listPrice = (float) $product->list_price;

            $discountedPrice = $listPrice;
            $percentOff = 0;
            $hasDiscount = false;

            if ($discount && $listPrice > 0) {
                $discountAmount = (float) ($discount->discount_amount ?? 0);
                $isPercent = (int) ($discount->is_fixed ?? 0);

                if ($isPercent === 0 && $discountAmount > 0) {
                    // 0 = giảm theo %
                    $percentOff = min(100, round($discountAmount));
                    $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
                } elseif ($isPercent === 1 && $discountAmount > 0) {
                    // 1 = giảm theo số tiền cố định
                    $discountedPrice = max(0, $listPrice - $discountAmount);
                    $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
                }

                $hasDiscount = $discountedPrice < $listPrice;
            }
        @endphp
          <div class="card card-product h-100 border-0 shadow-sm rounded-3 overflow-hidden position-relative">

            {{-- Badge % giảm giá --}}
            @if ($hasDiscount && $percentOff > 0)
              <span class="position-absolute top-0 start-0 m-2 badge rounded-pill shadow"
                    style="background: linear-gradient(135deg,#007bff,#00c6ff); font-size:0.95rem; padding:0.4rem 0.7rem;z-index: 10;">
                -{{ $percentOff }}%
              </span>
            @endif      
            {{-- Ảnh sản phẩm --}}
            <div class="card-product__img position-relative overflow-hidden">
              <img class="card-img-top"
                   src="{{ asset('storage/uploads/products/'.$product->image) }}"
                   alt="{{ $product->product_name }}"
                   style="height:260px;object-fit:cover;transition: transform .3s;">
              <ul class="card-product__imgOverlay list-unstyled d-flex justify-content-center gap-2 position-absolute top-50 start-50 translate-middle opacity-0 transition-icons">
                <li>
                    <a href="/product/{{ $product->id }}">
                        <button class="btn btn-light rounded-circle shadow-sm">
                            <i class="ti-search"></i>
                        </button>
                    </a>
                </li>


                <li>
                    <button class="btn btn-light rounded-circle shadow-sm add-to-cart" data-id="{{ $product->id }}">
                        <i class="ti-shopping-cart"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-light rounded-circle shadow-sm btn-favorite" data-id="{{ $product->id }}">
                        <i class="ti-heart {{ in_array($product->id, session('favorites', [])) ? 'text-primary' : '' }}"></i>
                    </button> 
                </li>
              </ul>
            </div>

            {{-- Thông tin sản phẩm --}}
            <div class="card-body text-center">
              <p class="text-muted small mb-1">{{ $product->category->categories_text ?? 'Danh mục' }}</p>
              <h5 class="card-title fw-semibold">
                <a href="/product/{{ $product->id }}" class="text-dark text-decoration-none">
                  {{ $product->product_name }}
                </a>
              </h5>

              {{-- Rating --}}
              <div class="mb-2">
                @for ($i = 1; $i <= 5; $i++)
                  @if ($i <= $rating) <i class="fas fa-star text-warning"></i>
                  @else              <i class="far fa-star text-warning"></i>
                  @endif
                @endfor
                <small class="text-muted">
                  @if ($avgRating > 0) ({{ number_format($avgRating,1) }}/5) @else (Chưa có đánh giá) @endif
                </small>
              </div>

              {{-- Giá --}}
              <p class="card-product__price mb-0">
                <span class="fs-5 fw-bold text-danger">
                  {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                </span>
                @if ($hasDiscount)
                  <span class="text-muted ms-2 text-decoration-line-through small fst-italic"
                  style="text-decoration: line-through; text-decoration-thickness: 2px; text-decoration-color: #6c757d;">
                    {{ number_format($listPrice, 0, ',', '.') }} ₫
                  </span>
                @endif
              </p>

            </div>
          </div>
      @endforeach
    </div>
  </div>
</section>

<section class="section-margin py-4">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-center custom-gap">
      @foreach ($ProductPost as $item)
        <div class="post-image-box overflow-hidden rounded-3 shadow-sm">
          <img 
            src="{{ asset('storage/uploads/posts/'.$item->image) }}" 
            alt="Post Image" 
            class="post-image">
        </div>
      @endforeach
    </div>
  </div>
</section>

<style>
/* Khoảng cách giữa các ảnh */
.custom-gap {
  gap: 30px; /* có thể điều chỉnh 20px, 25px, 30px tùy bạn muốn rộng bao nhiêu */
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
document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        let name = this.dataset.name;
        let price = this.dataset.price;

        fetch("{{ route('cart.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({id, name, price})
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                // Update số lượng hiển thị
                document.querySelector('.nav-shop__circle').innerText = data.cart_count;

                // Toastify thông báo
                Toastify({
                    text: data.message,
                    duration: 2000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#007bff"
                }).showToast();
            }
        });
    });
});
</script>

<script>
    $(document).ready(function(){
        $('.btn-favorite').on('click', function(){
            let btn = $(this);
            let productId = btn.data('id');

            $.ajax({
                url: '/favorites/add', // Route Laravel thêm yêu thích
                type: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res){
                    if(res.success){
                        // Đổi màu icon tim
                        btn.find('i').addClass('text-primary');

                        // Kiểm tra trùng trước khi append dropdown
                        if ($('#favorite-list').find('[data-id="'+productId+'"]').length === 0) {
                            let product = res.product;
                            let html = `
                                <div class="d-flex align-items-center mb-2" data-id="${product.id}">
                                    <img src="${product.image}" class="mr-2 rounded" alt="${product.name}" style="width:40px;height:40px;object-fit:cover;">
                                    <div>
                                        <p class="mb-0 small">${product.name}</p>
                                        <span class="text-danger small">${product.price}</span>
                                    </div>
                                </div>
                            `;
                            $('#favorite-list').prepend(html);
                        }

                        // Cập nhật số lượng
                        $('.nav-shop__circle').text($('#favorite-list > div').length);

                        // Hiển thị toast
                        Toastify({
                            text: `"${res.product.name}" đã thêm vào danh sách yêu thích`,
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#007bff",
                        }).showToast();
                    }
                },
                error: function(){
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

        // Hover dropdown show
        $('.nav-item.dropdown').hover(
            function() { $(this).addClass('show'); $(this).find('.dropdown-menu').addClass('show'); },
            function() { $(this).removeClass('show'); $(this).find('.dropdown-menu').removeClass('show'); }
        );
    });

</script>

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
<script>
document.addEventListener("DOMContentLoaded", function () {
  const containers = document.querySelectorAll('.products-container');

  // Áp dụng sự kiện cho từng container riêng
  containers.forEach((container, index) => {
    // --- Kéo chuột PC ---
    let isDown = false;
    let startX;
    let scrollLeft;

    container.addEventListener('mousedown', (e) => {
      isDown = true;
      startX = e.pageX - container.offsetLeft;
      scrollLeft = container.scrollLeft;
    });
    container.addEventListener('mouseleave', () => { isDown = false; });
    container.addEventListener('mouseup', () => { isDown = false; });
    container.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - container.offsetLeft;
      const walk = (x - startX) * 1.5;
      container.scrollLeft = scrollLeft - walk;
    });

    // --- Vuốt trên mobile ---
    let startTouchX = 0;
    container.addEventListener('touchstart', (e) => {
      startTouchX = e.touches[0].pageX;
      scrollLeft = container.scrollLeft;
    });
    container.addEventListener('touchmove', (e) => {
      const x = e.touches[0].pageX;
      const walk = (x - startTouchX) * 1.5;
      container.scrollLeft = scrollLeft - walk;
    });
  });

  // --- Nút mũi tên ---
  window.scrollProducts = function(sectionIndex, direction) {
    const container = containers[sectionIndex];
    if (!container) return;
    const scrollAmount = 270; // 1 card
    container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
  };
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
      text-shadow: 0 4px 10px rgba(0,0,0,0.6);
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
      text-shadow: 0 4px 10px rgba(0,0,0,0.6);
      opacity: 0;
      background: rgba(0,0,0,0.3);
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
      box-shadow: 0 6px 18px rgba(0,0,0,0.25);
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
      inset: -2px; /* viền bao quanh */
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
      opacity: 0; /* ẩn khi chưa hover */
      transition: opacity 0.4s ease;
  }

  .banner-wrapper:hover::before {
      opacity: 1; /* hiện khi hover */
  }

  /* Animation gradient */
  @keyframes gradientBorder {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
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
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
  }

    .card-product__img:hover img {
    transform: scale(1.05);
  }
  .card-product__imgOverlay button {
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .card-product__imgOverlay button:hover {
    transform: scale(1.2);
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
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
    height: 450px; /* Chiều cao cố định cho đồng đều */
    overflow: hidden;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
  }

  .hero-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Giữ tỷ lệ, lấp đầy khung */
    transition: transform 0.4s ease;
  }

  .hero-image-wrapper img:hover {
    transform: scale(1.08); /* zoom nhẹ khi hover */
  }

  /* Overlay mờ */
  .hero-carousel__slideOverlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.1) 40%, rgba(0,0,0,0.6) 100%);
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
    background: linear-gradient(180deg, rgba(0,0,0,0.2) 30%, rgba(0,0,0,0.75) 100%);
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
    from { opacity: 0; transform: translateX(-50px); }
    to { opacity: 1; transform: translateX(0); }
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
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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
    overflow: visible; /* không cho bôi đen */
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
    box-shadow: 0 12px 30px rgba(0,0,0,0.35);
    transition: transform 0.3s ease;
    pointer-events: none; /* fix click không chọn ảnh */
  }

  .item img:hover {
    transform: scale(1.05);
  }

  .item p {
    margin-top: 12px;
    background: rgba(0,0,0,0.65);
    color: #fff;
    padding: 6px 14px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 500;
    user-select: none; /* không cho bôi đen chữ */
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
</style>

@section('user.js')

<script>
  $("#load-more").on("click", function() {
    $.ajax({
      url: "/products/category/{{ $category->id }}?page=2",
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
document.addEventListener("DOMContentLoaded", function () {
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

<script>

  $(document).ready(function(){

      // Click icon yêu thích
      $(document).on("click", ".btn-favorite", function(e){
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
              success: function(res){
                  if(res.success){
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
              error: function(){
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
    $(document).on("click", ".btn-remove-favorite", function(e){
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
            success: function(res){
                if(res.success){
                    // ✅ Xóa khỏi DOM
                    item.remove();

                    // ✅ Cập nhật số lượng navbar
                    $(".nav-favorites__count").text(res.count);

                    // Nếu hết sản phẩm, hiển thị thông báo
                    if(res.count === 0){
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
            error: function(){
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
                    body: JSON.stringify({ product_id: productId })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success){
                        // 1️⃣ Cập nhật số lượng navbar
                        document.querySelector('.nav-cart__count').textContent = data.cart_count;

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
                        const cartItems = document.querySelector('.cart-dropdown .cart-items');
                        const cartTotal = document.querySelector('.cart-dropdown .cart-total');

                        if(cartItems){
                            const emptyMsg = cartItems.querySelector('.empty-cart');
                            if(emptyMsg) emptyMsg.remove();

                            let existingItem = cartItems.querySelector(`.cart-item[data-id="${data.product.id}"]`);
                            if(existingItem){
                                existingItem.querySelector('.small.text-muted').textContent = 'x' + data.product.quantity;
                            } else {
                                const newItem = document.createElement('div');
                                newItem.className = 'd-flex align-items-center mb-2 cart-item';
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

                            if(cartTotal){
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

</script>
@endsection