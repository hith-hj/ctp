<x-master title="{{ __('admin.'.plural($item)) }}">

    <x-breadcrumb :item="$item"></x-breadcrumb>
    <!--begin::Container-->
    <div class="container">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-xl-12">
                <h1 class="mt-5 {{ app()->getLocale()=='ar' ? 'text-right' : 'text-left' }}">{{ __('admin.all_'.plural($item)) }}</h1>

                @include('admin.layouts.panels._alerts')
                @include('admin.'.$item.'._table')
                @include('admin.modals.TreeModal')

            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->
    </div>
    <!--end::Container-->

    <x-slot name="footer"></x-slot>
    @section('scripts')
        <script type="text/javascript">
            $("i[id^=show_]").click(function(event) {
            $(this).toggleClass("fa fa-caret-right fa fa-caret-down");
            $("#extra_" + $(this).attr('id').substr(5)).slideToggle("slow");
            event.preventDefault();
        })
        </script>
    @endsection

</x-master>


