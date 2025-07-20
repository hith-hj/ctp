@extends('website.app')
@section('title')
    {{$product->name}}
@endsection
@section('content')
    <div class="container-fluid py-2">
        <div class="row px-xl-5">
            <div class="col-lg-4 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border px-2 text-center">
                        @php
                            $product->images = [...$product->images,$product->featured_image];
                        @endphp
                        @forelse($product->images as $key=> $item)
                            <div class="carousel-item {{$key == 0 ? 'active':""}} p-2">
                                <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  src="{{storageImage($item)}}"
                                     data-zoom-image="{{storageImage($item)}}"
                                     alt="Electronics Black Wrist Watch" width="90%" height="300px">
                            </div>
                        @empty
                            <div class="carousel-item active p-2">
                                <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  
                                    src="{{storageImage($product->featured_image)}}"
                                    alt="Electronics Black Wrist Watch" width="90%" height="300px">
                            </div>
                        @endforelse
                    </div>
                    @if(isset($product->images) && count($product->images)>1)
                        <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-8 pb-5">
                <h3 class="font-weight-semi-bold">
                    {{$product->name}}
                </h3>
                <p class="mb-4">   
                    {!! $product->description !!}
                </p>
                <div class="d-flex">
                    <h4>
                        {{ $product->price }}
                    </h4>
                    <h4 class="text-muted mx-2">
                        <del>{{ $product->price_before_discount }}</del>
                    </h4>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus" style="height: 37px;padding-top: 7px;">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center" id="quantity" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus" style="height: 37px;padding-top: 7px;">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary px-3 {{auth('user')->check()?'btn-cart' :''}} add-to-cart" data-product="{{$product->id}}" >
                        <i class="fa fa-shopping-cart mr-1"></i> {{__('front.add_cart')}}
                    </button>
                </div>
                <div class="d-flex pt-2">
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="{{getSetting('facebook') ?? '#'}}">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="{{getSetting('x')?? '#'}}">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="{{getSetting('tiktok')?? '#'}}">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a class="text-dark px-2" href="{{getSetting('instagram')?? '#'}}">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-dark px-2" href="{{getSetting('whatsapp')?? '#'}}">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a class="text-dark px-2" href="{{getSetting('telegram')?? '#'}}">
                            <i class="fab fa-telegram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

