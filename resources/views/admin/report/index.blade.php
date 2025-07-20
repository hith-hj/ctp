<x-master title="{{ __($item.'.'.plural($item)) }}">

    <!--begin::Container-->
    <div class="container">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-xl-12">
                <h1 class="mt-10" >{{ __($item.'.all_'.plural($item)) }}</h1>

                @include('admin.layouts.panels._alerts')

                @include('admin.'.$item.'.table._'.$methodName)

            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->
    </div>
    <!--end::Container-->

    <x-slot name="footer"></x-slot>

</x-master>
