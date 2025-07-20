<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container d-flex align-items-stretch justify-content-between">
        <!--begin::Left-->
        <div class="d-none d-lg-flex align-items-center mr-3">
            <!--begin::Aside Toggle-->
            <button class="btn btn-icon aside-toggle ml-n3 mr-10" id="kt_aside_desktop_toggle">
                    <span class="svg-icon svg-icon-xxl svg-icon-dark-75">
                        {{ getSVG('assets/media/svg/icons/Text/Align-left.svg') }}
                    </span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="mx-10">
                <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  alt="Logo" src="{{ asset('custom/logo-icon.png') }}" class="logo-sticky max-h-35px"  loading="lazy"/>
            </a>
        </div>
        @include('admin.layouts.base._topbar')
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
