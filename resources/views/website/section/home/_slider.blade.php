@if(count($sliders)>0)
        <div class="owl-carousel owl-theme owl-nav-inner owl-nav-md row cols-1 gutter-no animation-slider" data-owl-options="{
            'nav': true,
            'dots': false
        }">
            @foreach($sliders as $slider)
                     <div class="banner banner-fixed intro-slide intro-slide1 br-sm"
                     style="background-image: url({{storageImage($slider->responsive_image)}});
                     background-color: #262729;">
                         {{-- start --}}
                  <div class="banner banner-fixed intro-slide intro-slide2  br-sm" style="background-image: url({{storageImage($slider->responsive_image)}});
                            background-color: #DCE0DF;">
                        <div class="banner-content y-50">
                            <h5 class="banner-subtitle text-primary font-secondary font-weight-normal text-capitalize mb-0 lh-1 ls-25 slide-animate" data-animation-options="{'name': 'fadeInDownShorter', 'duration': '.8s'}">{{$slider->title}}
                            </h5>
                            <h3 class="banner-title text-capitalize text-white lh-.8 slide-animate" data-animation-options="{'name': 'fadeInDownShorter', 'duration': '.8s', 'delay': '.4s'}">
                                {{$slider->brief}} </h3>
                            <p class="text-white font-weight-normal ls-25 slide-animate" data-animation-options="{
                                    'name': 'fadeInDownShorter', 'duration': '.8s', 'delay': '.6s'
                                }"> <strong class="text-primary"></strong>
                            </p>
                            <a href="{{route('user.products.index')}}" class="btn btn-primary btn-rounded btn-icon-right slide-animate" data-animation-options="{'name': 'fadeInDownShorter', 'duration': '.8s', 'delay': '.8s'}">
                                @if (checkCurrentLang())

                                <i class="w-icon-long-arrow-left"></i>
                                    {{__('front.shop_now')}}
                                @else
                                    {{__('front.shop_now')}}
                                    <i class="w-icon-long-arrow-right"></i>
                                @endif
                                </a>
                        </div>
                    </div>

                     <img src="{{asset('web/images/gray.png')}}" style="position: absolute;top:0px;" class="w-100 h-100">
                </div>
            @endforeach
        <!-- End of .intro-slide1 -->
        </div>
    </div>
@endif



