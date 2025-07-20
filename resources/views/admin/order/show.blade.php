<x-master title="{{__('admin.show')}} {{ __('admin.'.$item) }}">

    @section('style')
        <style>
            @media print {
                #header, #navbar, #navbar, #toolbar, #footer, .title , .btn {
                    display:none !important;
                }
            }
        </style>
    @endsection
        <x-breadcrumb :item="$item"></x-breadcrumb>
        <x-slot name="richTextBoxScript"></x-slot>
        <!--begin::Container-->
        <div class="container">
            <!-- begin::Card-->
            <div class="card card-custom overflow-hidden">
                <div class="card-body p-0">
                    <!-- begin: Invoice-->
                    <!-- begin: Invoice header-->
                    <div class="row justify-content-center text-white bgi-size-cover bgi-no-repeat py-4 px-8 py-md-17 px-md-0" style="background-image: url({{ asset('assets/media/bg/bg-6.jpg') }});">
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
                                <h1 class="display-4 font-weight-boldest mb-10">{{ __('order.order_id') }} : {{ $order->code }}<span id="status_badge" class="label label-lg label-rounded ml-4 label-{{ getOrderStatusClass($order->status) }}"></span>
                                    <span class="text text-white font-size-h5-md" id="status_label">( {{ getStatusOrder($order->status) }} )</span>
                                </h1>
                                @role('Admin')
                                <h6 class="display-5 font-weight-boldest mb-10">
                                   <a target="_blank" class="text-white" href="{{ route('admin.admins.show', ['admin' => $order->admin_id]) }}">{{ $order->vendor->name }}</a>
                                </h6>
                                @endrole
                            </div>
                            <div class="border-bottom w-100"></div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('order.customer') }}</span>
                                    <span class="opacity-70">{{ $order->client->name }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('order.post_code') }}</span>
                                    <span class="opacity-70">{{ $order->orderDetail->post_code ?? '' }}</span>
                                </div>
                            </div>
                            <div class="border-bottom w-100 opacity-20 mt-4"></div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('order.total_price') }}</span>
                                    <span class="opacity-70">{{ $order->total_price }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('order.address_details') }}</span>
                                    <span class="opacity-70">{{ $order->orderDetail->address_details }}</span>
                                </div>
                            </div>
                            <div class="border-bottom w-100 opacity-20 mt-4"></div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('order.payment_with') }}</span>
                                    <span class="opacity-70">{{ $order->payment_method_type }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('order.payment_id') }}</span>
                                    <span class="opacity-70">{{ $order->payment_method_id }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('order.payment_status') }}</span>
                                    <span class="opacity-70">{{ $order->payment_method_status }}</span>
                                </div>
                            </div>
                            <div class="border-bottom w-100 opacity-20 mt-4"></div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('order.order_date') }}</span>
                                    <span class="opacity-70">{{ $order->created_at }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('order.location') }}</span>
                                    <span class="opacity-70">{{ $order->orderDetail->location ?? '' }} |
                                        <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{$order->orderDetail->latitude}},{{ $order->orderDetail->longitude }}"><span class="text text-white">{{ getSVG('assets/media/svg/icons/Map/Marker2.svg', 'svg-icon-3x light') }}</span></a>
                                    </span>

                                </div>
                            </div>
                            <div class="border-bottom w-100 opacity-20 mt-4"></div>
                        </div>
                    </div>
                    <!-- end: Invoice header-->
                    <!-- begin: Invoice body-->
                    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="pl-0 font-weight-bold text-muted text-uppercase">{{__('order.item')}}</th>
                                        <th class="pl-0 font-weight-bold text-muted text-uppercase">{{__('order.sku')}}</th>
                                        <th class="text-right font-weight-bold text-muted text-uppercase">{{__('order.price')}}</th>
                                        <th class="text-right font-weight-bold text-muted text-uppercase">{{__('order.quantity')}}</th>
                                        <th class="text-right font-weight-bold text-muted text-uppercase">{{__('order.price_before_discount')}}</th>
                                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">{{__('order.total_price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->cart->items as $item)
                                            <tr class="font-weight-boldest">
                                                <td class="pl-0 pt-7">{{  $item->product->name }}</td>
                                                <td class="pl-0 pt-7">{{  $item->product->sku }}</td>
                                                <td class="text-right pt-7">{{ $item->product->price }}</td>
                                                <td class="text-right pt-7">{{ $item->qty }}</td>
                                                <td class="text-right pt-7">{{ $item->price_before_discount }} £</td>
                                                <td class="text-danger pr-0 pt-7 text-right">{{ $item->price }} £</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice body-->
                    <!-- begin: Invoice footer-->
                    <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="font-weight-bold text-muted text-uppercase">{{__('order.price_before_discount')}}</th>
                                        <th class="font-weight-bold text-muted text-uppercase">{{__('order.total_price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="font-weight-bolder">
                                        <td>{{ $order->total_price_before_discount }} £</td>
                                        <td class="text-danger font-size-h3 font-weight-boldest">{{ $order->total_price }} £</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice footer-->
                    <!-- begin: Invoice action-->
                    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between">
                                <div class="form-group row">
                                    <label class="col-form-label text-right mr-3" for="statusOrder">
                                        {{ __('order.status_order') }}
                                    </label>
                                    <div>
                                        <select class="form-control form-control-lg form-control-solid"
                                                id="statusOrder" name="statusOrder" data-id="{{ $order->id }}"
                                                style="width: 100% !important; opacity: 1 !important;">
                                                @foreach(getStatusOrderVariables() as $option)
                                                    <option {{ $option->value == $order->status ? 'selected' : '' }} value="{{ $option->value }}">{{ $option->name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">
                                    {{ __('order.print_order') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- end: Invoice action-->
                    <!-- end: Invoice-->
                </div>
            </div>
            <!-- end::Card-->
        </div>
        <!--end::Container-->
        @section('scripts')
            <script src="{{ asset('/js/order.js') }}"></script>
        @endsection
</x-master>
