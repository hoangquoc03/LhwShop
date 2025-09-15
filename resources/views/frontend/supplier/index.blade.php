@extends('frontend.master')
@section('title',$category->categories_text ?? 'Sản phẩm')

@section('page-style')
<section class="section-margin calc-60px">
  <div class="container">
    <div class="section-intro pb-4 text-center">
      <h2 class="fw-bold">
        Sản phẩm của hãng <span class="section-intro__style">{{ $supplier->supplier_text }}</span>
      </h2>
    </div>

    <div class="row g-4">
      @forelse ($products as $product)
        <div class="col-md-3">
          <div class="card h-100">
            <img src="{{ $product->image ? asset('storage/uploads/products/'.$product->image) : asset('images/no-image.png') }}"
                 class="card-img-top" alt="{{ $product->product_name }}">
            <div class="card-body">
              <h5>{{ $product->product_name }}</h5>
              <p class="text-danger fw-bold">{{ number_format($product->list_price, 0, ',', '.') }} ₫</p>
            </div>
          </div>
        </div>
      @empty
        <p class="text-center">Không có sản phẩm nào của hãng này.</p>
      @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
      {{ $products->links() }}
    </div>
  </div>
</section>

@endsection

@section('user.js')
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