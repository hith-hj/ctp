<meta charset="utf-8">
<title>Click To Pick | @yield('title')</title>

<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="Click To Pick" name="keywords">
<meta content="The Best Beauty Products Online Shop" name="description">
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

<!-- Favicon -->
<link href="{{asset('icons/icon.png')}}" rel="icon">

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('web/css/intlTelInput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('web/css/fontawesome-free/css/all.min.css')}}">

<!-- Libraries Stylesheet -->

<!-- Customized Bootstrap Stylesheet -->
<link rel="stylesheet" type="text/css" href="{{asset('web/lib/owlcarousel/assets/owl.carousel.min.css')}}">

@if(!checkCurrentLang())
    <link rel="stylesheet" type="text/css" href="{{asset('web/css/style.css')}}">
@else
    <link rel="stylesheet" type="text/css" href="{{asset('web/css/style-ar.css')}}">
@endif
<script src="{{asset('web/js/jquery/jquery.min.js')}}"></script>

<input type="hidden" id="router"
       data-add-to-cart="{{route('AddToCart')}}"
       data-add-to-wish="{{route('user.add-wishlist')}}"
       data-remove-products="{{route('user.remove-products')}}"
       data-update-cart="{{route('user.update-cart')}}">

<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<input type="hidden" id="product_url" value="{{route('user.get-product-details')}}">
<input type="hidden" id="add_to_cart_url" value="{{route('AddToCart')}}">
<input type="hidden" id="add_to_wishlist" value="{{route('user.wishlist')}}">
<input type="hidden" id="checkout_id" value="{{route('checkout')}}">
<input type="hidden" id="cart_id" value="{{route('cart')}}">
<input type="hidden" id="main_currancy" value="{{getAppCurrency()->symbol}}">




