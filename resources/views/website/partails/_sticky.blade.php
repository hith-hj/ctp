<div class="sticky-footer sticky-content fix-bottom">
    <a href="{{route('user.index')}}" class="sticky-link active">
        <i class="w-icon-home"></i>
        <p>{{__('front.home')}}</p>
    </a>
    <a href="{{route('user.products.index')}}" class="sticky-link">
        <i class="w-icon-category"></i>
        <p>{{__('front.shop')}}</p>
    </a>
    <a href="{{route('user.about')}}" class="sticky-link">
        <i class="w-icon-account"></i>
        <p>{{__('front.about')}}</p>
    </a>
    <div class="cart-dropdown dir-up">
        <a href="{{route('cart')}}" class="sticky-link">
            <i class="w-icon-cart"></i>
            <p>
               {{__('front.cart')}}

            </p>
        </a>

        <!-- End of Dropdown Box -->
    </div>

    <div class="header-search hs-toggle dir-up">
        <a href="#" class="search-toggle sticky-link">
            <i class="w-icon-search"></i>
            <p>{{__("front.search")}}</p>
        </a>
        <form method="get" action="{{route('user.products.index')}}" class="input-wrapper">

            <input type="text" class="form-control" name="search" autocomplete="off" placeholder="{{__('front.Search_in')}}" required />
            <button class="btn btn-search" type="submit">
                <i class="w-icon-search"></i>
            </button>



        </form>
    </div>
</div>
<!-- End of Sticky Footer -->

<!-- Start of Scroll Top -->
<a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i class="fas fa-chevron-up"></i></a>
<!-- End of Scroll Top -->

<!-- Start of Mobile Menu -->
<div class="mobile-menu-wrapper">
    <div class="mobile-menu-overlay"></div>
    <!-- End of .mobile-menu-overlay -->

    <a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
    <!-- End of .mobile-menu-close -->

    <div class="mobile-menu-container scrollable">
        <form action="{{route('user.products.index')}}" method="get" class="input-wrapper">
            <input type="text" class="form-control" name="search" autocomplete="off" placeholder="{{__('front.Search_in')}}" required />
            <button class="btn btn-search" type="submit">
                <i class="w-icon-search"></i>
            </button>
        </form>
        <!-- End of Search Form -->
        <div class="tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#main-menu" class="nav-link ">{{__('front.main_menu')}}</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="#categories" class="nav-link">{{__('front.category')}}</a>
                </li> --}}
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="main-menu">
                <ul class="mobile-menu">
                    <li><a href="{{route('user.index')}}">{{__('front.home')}}</a></li>
                    <li>
                        <a href="{{route('user.products.index')}}">{{__('front.shop')}}</a>
                    </li>
                    @auth('user')
                    <li>
                        <a href="{{route('user.wishlist')}}">
                           {{__('front.wishlist')}}
                        </a>
                    </li>
                    @endauth
                    @guest('user')
                        <li>
                            <a href="{{route('user.register')}}">
                                {{__('front.register_or_login')}}
                            </a>
                        </li>
                    @endauth
                    <li>
                        <a href="{{route('user.about')}}">{{__('front.about')}}</a>

                    </li>

                </ul>
            </div>
            <div class="tab-pane" id="categories">
                <ul class="mobile-menu">
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-tshirt2"></i>Fashion
                        </a>

                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-home"></i>Home & Garden
                        </a>
                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-electronics"></i>Electronics
                        </a>
                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-furniture"></i>Furniture
                        </a>

                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-heartbeat"></i>Healthy & Beauty
                        </a>
                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-gift"></i>Gift Ideas
                        </a>
                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-gamepad"></i>Toy & Games
                        </a>
                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-ice-cream"></i>Cooking
                        </a>
                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-ios"></i>Smart Phones
                        </a>
                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-camera"></i>Cameras & Photo
                        </a>
                    </li>
                    <li>
                        <a href="shop-fullwidth-banner.html">
                            <i class="w-icon-ruby"></i>Accessories
                        </a>
                    </li>
                    <li>
                        <a href="shop-banner-sidebar.html" class="font-weight-bold text-primary text-uppercase ls-25">
                            View All Categories<i class="w-icon-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End of Mobile Menu -->

<!-- Start of Quick View -->
<div class="product product-single product-popup prod-padding">
    <div class="row gutter-lg" id="single_product_popup">
        <div class="col-md-6 mb-4 mb-md-0" style="height: 520px">
            <div class="product-gallery product-gallery-sticky mb-0">
                <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no" id="single_popup_images">

                </div>
                <div class="product-thumbs-wrap">
                    <div class="product-thumbs" id="product_thumb">

                    </div>
                    <button class="thumb-up disabled"><i class="w-icon-angle-left"></i></button>
                    <button class="thumb-down disabled"><i class="w-icon-angle-right"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-6 overflow-hidden p-relative">
            <div class="product-details rollable pl-2 pr-2">
                <h2 class="product-title"></h2>
                <div class="product-bm-wrapper" >
                    <figure class="brand">
                        <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  id="brand_product" alt="Brand" width="102" height="48" />
                    </figure>
                    <div class="product-meta">
                        <div class="product-categories">
                            {{__('front.category')}}:
                            <span class="product-category"><a href="#" >Electronics</a></span>
                        </div>
                        <div class="product-sku" id="sku">

                            {{__('front.sku')}} <span class="product-sku-span"></span>
                        </div>
                    </div>
                </div>

                <hr class="product-divider">

                <div id="product-popup-colors">

                </div>
                <div id="product-popup-sizes">

                </div>

                <div class="product-variation-price">

                </div>

                <div class="product-price"></div>


                <div class="product-short-desc">
                    <ul class="list-type-check list-style-none">
                        <li>Ultrices eros in cursus turpis massa cursus mattis.</li>
                        <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                        <li>Aliquam id diam maecenas ultricies mi eget mauris.</li>
                    </ul>
                </div>


                <div class="product-form">
                    <div class="product-qty-form">
                        <div class="input-group">
                            <input class="quantity form-control text-center" id="quantity" value="1" type="number" min="1" max="10000000">
                            <button class="quantity-plus w-icon-plus"></button>
                            <button class="quantity-minus w-icon-minus"></button>
                        </div>
                    </div>
                    @if(auth('user')->check())
                        <button class="btn btn-primary btn-cart add-to-cart" id="add-to-cart">
                            <i class="w-icon-cart"></i>
                            <span>{{__('front.add_cart')}}</span>
                        </button>
                    @else
                        <a href="{{route('cart')}}" class="btn btn-primary pl-0 pr-0 disabled" style="flex: 1; min-width: 14rem;margin-bottom: 1rem;" >
                            <i class="w-icon-cart"></i>
                            <span>{{__('front.login_to_add_to_cart')}}</span>
                        </a>
                    @endif
                </div>

                <div class="social-links-wrapper">
                    <div class="social-links">

                    </div>
                    <span class="divider d-xs-show"></span>
                </div>
            </div>
        </div>
    </div>
</div>
