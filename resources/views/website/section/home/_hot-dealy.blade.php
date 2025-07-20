<div class="col-lg-9 mb-4">
    <div class="single-product h-100 br-sm">
        <h4 class="title-sm title-underline font-weight-bolder ls-normal">{{__("front.Deals_Hot_Of_The_Day")}}</h4>
        <div class="owl-carousel owl-theme owl-nav-top owl-nav-lg row cols-1 gutter-no" data-owl-options="{
                                'nav': true,
                                'dots': false,
                                'margin': 20,
                                'items': 1
                            }">
            @foreach($products as $product)
                <div class="product product-single row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical mb-0">
                            <div
                                class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">

                                @foreach($product->images as $item)
                                    <figure class="product-image">
                                        <img
                                            onerror="this.src='{{asset('web/images/no-image.jpg')}}';"
                                            src="{{storageImage($item)}}"
                                            alt="Product Thumb" style="min-height: 110px">
                                    </figure>
                                @endforeach

                            </div>
                            <div class="product-thumbs-wrap">
                                <div class="product-thumbs">
                                    @foreach($product->images as $item)
                                        @if ($loop->index == 0)
                                            <div class="product-thumb active" style="height: 60px">
                                                <img src="{{storageImage($item)}}" class="h-100" alt="Product thumb"
                                                     width="60" />
                                            </div>
                                        @else
                                            <div class="product-thumb" style="height: 60px">
                                                <img src="{{storageImage($item)}}" class="h-100" alt="Product thumb"
                                                     width="60" />
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-details scrollable">
                            <h2 class="product-title mb-1"><a href="{{route('user.products.show',$product)}}">{{$product->name}}</a></h2>
                            <hr class="product-divider">

                            <div class="product-price">
                                <ins
                                    class="new-price ls-50">{{$product->price . ' ' .getAppCurrency()->symbol}}</ins>
                            </div>
                            <div class="product-form pt-4">
                                <div class="product-qty-form mb-2 mr-2">
                                    <div class="input-group">
                                        <input class="quantity form-control text-center" value="1" type="number" min="1"
                                               max="10000000">
                                        <button class="quantity-plus w-icon-plus"></button>
                                        <button class="quantity-minus w-icon-minus"></button>
                                    </div>
                                </div>
                                <button
                                    class="btn btn-primary {{auth('user')->check()?'btn-cart':''}} add-to-cart"
                                    data-product="{{$product->id}}">
                                    <i class="w-icon-cart"></i>
                                    <span>{{__('front.add_cart')}}</span>
                                </button>
                            </div>

                            <div class="social-links-wrapper mt-1">
                                <div class="social-links">
                                    @if($product->owner->facebook or $product->owner->twitter or $product->owner->whatsapp or $product->owner->linkedin)
                                        <div class="social-icons social-no-color border-thin">
                                            @if($product->owner->facebook)
                                                <a href="{{$product->owner->facebook}}"
                                                   class="social-icon social-facebook w-icon-facebook"></a>
                                            @endif
                                            @if($product->owner->twitter)
                                                <a href="{{$product->owner->twitter}}"
                                                   class="social-icon social-twitter w-icon-twitter"></a>
                                            @endif

                                            @if($product->owner->whatsapp)
                                                <a href="{{$product->owner->whatsapp}}"
                                                   class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                            @endif
                                            @if($product->owner->linkedin)
                                                <a href="{{$product->owner->linkedin}}"
                                                   class="social-icon social-youtube fab fa-linkedin-in"></a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <span class="divider d-xs-show"></span>
                                <div class="product-link-wrapper d-flex">
                                    <a href="#"
                                       id=" add-to-wishlist"
                                       data-product="{{$product->id}}"
                                       class="btn-product-icon {{auth('user')->check()?'btn-wishlist ':''}}  add-to-wishlist
                                       {{auth('user')->check()?$product->isLikedBy(auth('user')->user()) ? 'w-icon-heart-full' : 'w-icon-heart':'w-icon-heart'}}">
                                        <span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="col-lg-3 mb-4">
    @if($listProduct)
        <aside class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
            <div class="sidebar-overlay"></div>
            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
            <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
            <div class="sidebar-content scrollable">
                <div class="sticky-sidebar">
                    <div class="widget widget-products">
                        <div class="title-link-wrapper mb-2">
                            <h4 class="title title-link font-weight-bold">{{__('front.more_products')}}</h4>
                        </div>

                        <div  class="owl-carousel owl-theme owl-nav-top" data-owl-options="{
                                            @if(checkCurrentLang())
                                            'rtl': true,
                                            @endif
                                            'nav': true,
                                            'dots': false,
                                            'items': 1,
                                            'margin': 20
                                        }"
                                        >
                            <div class="widget-col">
                                @foreach($listProduct as $product)
                                    @if($loop->index <4)
                                        <div class="product product-widget">
                                            <figure class="product-media">
                                                <a href="{{route('user.products.show' , $product)}}">
                                                    <img
                                                        onerror="this.src='{{asset('web/images/no-image.jpg')}}';"
                                                        src="{{storageImage($product->featured_image)}}"
                                                        alt="Product"
                                                        style="height: 100px !important ;"/>
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="{{route('user.products.show' , $product)}}">{{$product->name}}</a>
                                                </h4>
                                                <div
                                                    class="product-price">{{$product->price . ' ' . getAppCurrency()->symbol}}</div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            <div class="widget-col">
                                @foreach($listProduct as $product)

                                    @if($loop->index >3)
                                        <div class="product product-widget">
                                            <figure class="product-media">
                                                <a href="{{route('user.products.show' , $product)}}">
                                                    <img
                                                        onerror="this.src='{{asset('web/images/no-image.jpg')}}';"
                                                        src="{{storageImage($product->featured_image)}}"
                                                        alt="Product"
                                                        style="height: 100px !important ;"/>
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="{{route('user.products.show' , $product)}}">{{$product->name}}</a>
                                                </h4>
                                                <div
                                                    class="product-price">{{$product->price . ' ' . getAppCurrency()->symbol}}</div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    @endif
</div>
