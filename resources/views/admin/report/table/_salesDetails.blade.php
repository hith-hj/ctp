<!--begin::Advance Table Widget 3-->
<div class="card card-custom gutter-b shadow-lg mt-10">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">{{ __('admin.reports.sales_details') }}</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-0 pb-3">
        <!--begin::Table-->
        <div class="table-responsive">
            @include('admin.'.$item.'._gridFilter')
            <table class="table table-checkable table-head-custom table-head-bg table-borderless table-vertical-center">

                <thead>
                <tr class="text-uppercase">
                    <th style="min-width: 100px" class="pl-7">
                        <span class="text-dark-75">{{ __($item.'.order_no') }}</span>
                    </th>
                    <th class="text-center" style="min-width: 100px">{{ __($item.'.customer') }}</th>
                    <th class="text-center" style="min-width: 100px">{{ __($item.'.order_time') }}</th>
                    <th class="text-center" style="min-width: 100px">{{ __($item.'.status') }}</th>
                    <th class="text-center" style="min-width: 100px">{{ __($item.'.total') }}</th>
                    <th class="text-center" style="min-width: 100px">{{ __($item.'.items') }}</th>
                    <th class="text-center" style="min-width: 100px">{{ __($item.'.profit') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach(${plural($item)} as $key => $row)
                    <tr>
                        <td class="pl-0 py-8">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50 flex-shrink-0 mr-2">
                                    <i class="fa fa-caret-right" style="color: #F64E60;"></i>
                                </div>
                                <div>
                                    <a href="{{ route('admin.orders.show', ['order' => $row->id]) }}" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 ml-3 font-size-lg">{{ $row->code }}</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->client->name }}</span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->created_at }}</span>
                        </td>
                        <td>
                            <span class="text-center label label-lg label-inline d-flex label-light-{{ getOrderStatusClass($row->status) }}">{{ getStatusOrder($row->status) }}</span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->total_price }}</span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->items()->count() }}</span>
                        </td>
                        <td>
                            @php 
                                foreach($row->items as $product){
                                    $temp = $product->product->price - $product->product->capital_price;
                                    $product->profit = $temp * $product->qty;
                                }
                                $profitPerItem = $row->items->sum('profit');
                                
                            @endphp
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $profitPerItem }}</span>
                        </td>
                @endforeach
                </tbody>
            </table>
            {{ ${plural($item)}->appends(request()->query())->links() }}
        </div>
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 3-->
