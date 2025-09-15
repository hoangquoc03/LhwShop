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

  <!--================ Start footer Area  =================-->	
  @include('frontend/includes/footer')
	
	<!--================ End footer Area  =================-->
	@include('frontend/includes/script')
  @yield('user.js')
</body>
</html>