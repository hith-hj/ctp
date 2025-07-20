@extends('website.app')
@section('title')
    {{__('front.wishlist')}}
@endsection
@section('content')
    <main class="main wishlist-page">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">{{__('front.wishlist')}}</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav mb-10">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{route('user.index')}}">{{__('front.home')}}</a></li>
                    <li>{{__('front.wishlist')}}</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content">
            <div class="container">
                @if(count($favorites)>0)
                    <h3 class="wishlist-title">{{__('front.my_wishlist')}}</h3>
                    @if(count($favorites)>0)
                        <table class="shop-table wishlist-table">
                            <thead>
                            <tr>
                                <th class="product-name"><span>{{__('front.product')}}</span></th>
                                <th></th>
                                <th class="product-price"><span>{{__('front.price')}}</span></th>
                                <th class="product-stock-status"><span>{{__("front.SKU")}}</span></th>
                                <th class="wishlist-action">{{__('front.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($favorites as $item)
                                <tr id="data-item-wishlist-{{$item->id}}" >
                                    <td class="product-thumbnail">
                                        <div class="p-relative">
                                            <a href="{{route('user.products.show',$item)}}">
                                                <figure>
                                                    <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  src="{{storageImage($item->featured_image)}}" alt="product"
                                                         width="300"
                                                         style="height: 100px">
                                                </figure>
                                            </a>
                                            <button type="submit" data-product="{{$item->id}}"
                                                    onclick="addToWishlist({{$item->id}} ,event)"
                                                    class="btn btn-close"><i
                                                    class="fas fa-times"></i></button>
                                        </div>
                                    </td>
                                    <td class="product-name">
                                        <a href="{{route('user.products.show',$item)}}">
                                            {{$item->name}}
                                        </a>
                                    </td>
                                    <td class="product-price">
                                        <ins class="new-price">{{$item->price." ". getAppCurrency()->symbol}}</ins>
                                    </td>
                                    <td class="product-stock-status">
                                        <span
                                            class="wishlist-in-stock">{{$item->sku}}</span>
                                    </td>
                                    <td class="wishlist-action">
                                        <div class="d-lg-flex">
                                            <a href="#"
                                               class="btn btn-quickview btn-outline btn-default btn-rounded btn-sm mb-2 mb-lg-0"
                                               data-product="{{$item->id}}">{{__('front.quick_view')}}</a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
            </div>
            @else
                <div class="w-50 text-center" style="margin: 108px auto; ">
                    <img class="w-100" width="100%" onerror="this.src='{{asset('web/images/no-image.jpg')}}';"
                         src="{{asset('web/images/icons/Add_to_Cart-rafiki.jpg')}}">
                    <p style="margin-top: 21px;font-weight: bold;" class="text-dark">{{__('front.no_product')}}</p>
                    <a href="{{route('user.products.index')}}"
                       class="btn btn-primary btn-rounded btn-icon-right slide-animate"
                       data-animation-options="{
                                    'name': 'fadeInUpShorter', 'duration': '1s'
                                }">

                        @if (session()->get('lang') == 'ar'  or app()->getLocale() == 'ar')

                            <i class="w-icon-long-arrow-left"></i>
                            {{__('front.shop_now')}}
                        @else
                            {{__('front.shop_now')}}
                            <i class="w-icon-long-arrow-right"></i>
                        @endif
                    </a>
                </div>

            @endif
        </div>
        <input type="hidden" id="product_url" value="{{route('user.get-product-details')}}">
        <input type="hidden" id="add_to_cart_url" value="{{route('AddToCart')}}">
        <input type="hidden" id="add_to_wishlist" value="{{route('user.wishlist')}}">
        <input type="hidden" id="checkout_id" value="{{route('checkout')}}">
        <input type="hidden" id="cart_id" value="{{route('cart')}}">
        <input type="hidden" id="main_currancy" value="{{getAppCurrency()->symbol}}">
        <!-- End of PageContent -->
    </main>
@endsection
