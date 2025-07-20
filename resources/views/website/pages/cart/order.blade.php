@extends('website.app')
@section('title')
    {{__('front.order')}}
@endsection
@section('content')
    <div class="container ">
        @if($order)
            <div class="order-details-wrapper mb-5">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <h4 class="title text-uppercase ls-25 mb-1">
                            {{__('front.order_details')}}
                        </h4>
                        <ul class="order-view list-style-none mb-1">
                            <li>
                                <label>{{__('front.order_code')}}</label>
                                <strong>{{$order->code}}</strong>
                            </li>
                            <li>
                                <label>{{__('front.status')}}</label>
                                <strong>{{$order->statusName}}</strong>
                            </li>
                            <li>
                                <label>{{__('front.date')}}</label>
                                <strong>{{$order->date}}</strong>
                            </li>
                            <li>
                                <label>{{__('front.total')}}</label>
                                <strong>{{$order->total_price ." " .getAppCurrency()->symbol }}</strong>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <h4 class="title text-uppercase ls-25 mb-1">
                            {{__('front.shipping_details')}}
                        </h4>
                        <ul>
                            <li>
                                <label>
                                    {{__('front.address')}}
                                </label>
                                <strong>
                                    {{$order->orderDetail->shippingDetails->address}}
                                </strong>
                            </li>
                            <li>
                                <label>
                                    {{__('front.phone')}}
                                </label>
                                <strong>
                                    {{$order->orderDetail->shippingDetails->phone_number}}
                                </strong>
                            </li>
                            <li>
                                <label>
                                    {{__('front.email')}}
                                </label>
                                <strong>
                                    {{$order->orderDetail->shippingDetails->email}}
                                </strong>
                            </li>
                        </ul>
                    </div>
                    @if($order->isPayable)
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">
                                    <a href="{{route('payment.item',['id'=>$order->id])}}"
                                        class="btn btn-outline-primary btn-sm rounded">
                                        <i class="fa fa-credit-card"></i>
                                        {{__('front.pay_with_cards')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <h5 class="text-black my-2">{{__('front.products')}}</h5>
                <table class="order-subtable">
                    <thead>
                        <tr>
                            <th class="px-3">{{__('front.product')}}</th>
                            <th class="px-3">{{__('front.quantity')}}</th>
                            <th class="px-3">{{__('front.price')}}</th>
                            <th class="px-3">{{__('front.total')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($order->cart)
                            @foreach($order->cart->items as $item)
                                <tr>
                                    <td class="px-3">
                                        <a href="{{route('user.products.show', $item->product)}}">
                                            {{$item->product->name}}
                                        </a>
                                    </td>
                                    <td class="px-3">{{$item->qty}}</td>
                                    <td class="px-3">{{$item->product->price}}</td>
                                    <td class="px-3">{{$item->product->price * $item->qty}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot class="py-5">
                        <tr>
                            <th class="px-3">{{__('front.coupon_amount')}}:</th>
                            <td>
                                {{$order->discount_on_coupon ." " ."%" }}
                            </td>
                        </tr>
                        <tr>
                            <th class="px-3">{{__('front.subtotal')}}:</th>
                            <td>
                                {{$order->total_price ." " .getAppCurrency()->symbol }}
                            </td>
                        </tr>
                        <tr>
                            <th class="px-3">{{__('front.shipping_fess')}}:</th>
                            <td>
                                {{$order->cart->calculateShippingPrice() . " ". getAppCurrency()->symbol}}
                            </td>
                        </tr>
                        <tr>
                            <th class="px-3">{{__('front.total')}}:</th>
                            <td>
                                {{getTotalPrice($order->total_price , $order->cart->calculateShippingPrice()) .' ' .getAppCurrency()->symbol}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
        @if(count($user->orders) > 1 )
            <div class="sub-orders mb-5">
                <h4 class="title font-weight-bold ls-25">{{__('front.orders')}}</h4>
                <table class="order-subtable">
                    <thead>
                        <tr>
                            <th class="pr-5">No</th>
                            <th class="px-4 order">{{__('front.order')}}</th>
                            <th class="px-4 date">{{__('front.date')}}</th>
                            <th class="px-4 status">{{__('front.status')}}</th>
                            <th class="px-4 total">{{__('front.total')}}</th>
                            <th class="px-4 total">{{__('front.is_payed')}}</th>
                            <th class="px-4 action">{{__('front.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->orders as $item)
                            @if($item->id != $order->id)
                                <tr>
                                    <td class="pr-5">{{$loop->index + 1}}</td>
                                    <td class="px-4 order">
                                        {{$item->code}}
                                    </td>
                                    <td class="px-4 date">
                                        {{$item->date}}
                                    </td>
                                    <td class="px-4 status">
                                        {{$item->statusName}}
                                    </td>
                                    <td class="px-4 total">
                                        {{$item->total_price ." " .getAppCurrency()->symbol }}
                                    </td>
                                    <td class="px-4 total">
                                        {{ $item->isPayable ? 'no' : 'yes' }}
                                    </td>
                                    <td class="px-4 action">
                                        <a href="{{route('user.order.show',$item->code)}}"
                                            class="btn btn-rounded">
                                            {{__('front.view')}}
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <h5 class="text-muted mt-5">No Orders</h5>
        @endif
        <a href="{{route('user.index')}}" class="btn btn-outline-primary rounded">
            <i class="fa fa-arrow-left"></i>
            {{__('front.back_to_list')}}
        </a>
    </div>
@endsection
