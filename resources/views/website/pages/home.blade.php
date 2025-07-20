@extends('website.app')
@section('title', __('front.home'))
@section('content')
    <!-- Featured Start -->
    <div class="container-fluid py-4">
        <div class="text-center py-4">
            <h2 class="section-title px-5"><span class="px-2">{{ __('front.features') }}</span></h2>
        </div>
        <div class="row p-3">
            <div class="col-lg-4 col-md-4 col-sm-12 pb-1 border">
                <div class="d-flex align-items-center mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">{{ __('front.Quality_Product') }}</h5>
                </div>
                <p class="text-muted">
                    We handpick our products to meet the highest standards. you can count on us on every product we offer.
                </p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 pb-1 border">
                <div class="d-flex align-items-center mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">{{ __('front.Shipping') }}</h5>
                </div>
                <p class="text-muted">
                    We don’t want to make you wait, Our team is always on the move, ensuring your orders are packed and dispatched as soon as posible.
                </p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 pb-1 border">
                <div class="d-flex align-items-center mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0"> {{ __('front.Support') }} </h5>
                </div>
                <p class="text-muted">
                    Our support team is available 24/7 via email, or phone to guide you through anything. You're never alone when you shop with us.
                </p>
            </div>
        </div>
    </div>
    <!-- Featured End -->
    <hr>

    <!-- Categories Start -->
    @if (count($subCategories) > 0)
        <div class="container-fluid py-4">
            <div class="text-center py-4">
                <h2 class="section-title px-5"><span class="px-2">{{ __('front.categories') }}</span></h2>
            </div>
            <div class="row pb-3">
                @foreach ($subCategories as $sub)
                    @if($sub->product_count > 0)
                        <div class="col-lg-3 col-md-6 pb-1">
                            <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                                <a href="{{ route('user.products.index', ['category' => $sub->id]) }}"
                                    class="cat-imgx position-relative overflow-hidden mb-2">
                                    {{-- @if(!is_null($sub->image))
                                       <img class="img-fluid w-100" src="{{ asset($sub->image) }}"
                                            style="height: 220px" onerror="this.src='{{storageImage($sub->image)}}'">
                                    @endif --}}
                                    <h5 class="font-weight-semi-bold m-0">{{ $sub->name }}</h5>
                                </a>
                                <span class="text-primary">{{ $sub->product_count . ' ' . __('front.products') }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <hr>
    @endif
    <!-- Categories End -->

    <!-- Offer Start -->
    @if( isset($offers) && count($offers)>1 )
    <div class="container-fluid offer py-4">
        <div class="text-center my-4 py-4">
            <h2 class="section-title px-5">
                <span class="px-2">
                    {{ __('front.offers') }}
                </span>
            </h2>
        </div>
        <div class="row">
            @forelse($offers as $offer)
                @if(!empty($offer) && $loop->index < 4)
                <div class="col-md-6 pb-4">
                    <div class="position-relative bg-secondary text-white mb-2
                    {{$loop->index%2==0 ? 'text-md-right' : 'text-md-left'}}">
                        @if(is_null($offer->image) )
                            <img src="{{ asset('web/img/offer-1.png') }}" alt="">
                        @else
                            <img src="{{ storageImage($offer->image) }}" alt="">
                        @endif
                        <div class="position-relative p-5" style="z-index: 1;">
                            @if( !is_null($offer->title) )
                                <h1 class="mb-4 font-weight-semi-bold">
                                    {{ $offer->title }}
                                </h1>
                            @endif
                            @if( !is_null($offer->description) )
                                <h5 class="text-uppercase text-primary mb-3">
                                    {{ $offer->description }}
                                </h5>
                            @endif
                            {{-- <a class="btn btn-outline-primary text-white py-md-2 px-md-3"
                                href="{{is_null($offer->product_id) ? route('user.products.index') : route('user.products.show', $offer->product_id) }}">
                                {{ __('front.shop_now') }}
                            </a> --}}
                        </div>
                    </div>
                </div>
                @else
                    <small class="mx-auto">This offer is ended</small>
                @endif
            @empty
                <small> No offers yet</small>
            @endforelse
        </div>
    </div>
    @endif
    <!-- Offer End -->
    <hr>
    <!-- Subscribe Start -->
    {{-- <div class="container-fluid py-4">
        <div class="py-3 px-xl-5">
            <div class="bg-primary row justify-content-md-center">
                <div class="col-md-6 col-12 py-3">
                    <div class="text-center mb-4">
                        <h2 class="section-title px-5 ">
                            <span class="px-2 text-white bg-primary">{{ __('front.stay_updated') }}</span>
                        </h2>
                    </div>
                    <p class="text-white text-center">
                        Whether you have questions about your order, need support with a product, or just want to say hello—our team is always ready to assist.
                    </p>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control border-white p-4" placeholder="{{ __('front.email') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary text-white px-4">{{ __('front.subscribe') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr> --}}
    <!-- Subscribe End -->
    <!-- trendy Start -->
    <div class="container-fluid py-4 ">
        <div class="text-center my-4 py-4">
            <h2 class="section-title px-5">
                <span class="px-2">
                    {{ __('front.trandy_products') }}
                </span>
            </h2>
        </div>
        <div class="row pb-3">
            @foreach ($products as $product)
                @include('website.section.product._product',['product'=>$product,'addToCart'=>true])
            @endforeach
        </div>
    </div>
    <!-- trendy End -->
    <hr>
    <!-- just arrived Start -->
    <div class="container-fluid py-4">
        <div class="text-center py-4">
            <h2 class="section-title px-5">
                <span class="px-2">
                    {{ __('front.just_arrived') }}
                </span>
            </h2>
        </div>
        <div class="row pb-3">
            @foreach ($products as $product)
                @include('website.section.product._product',['product'=>$product,'addToCart'=>true])
            @endforeach
        </div>
    </div>
    <!-- just arrived End -->
    <hr>
    <!-- products Start -->
    @if ( count($products) > 0)
        <div class="container-fluid py-2">
            <div class="text-center mb-4">
                <h2 class="section-title px-5">
                    <span class="px-2">
                        {{ __('front.products') }}
                    </span>
                </h2>
            </div>
            <div class="row" style="direction: ltr !important">
                <div class="col">
                    <div class="owl-carousel related-carousel">
                        @forelse($products as $product)
                            @if($loop->index < 5)
                                <div class="card product-item border-0">
                                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                        <a href="{{route('user.products.show',$product->id)}}">
                                            <img class="img-fluid w-100"
                                            src="{{storageImage($product->featured_image)}}" alt="">
                                        </a>
                                    </div>
                                    <div class="card-body border-left border-right text-center p-0 py-1">
                                        <h5 class="text-truncate mb-1">{{str()->limit($product->name,25,'...')}}</h5>
                                        <div class="d-flex justify-content-center">
                                            <span>{{__('front.Price')}} : {{$product->price}}</span>
                                            <span class="text-muted ml-2">
                                                <del>{{$product->price_before_discount}}</del>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Vendor End -->
@endsection



