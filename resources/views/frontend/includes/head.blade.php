
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
	<link rel="icon" href="img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="{{ asset('/frontend/vendors/bootstrap/bootstrap.min.css') }}  ">
  <link rel="stylesheet" href="{{ asset('/frontend/vendors/fontawesome/css/all.min.css') }}   ">
	<link rel="stylesheet" href="{{ asset('/frontend/vendors/themify-icons/themify-icons.css') }}  ">
  <link rel="stylesheet" href="{{ asset('/frontend/vendors/nice-select/nice-select.css') }}  ">
  <link rel="stylesheet" href="{{ asset('/frontend/vendors/owl-carousel/owl.theme.default.min.css') }}  ">
  <link rel="stylesheet" href="{{ asset('/frontend/vendors/owl-carousel/owl.carousel.min.css') }}  ">

  <link rel="stylesheet" href="{{ asset('/frontend/css/style.css') }}  ">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>