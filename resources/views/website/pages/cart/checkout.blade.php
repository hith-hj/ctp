@extends('website.app')
@section('title')
    {{__('front.cart')}}
@endsection
@section('content')
    <!-- Start of Main -->
    
    <!-- Start of PageContent -->
    <div class="page-content">
        <div class="container">
            @if(count($cart->items)>0)
                <div class="d-flexx">
                    <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                        {{__('front.shipping_details')}}
                    </h3>
                    <div class="form-group checkbox-toggle pb-2">
                        <form method="post" action="{{route('createShippingDetailsFromUser')}}">
                            @csrf
                            <button type="submit" class="btn btn-outline-info btn-sm rounded">
                                {{__('front.createShippingDetailsFromUser')}}
                            </button>
                        </form>
                    </div>
                </div>
                <form class="form checkout-form" action="{{route('proceedToCheckout')}}" method="post"
                      id="form_shipping">
                    @csrf
                    <div class="row mb-9">
                        <div class="col-lg-6 pr-lg-4 mb-4">
                            @if(auth('user')->user()->shippingDetails()->exists() )
                                <div class="form-group checkbox-toggle pb-2" onclick="slideContent()">
                                    <input type="checkbox" class="custom-checkbox"
                                           id="shipping-toggle" name="checkeds" value="1">
                                    <label for="shipping-toggle" onclick="slideContent()">
                                        {{__('front.shipping_other_address')}}
                                    </label>
                                </div>
                            @endif
                            <div class="checkbox-content" id="form" style="{{auth()->user()->shippingDetails()->exists() ? 'display:none;':''}}">
                                <div class="row gutter-sm">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{__('front.first_name')}} <span style="color: red">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="first_name" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{__('front.last_name')}} <span style="color: red">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="last_name"required>

                                        </div>
                                    </div>
                                </div>
                                <div class="row gutter-sm">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('front.post_code')}} <span style="color: red">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="post_code"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('front.phone')}} <span style="color: red">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="phone_number"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-7">
                                    <label>{{__('front.email')}} <span style="color: red">*</span></label>
                                    <input type="email" class="form-control form-control-sm" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label>{{__('front.addresses')}} <span style="color: red">*</span></label>
                                    <input type="text" placeholder="{{__('front.address_info')}}"
                                           class="form-control form-control-sm mb-2" name="address">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4 sticky-sidebar-wrapper">
                            <div class="order-summary-wrapper sticky-sidebar">
                                <h3 class="title text-uppercase ls-10">{{__('front.order')}}</h3>
                                <div class="order-summary">
                                    <table class="order-table">
                                        <thead>
                                            <tr>
                                                <th colspan="2">
                                                    <b>{{__('front.product')}}</b>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cart->items as $item)
                                                <tr class="bb-no">
                                                    <a href="{{route('user.products.show',$item->product->id)}}">
                                                        <td class="product-name">
                                                            {{$item->product->name}}
                                                            <i class="fas fa-times "></i>
                                                            <span class="product-quantity">
                                                                {{$item->qty}}
                                                            </span>
                                                        </td>
                                                    </a>
                                                    <input type="hidden" id="cart_items" name="items[]"
                                                           value="{{$item->product->id}}">
                                                    <td class="product-total px-2">{{$item->price.' '.getAppCurrency()->symbol}}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="cart-subtotal bb-no">
                                                <td>
                                                    <b>{{__('front.subtotal')}}</b>
                                                </td>
                                                <td class="px-2">
                                                    <b>{{$cart->calculateSutotalPrice() . " ". getAppCurrency()->symbol}}</b>
                                                </td>
                                            </tr>
                                            <tr class="cart-subtotal bb-no">
                                                <td>
                                                    <b>{{__('front.shipping_fess')}}</b>
                                                </td>
                                                <td class="px-2">
                                                    <b>{{$cart->calculateShippingPrice() . " ". getAppCurrency()->symbol}}</b>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="order-total">
                                                <th>
                                                    <b>{{__('front.total')}}</b>
                                                </th>
                                                <td class="px-2">
                                                    <b>{{getTotalPrice($cart->calculateSutotalPrice() , $cart->calculateShippingPrice()) .' ' .getAppCurrency()->symbol}}</b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="payment-methods">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" value="true"
                                           name="cards_payment" id="cards_payment">
                                          <label class="form-check-label" for="cards_payment">
                                            {{__('front.pay_with_cards')}}
                                          </label>
                                        </div>
                                        <div class="form-group place-order pt-6">
                                            <button type="submit"
                                                    class="btn btn-dark btn-block btn-rounded">
                                                {{__('front.get_order')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="w-50 text-center" style="margin: 108px auto; ">
                    <img src="{{asset('web/images/icons/Add to Cart-bro.png')}}"
                         onerror="this.src='{{asset('web/images/no-image.jpg')}}';">
                    <p style="margin-top: 21px;font-weight: bold;" class="text-dark">{{__('front.cart_items')}}</p>
                    <a href="{{route('user.products.index')}}"
                       class="btn btn-primary btn-rounded btn-icon-right slide-animate"
                       data-animation-options="{'name': 'fadeInUpShorter', 'duration': '1s'}">
                        @if (checkCurrentLang())
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
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('custom/js/jquery.validate.min.js') }}"></script>
    <script>
        function slideContent() {
            $('#form').toggle();
            $('#name').slideToggle();
            $('#city').slideToggle();
            $('#address').slideToggle();
            $('#phone_number').slideToggle();
            $('#email_user').slideToggle();
        }

        jQuery(document).ready(function () {
            let $registerForm = $('#form_shipping');
            $.validator.addMethod("notEqualToValue", function (value, element, param) {
                return value != param;
            }, "Please select a valid value");

            if ($registerForm.length) {
                $registerForm.validate({
                        rules: {
                            firstname: {
                                required: true
                            },
                            lastname: {
                                required: true
                            },
                            email2: {
                                required: true
                            },
                            mobile: {
                                required: true
                            },
                            postcode: {
                                required: true,
                            },
                            billing_address: {
                                required: true,
                            },
                            city_id: {
                                required: true,
                                notEqualToValue: 0
                            },
                            cityid: {
                                required: true,
                                notEqualToValue: 0
                            },
                        },
                    }
                );
            }
        });
    </script>
@endsection
