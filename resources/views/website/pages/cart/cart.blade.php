@extends('website.app')
@section('title')
    {{ __('front.cart') }}
@endsection
@section('content')
    <!-- Start of Breadcrumb -->
    <section class="page-content mt-2" id="cart_form" style="background-color: #eee;">

        <div class="container py-2">
            <div class="row d-flex justify-content-center align-items-center ">
                <div class="col-10">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="fw-normal mb-0 text-black">Shopping Cart</h3>
                    </div>
                    @if(!is_null($cart))
                        @foreach ($cart->items as $item)
                            <div class="card rounded-3 mb-4" data-item="{{ $item->id }}"
                                id="remove-product-{{ $item->id }}">
                                <div class="card-body p-4">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                            <img onerror="this.src='{{ asset('web/images/no-image.jpg') }}';"
                                                src="{{ storageImage($item->product->featured_image) }}" alt="product"
                                                class="img-fluid rounded-3">
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                            <p class="lead fw-normal mb-2"> {{ $item->product->name }}</p>
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                            <button class="btn btn-link px-2" onclick="decrement({{ $item->id }})">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <input id="quantity_{{ $item->id }}" name="quantity[{{ $item->id }}]"
                                                type="number" value="{{ $item->qty }}" min="1" max="100000"
                                                class="quantity  form-control form-control-sm" 
                                                onchange="setItemPrice({{$item->id}})"/>

                                            <button class="btn btn-link px-2" onclick="increment({{ $item->id }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                            <h5 class="mb-0">
                                                <span id="sub_total_{{ $item->id }}">
                                                    {{ $item->price }}
                                                </span>
                                                <span id="new_sub_total_{{ $item->id }}" style="display:none">
                                                    {{ $item->price }}
                                                </span>
                                                &nbsp;{{ getAppCurrency()->symbol }}
                                            </h5>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                            <a href="#" class="text-danger remove-product-cart  update-product-cart"
                                                onclick="removeItem({{ $item->id }} , {{ $item->cart_id }} ,{{ $item->product->id }})"
                                                data-cart="{{ $item->cart_id }}" data-product="{{ $item->product->id }}"><i
                                                    class="fas fa-trash fa-lg"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="product_price_{{ $item->id }}" value="{{ $item->product->price }}">
                            @if(isset($item->ranges) && !is_null($item->ranges) )
                                <input type="hidden" id="item_ranges_{{$item->id}}" value='{{$item->ranges}} '/>
                            @endif
                        @endforeach
                        <div class="card mb-4">
                            <div class="card-body p-4 d-flex flex-row">
                                <div class="cart-action mb-6 ">
                                    <a href="{{ route('user.products.index') }}"
                                        class="btn btn-rounded btn-default btn-rounded btn-icon-left btn-shopping mr-auto">{{ __('front.continue_shopping') }}
                                        <i class="w-icon-long-arrow-right"></i>
                                    </a>
                                    <button type="button" class="btn btn-rounded btn-default btn-clear" id="clear-cart"
                                        data-cart="{{ $cart->id }}" name="clear_cart"
                                        value="Clear Cart">
                                        {{ __('front.clear_cart') }}
                                    </button>

                                    <button type="button" class="btn btn-rounded btn-update update-cart " id="update_cart"
                                        data-cart="{{ $cart->id }}" name="update_cart"
                                        value="Update Cart">{{ __('front.update_cart') }}</button>
                                    <a href="{{ route('checkout') }}"
                                        class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto">
                                        {{ __('front.checkout') }}
                                        <i class="w-icon-long-arrow-{{ app()->getLocale() == 'en' ? 'right' : 'left' }}"></i>
                                        </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card rounded-3 mb-4" >
                            <div class="card-body p-4">
                                <span><p>There is no items in your cart yet</p></span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <input type="hidden" id="home_page" data-home="{{ route('user.index') }}">

    </section>
@endsection
@section('scripts')
    <script>
        let total = 0;

        function increment(id){
            var plus = document.getElementById('quantity_' + id);
            plus.parentNode.querySelector('input[type=number]').stepUp();
            setItemPrice(id);
        }
        
        function decrement(id){
            var minus = document.getElementById('quantity_' + id);
            minus.parentNode.querySelector('input[type=number]').stepDown();
            setItemPrice(id);
        }
        function setItemPrice(id){
            let qty = Number($('#quantity_' + id).val());
            let price = Number($('#product_price_' + id).val());
            let ranges = $('#item_ranges_' + id).val();
            let subTotal = $('#sub_total_' + id);
            subTotal.html(Math.round(qty * price));
            if(typeof(ranges) != undefined)
            {
                ranges = JSON.parse(ranges);
                let newSubTotal = $('#new_sub_total_' + id);
                Object.values(ranges).forEach(range=>{
                    if(qty > range.range_start && qty <= range.range_end){
                        price = Number(range.price);
                        $('#product_price_'+id).value = price;
                        subTotal.css('text-decoration','line-through');
                        if(subTotal.siblings('br').length == 0)
                        {
                            subTotal.after(document.createElement('br'));
                        }
                        newSubTotal.show();
                        newSubTotal.html(Math.round(qty * price));
                    }else{
                        subTotal.css('text-decoration','none');
                        $(subTotal.parent().find('br')).remove();
                        newSubTotal.hide();
                    }
                });
            }
            
        }
    </script>
@endsection
