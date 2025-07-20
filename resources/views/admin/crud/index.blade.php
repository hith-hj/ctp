<x-master title="{{ __('admin.'.plural($item)) }}">
    @section('style')
        @if(View::exists('admin.'.$item.'._styles'))
            @include('admin.'.$item.'._styles')
        @endif
    @endsection
    <x-breadcrumb :item="$item"></x-breadcrumb>
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">

                    @include('admin.layouts.panels._alerts')

                    @include('admin.'.$item.'._table')

                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

    <x-slot name="footer"></x-slot>
    @section('scripts')
        @if(View::exists('admin.'.$item.'._scripts'))
            @include('admin.'.$item.'._scripts')
        @endif
    @endsection
</x-master>
