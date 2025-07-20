<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    @include('admin.layouts.partials._meta')
    @yield('style')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" direction="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed aside-enabled aside-static page-loading">

    <!--begin::Main-->
    <!--<div class="page-loader page-loader-logo">-->
    <!--    <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';" alt="{{ config('app.title') }}" width="128" height="auto" src="{{ asset('icons/icon-xl.png') }}" />-->
    <!--    <div class="spinner spinner-primary"></div>-->
    <!--</div>-->

    <!--begin::Header Mobile-->
    @include('admin.layouts.base._header-mobile')
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            @include('admin.layouts.base._aside')
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                @include('admin.layouts.base._header')
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding-top: 15px;">
                    <!--begin::Container-->
                    {{ $slot }}
                    <!--end::Container-->
                </div>
                <!--end::Entry-->

                <!--end::Content-->
                <!--begin::Footer-->
                @include('admin.layouts.base._footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->

    <!-- begin::Notifications Panel-->
    @includeWhen(isset($notifications), 'admin.layouts.panels._notifications')
    <!-- end::Notifications Panel-->

    <!--begin::Quick Actions Panel-->
    @include('admin.layouts.panels._actions')
    <!--end::Quick Actions Panel-->

    <!-- begin::User Panel-->
    @includeWhen(auth()->user(), 'admin.layouts.panels._profile')
    <!-- end::User Panel-->

    <!--begin::Scrolltop-->
    @include('admin.layouts.panels._scroll')
    <!--end::Scrolltop-->
    <!--begin::Sticky Toolbar-->
    @includeWhen(auth()->user(), 'admin.layouts.panels._sticky_toolbar')
    <!--end::Sticky Toolbar-->

    @include('admin.layouts.partials._scripts')
    @yield('scripts')

    @includeWhen(isset($richTextBoxScript), 'admin.layouts.partials._rich_text_script')
    @includeWhen(isset($colorScript), 'admin.layouts.partials._color_script')
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>