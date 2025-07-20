<div id="kt_header_mobile" class="header-mobile header-mobile-fixed">
    <!--begin::Logo-->
    <a href="#">
        <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  alt="Logo" src="{{ asset('assets/media/logos/logo-letter-1.png') }}" class="logo-default max-h-30px" loading="lazy"/>
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
        <button class="btn p-0 burger-icon rounded-0 burger-icon-left" id="kt_aside_tablet_and_mobile_toggle">
            <span></span>
        </button>
        <button class="btn btn-hover-text-primary p-0 ml-3" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                    {{ getSVG('media/svg/icons/General/User.svg') }}
                    <!--end::Svg Icon-->
                </span>
        </button>
    </div>
    <!--end::Toolbar-->
</div>
