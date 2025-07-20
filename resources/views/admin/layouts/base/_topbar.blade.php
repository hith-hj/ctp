<div class="topbar">
    <!--begin::Tablet & Mobile Search-->
    <div class="dropdown d-flex d-lg-none">
        <!--begin::Toggle-->
        <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
            <div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
                {{ getSVG("assets/media/svg/icons/General/Search.svg", "svg-icon-xl svg-icon-primary") }}
            </div>
        </div>
    </div>

    <div class="topbar-item mr-4">
        @if(checkCurrentLang() or app()->getLocale() == 'ar')
            <a href="{{route('admin.changeLanguage','en' ,)}}" class="btn btn-icon btn-sm btn-clean btn-text-dark-75">
            <span class="svg-icon svg-icon-lg">
                <i class="fa fa-language"></i>
            </span>
            </a>
        @else
            <a href="{{route('admin.changeLanguage','ar' ,)}}" class="btn btn-icon btn-sm btn-clean btn-text-dark-75">
            <span class="svg-icon svg-icon-lg">
                <i class="fa fa-language"></i>
            </span>
            </a>
        @endif
    </div>
    @role('Admin')
    <div class="topbar-item mr-4">
        <div class="btn btn-icon btn-sm btn-clean btn-text-dark-75" id="kt_quick_actions_toggle">
            <span class="svg-icon svg-icon-lg">
                {{ getSVG("assets/media/svg/icons/Layout/Layout-4-blocks.svg", "svg-icon-lg") }}
            </span>
        </div>
    </div>
    @endrole
    <!--end::Quick panel-->
    <!--begin::User-->
    <div class="topbar-item mr-4">
        <div class="btn btn-icon btn-sm btn-clean btn-text-dark-75" id="kt_quick_user_toggle">
            <span class="svg-icon svg-icon-lg">
                {{ getSVG("assets/media/svg/icons/General/User.svg", "svg-icon-xl") }}
            </span>
        </div>
    </div>
    <!--end::User-->
</div>
