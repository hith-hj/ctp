<x-master title="{{ __('admin.'.plural($item)) }}">
    @section('style')
        @if(View::exists('admin.'.$item.'._styles'))
            @include('admin.'.$item.'._styles')
        @endif
    @endsection
<!--begin::Container-->
    <x-breadcrumb :item="$item"></x-breadcrumb>
    <div class="container">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-xl-12">
                <h1 class="mt-10 {{app()->getLocale() == 'ar'? 'text-right' : 'text-left'}}" >{{ __('admin.all_'.plural($item)) }}</h1>

                @include('admin.layouts.panels._alerts')

                @include('admin.'.$item.'._tableStatus')

            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->
    </div>
    <!--end::Container-->

    <x-slot name="footer"></x-slot>

    @section('scripts')
        <script src="{{ asset('/js/order.js') }}"></script>
    @endsection
</x-master>
