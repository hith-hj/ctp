<div id="kt_quick_actions" class="offcanvas {{ app()->getLocale()=='ar' ? 'offcanvas-left' : 'offcanvas-right' }} p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-10">
        <h3 class="font-weight-bold m-0">{{ __('admin.quick_actions') }}
            <small class="text-muted font-size-sm ml-2">{{ __('admin.finance_reports') }}</small></h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_actions_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
        @role('Admin')
        <div class="row gutter-b">
            <!--begin::Item-->
            <div class="col-6">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
                    <span class="svg-icon svg-icon-3x svg-icon-primary m-0">
                        {{ getSVG("assets/media/svg/icons/Shopping/Box2.svg", "svg-icon-xl") }}
                    </span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">{{ __('admin.categories') }}</span>
                </a>
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="col-6">
                <a href="{{ route('admin.products.index') }}" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
                    <span class="svg-icon svg-icon-3x svg-icon-primary m-0">
                        {{ getSVG("assets/media/svg/icons/Shopping/Chart-bar1.svg", "svg-icon-xl") }}
                    </span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">{{ __('admin.products') }}</span>
                </a>
            </div>
            <!--end::Item-->
        </div>
        <div class="row gutter-b">
            <!--begin::Item-->
            <div class="col-6">
                <a href="{{ route('admin.settings.index') }}" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
                    <span class="svg-icon svg-icon-3x svg-icon-primary m-0">
                        {{ getSVG("assets/media/svg/icons/Design/Color-profile.svg", "svg-icon-xl") }}
                    </span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">{{ __('admin.settings') }}</span>
                </a>
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="col-6">
                <a href="{{ route('admin.users.index') }}" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5">
                    <span class="svg-icon svg-icon-3x svg-icon-primary m-0">
                        {{ getSVG("assets/media/svg/icons/Communication/Group.svg", "svg-icon-xl") }}
                    </span>
                    <span class="d-block font-weight-bold font-size-h6 mt-2">{{ __('admin.customers') }}</span>
                </a>
            </div>
            <!--end::Item-->
        </div>
        @endrole
    </div>
    <!--end::Content-->
</div>
