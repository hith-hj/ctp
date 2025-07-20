<x-master title="{{__('admin.show')}} {{ __('admin.'.$item) }}">

    <x-breadcrumb :item="$item"></x-breadcrumb>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
	<x-slot name="richTextBoxScript"></x-slot>
	<!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">
                    <h1 class="mt-10">{{ __('admin.show') }}
                        <code>{{ ${$item}->name }}</code> {{ __('admin.'.$item) }}
                    </h1>
                    @include('admin.layouts.panels._alerts')
                    <div class="card card-custom shadow-lg mt-10">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b">
                            <div class="card-body px-0">
                                <div class="tab-content pt-5">
                                      <!--begin::Tab Content-->
                                        <div class="col-lg-12">
                                            <!--begin::Advance Table Widget 2-->
                                            <div class="card card-custom card-stretch gutter-b">
                                                <!--begin::Body-->
                                                <div class="card-body pt-3 pb-0">
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                                <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                    <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.username') }}</a>
                                                                    <span class="text-muted font-weight-bold">{{${$item}->username}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                                <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                    <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.email') }}</a>
                                                                    <span class="text-muted font-weight-bold">{{${$item}->email}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                                <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                    <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.roles') }}</a>
                                                                    @foreach(${$item}->roles as $role)
                                                                        <span class="text-muted font-weight-bold">{{$role->name}} , </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <!--end::Body-->
                                            </div>
                                                <!--end::Advance Table Widget 2-->
                                                <div class="card-body pt-3 pb-0">
                                                    <div class="col-md-12 row">
                                                        <h5>{{ __($item.'.images') }}</h5>
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center p-5">
                                                                <!--begin::Icon-->
                                                                <div class="mr-6">
                                                                    <span class="svg-icon svg-icon-primary svg-icon-4x">
                                                                        <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                                                            <a class="fancybox" href="{{ ${$item}->avatar ? storageImage(${$item}->avatar) : asset('custom/images.jpg') }}">
                                                                                <div class="symbol symbol-50 symbol-lg-120">
                                                                                    <label>{{ __($item.'.avatar') }}</label>
                                                                                        <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  alt="{{ __($item.'.avatar') }}"
                                                                                             src="{{ ${$item}->avatar ? storageImage(${$item}->avatar) : asset('custom/images.jpg') }}">
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                                <div class="mr-6">
                                                                    <span class="svg-icon svg-icon-primary svg-icon-4x">
                                                                        <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                                                            <a class="fancybox" href="{{ ${$item}->cover_image ? storageImage(${$item}->cover_image) : asset('custom/images.jpg') }}">
                                                                                <div class="symbol symbol-50 symbol-lg-120">
                                                                                    <label>{{ __($item.'.cover_image') }}</label>
                                                                                         <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  alt="{{ __($item.'.cover_image') }}"
                                                                                              src="{{ ${$item}->cover_image ? storageImage(${$item}->cover_image) : asset('custom/images.jpg') }}">
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                                <!--end::Icon-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    <!--end::Tab Content-->

                                <div class="card-footer">
                                    <button  onclick="window.history.back()" type="submit" class="btn btn-primary mr-2">
                                        <i class="ki ki-long-arrow-back icon-sm"></i>{{__('admin.back')}}
                                    </button>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
            </div>
        </div>
            <!--end::Container-->
        </div>
    </div>
    <!--end::Entry-->
    <x-slot name="footer"></x-slot>
</x-master>
