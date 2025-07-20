<div id="kt_quick_user" class="offcanvas {{ app()->getLocale()=='ar' ? 'offcanvas-left' : 'offcanvas-right' }} p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">{{ __('admin.admin_profile') }}
            <small class="text-muted font-size-sm ml-2">{{ __('admin.logged_admin') }}</small></h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    @php $admin = auth()->user() @endphp
    <!--end::Header-->

    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
        <!--begin::Header-->
        <div class="d-flex align-items-center mt-1">
            <div class="symbol symbol-100 mr-3">
                {{-- <div class="symbol-label" style="background-image: url({{ $admin->avatar ? storageImage($admin->avatar) : asset('media/users/blank.png') }})"></div> --}}
                <div class="symbol-label" style="background-image: url({{ $admin->avatar ? 
                    // asset('storage/'.$admin->avatar) 
                    $admin->avatar 
                : asset('assets/media/users/blank.png') }})" loading="lazy"></div>
                
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column w-100 {{app()->getLocale() == 'ar' ? 'text-right mx-2' : '' }}">
                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                    {{ $admin->name }} 
                    <small class="text-muted">{{ '@'.$admin->username }}</small>
                </a>
                <!--<div class="text-muted mt-1">{{ $admin->username }}</div>-->
                <div class="navi">
                    <a href="{{route('admin.changePasswordForm')}}" class="my-1">{{__('admin.changePassword')}}</a>
                    <a href="#" class="navi-item">
                        <span class="navi-link p-0">
                            <span class="navi-icon">
                                <span class="svg-icon svg-icon-md svg-icon-primary m-0 p-0">
                                        {{ getSVG("assets/media/svg/icons/Communication/Mail-notification.svg", "svg-icon-md") }}
                                </span>
                            </span>
                            <span class="navi-text text-muted text-hover-primary">{{ $admin->email }}</span>
                        </span>
                    </a>
                    <button form="adminLogoutForm" class="btn btn-sm btn-light-primary font-weight-bolder w-100 py-2 px-5 mt-1">
                        {{ __('admin.logout') }}
                    </button>
                    <form id="adminLogoutForm" action="{{ route('logout') }}" method="post">
                        @csrf
                        <!--<input type="submit" value="{{ __('admin.logout') }}" class="btn btn-sm btn-light-primary font-weight-bolder w-100 py-2 px-5">-->
                    </form>
                </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Separator-->
        <div class="separator separator-dashed mt-8 mb-5"></div>
        <!--end::Separator-->
        <!--begin::Nav-->
        <div class="navi navi-spacer-x-0 p-0">
            <!--begin::Item-->
            <a href="{{ route('admin.admins.edit', ['admin' => $admin]) }}" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                            <span class="svg-icon svg-icon-md svg-icon-success">
                                {{ getSVG("assets/media/svg/icons/General/Notification2.svg", "svg-icon-xl") }}
                            </span>
                        </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">{{ __('admin.my_profile') }}</div>
                        <div class="text-muted">{{ __('admin.account_settings') }}
                            <span class="label label-light-danger label-inline font-weight-bold">{{ __('admin.update') }}</span></div>
                    </div>
                </div>
            </a>
            <!--end:Item-->
        </div>
        <!--end::Nav-->
        <!--begin::Separator-->
        <div class="separator separator-dashed my-7"></div>
        <!--end::Separator-->
    </div>
    <!--end::Content-->
</div>
