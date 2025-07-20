<x-master title="Dashboard">
    @section('style')
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    @endsection
    <div class="container">
        <div class="row col-xs-12">
            <div class="col-xl-8">
                <!--begin::Forms Widget 1-->
                <div class="card card-custom card-shadowless gutter-b card-stretch card-shadowless p-0">
                    <!--begin::Nav Tabs-->
                    <ul class="dashboard-tabs nav nav-pills nav-danger row row-paddingless m-0 p-0" role="tablist">
                        <!--begin::Item-->
                        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                            <a class="nav-link active border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#forms_widget_tab_1">
                                <span class="nav-icon py-2 w-auto">
                                    {{ getSVG('assets/media/svg/icons/Home/Library.svg', 'svg-icon-3x') }}
                                </span>
                                <span class="nav-text font-size-lg py-2 font-weight-bold text-center">{{ __('admin.sales_dashboard') }}</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                            <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#forms_widget_tab_3">
                                <span class="nav-icon py-2 w-auto">
                                    {{ getSVG('assets/media/svg/icons/Clothes/T-Shirt.svg', 'svg-icon-3x') }}
                                </span>
                                <span class="nav-text font-size-lg py-2 font-weight-bolder text-center">{{ __('admin.most_sell_products') }}</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                            <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#forms_widget_tab_4">
                                <span class="nav-icon py-2 w-auto">
                                    {{ getSVG('assets/media/svg/icons/Communication/Group.svg', 'svg-icon-3x') }}
                                </span>
                                <span class="nav-text font-size-lg py-2 font-weight-bolder text-center">{{ __('admin.best_customers') }}</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                       
                        <!--end::Item-->
                    </ul>
                    <!--end::Nav Tabs-->
                </div>
                <!--end::Forms Widget 1-->
            </div>
            <div class="col-xl-4">
                <!--begin::Engage Widget 8-->
                <!--end::Engage Widget 8-->
            </div>
        </div>
        <!--begin::Nav Content-->
        <div class="tab-content m-0 p-0 mb-20 mt-10">
            <div class=" row col-12 tab-pane active" id="forms_widget_tab_1" role="tabpanel">

            </div>
            <div class="tab-pane" id="forms_widget_tab_2" role="tabpanel">

            </div>
            <div class="tab-pane" id="forms_widget_tab_3" role="tabpanel">

            </div>
            <div class="tab-pane" id="forms_widget_tab_4" role="tabpanel">

            </div>
        </div>
    </div>
    @section('scripts')
        {{-- <script src="{{ asset('/js/dashboard.js') }}"></script> --}}
    @endsection
</x-master>
