@if(count(getBannerCategories()) > 0)
    @foreach(getBannerCategories() as $category)
            <h2 class="title text-left appear-animate mb-5">{{$category->name}}</h2>
            <div class="row banner-product-wrapper appear-animate mb-10">
                <div class="col-lg-9 mb-4 mb-lg-0">
                    @foreach($banners as $banner)
                        @if($banner->applies_to == 'AppliesToCategories' and $banner->applicable->id == $category->id)
                            <div class="banner banner-fixed br-sm text-white appear-animate">
                                <figure>
                                    <img src="{{asset('web/images/gray.png')}}" style="position: absolute"
                                         class="w-100 h-100 ">
                                    <img src="{{storageImage($banner->image)}}" alt="banner"
                                         width="925"
                                         height="298" style="height: 260px;  background-color: #56575C;"/>

                                </figure>
                                <div class="banner-content y-50">
                                    <h5 class="banner-subtitle text-primary font-weight-bold text-uppercase ls-25">{{$banner->title}}</h5>
                                    <h3 class="banner-title font-weight-bold text-uppercase text-white ls-25">
                                        {{$banner->brief}}
                                    </h3>
                                    <a href="{{route('user.product-main-category',$banner->applicable->slug)}}"
                                       class="btn btn-white btn-outline btn-rounded">{{__('front.shop_now')}}</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="owl-carousel owl-theme row cols-md-4 cols-sm-3 cols-2 mt-4" data-owl-options="{
                            'nav': false,
                            'dots': false,
                            'margin': 20,
                            'responsive': {
                                '0': {
                                    'items': 2
                                },
                                '576': {
                                    'items': 3
                                },
                                '768': {
                                    'items': 4
                                }
                            }
                        }">
                        @foreach(getLastProducts($category) as $product)
                            <div class="product-wrap">
                                @include('website.section._single-product',['product'=>$product])
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget widget-products widget-products-bordered h-100">
                        <div class="widget-body br-sm pb-2 h-100">
                            <h4 class="title-sm title-underline font-weight-bolder ls-normal mb-2">{{__('front.Recommend')}}</h4>
                            <div class="owl-carousel owl-theme owl-nav-top row cols-lg-1 cols-md-3"
                                 data-owl-options="{
                                    @if(checkCurrentLang())
                                    'rtl': true,
                                    @endif
                                    'nav': true,
                                    'dots': false,
                                    'margin': 20,
                                    'responsive': {
                                        '0': {
                                            'items': 1
                                        },
                                        '576': {
                                            'items': 2
                                        },
                                        '992': {
                                            'items': 1
                                        }
                                    }
                                }">
                                <div class="product-widget-wrap">
                                    @foreach(getRandomProducts($category) as $product)
                                        @if($loop->index < 4)
                                            <div class="product product-widget bb-no">
                                                <figure class="product-media">
                                                    <a href="{{route('user.products.show',$product)}}">
                                                        <img
                                                            onerror="this.src='{{asset('web/images/no-image.jpg')}}';"
                                                            src="{{storageImage($product->featured_image)}}"
                                                            alt="Product" style="height: 100px !important"/>
                                                    </a>
                                                </figure>
                                                <div class="product-details">
                                                    <h4 class="product-name">{{$product->name}}</h4>

                                                    <div class="product-price">
                                                        <ins class="new-price">{{$product->price." ". getAppCurrency()->symbol}} </ins>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="product-widget-wrap">
                                    @foreach(getRandomProducts($category) as $product)
                                        @if($loop->index > 3)
                                            <div class="product product-widget bb-no">
                                                <figure class="product-media">
                                                    <a href="{{route('user.products.show',$product)}}">
                                                        <img
                                                            onerror="this.src='{{asset('web/images/no-image.jpg')}}';"
                                                            src="{{storageImage($product->featured_image)}}"
                                                            alt="Product" style="height: 100px !important"/>
                                                    </a>
                                                </figure>
                                                <div class="product-details">
                                                    <h4 class="product-name">
                                                        <a href="{{route('user.products.show',$product)}}">{{$product->name}}</a>
                                                    </h4>
                                                    <div class="product-price">
                                                        <ins class="new-price">{{$product->price}}</ins>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         {{-- @endif --}}
    @endforeach
@endif
