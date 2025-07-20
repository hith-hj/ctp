<!--begin::Subheader-->
<div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-dark">{{ __('admin.home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ action("App\Http\Controllers\Admin\\".toTitle($item)."Controller@index") }}" class="text-muted">{{ __('admin.'.plural($item)) }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="active">{{ __('admin.'.$item) }}</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
    </div>
</div>
<!--end::Subheader-->
