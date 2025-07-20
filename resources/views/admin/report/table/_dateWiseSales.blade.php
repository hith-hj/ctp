<!--begin::Advance Table Widget 3-->
<div class="card card-custom gutter-b shadow-lg mt-10">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">{{ __('admin.reports.date_wise_sales')}}</span>
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
                    <th style="min-width: 150px" class="pl-7">
                        <span class="text-dark-75">{{ __($item.'.date') }}</span>
                    </th>
                    <th class="text-center" style="min-width: 150px">{{ __($item.'.total_order') }}</th>
                    <th class="text-center" style="min-width: 150px">{{ __($item.'.total_amount') }}</th>
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
                                    <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 ml-3 font-size-lg">{{ $row->date }}</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->total_order }}</span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->total_amount }}</span>
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
