<!-- Footer Start -->
<div class="container-fluid bg-primary text-dark mt-5 pt-2">
    <div class="row pt-5">
        <div class="col-lg-6 col-md-12 mb-3">
            <a href="" class="text-decoration-none">
                <h1 class="mb-2 display-6 font-weight-semi-bold">
                    <span class="text-white font-weight-bold border border-white px-3 mr-1">
                        CLICK TO PICK
                    </span>
                </h1>
            </a>
            <p class="text-white">
                We are an all-in-one portal supplying high-quality medical injectables and supplies.
                Our website give you the chance to browse, compare, and obtain the most popular products on the market hassle-free.
            </p>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <h5 class="font-weight-bold text-white mb-4"> {{ __('front.contact_us') }}</h5>
                    <p class="mb-2">
                        <a class="text-white" href="geo:{{getSetting('address')}}">
                            <i class="fa fa-map-marker-alt text-white mr-3"></i>
                            {{ getSetting('address') ?? 'location, city, country' }}
                        </a>
                    </p>
                    <p class="mb-2">
                        <a class="text-white" href="mailto:{{getSetting('email')}}" target="_blank">
                            <i class="fa fa-envelope text-white mr-3"></i>
                            {{ getSetting('email') ?? 'click-to-pick@gmail.com' }}
                        </a>
                    </p>
                    <p class="mb-2">
                        <a class="text-white" href="tel:{{getSetting('phone')}}" target="_blank">
                            <i class="fa fa-phone-alt text-white mr-3"></i>
                            {{ getSetting('phone') ?? '+1111111111'}}
                        </a>
                    </p>
                </div>
                <div class="col-lg-6 col-md-12">
                    <h5 class="font-weight-bold text-white mb-4"> {{ __('front.quick_links') }}</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-white mb-2" href="{{ route('user.index') }}">
                            <i class="fa fa-angle-right mr-2"></i>
                            {{ __('front.home') }}
                        </a>
                        <a href="{{route('user.categories')}}" class="text-white mb-2">
                            <i class="fa fa-angle-right mr-2"></i>
                            {{__('front.categories')}}
                        </a>
                        <a href="{{route('user.products.index')}}" class="text-white mb-2">
                            <i class="fa fa-angle-right mr-2"></i>
                            {{__('front.products')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center border-top border-light py-2" style="font-size: small">
        <div class="col-md-6 px-xl-0">
            <p class="text-center text-white mb-1">
                All Rights Reserved &copy; <a class="font-weight-semi-bold text-white" href="#">CLICK TO PICK</a>
            </p>
            <p  class="text-center text-white">
                Made By
                <a class="text-white text-sm font-weight-semi-bold" href="https://your1site.com/">
                    YOUR(1)SITE
                </a>
            </p>
        </div>
    </div>
</div>
<!-- Footer End -->
