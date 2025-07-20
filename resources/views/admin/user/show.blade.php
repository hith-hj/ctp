<x-master title="{{__('admin.show')}} {{ __('admin.'.$item) }}">

    @section('breadcrumb')
    @include('admin.layouts.base._breadcrumb', ['singular' => __('admin.'.$item), 'route' =>
    action("App\Http\Controllers\Admin\\".toTitle($item)."Controller@index"), 'plural' => __('admin.'.plural($item))])
    @endsection

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
						<!--begin::Header-->
						<!--end::Header-->
						<div class="card-body px-0">
							<div class="tab-content pt-5">
								<div class="tab-pane active" id="kt_apps_contacts_view_tab_2" role="tabpanel">
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
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.username') }}</a>
                                                                <span class="text-muted font-weight-bold">{{${$item}->name}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.email') }}</a>
                                                                <span class="text-muted font-weight-bold">{{${$item}->email}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
												</div>

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('admin.status') }}</a>
                                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><span class="label label-lg label-inline label-light-{{ ${$item}->status ? 'success' : 'danger' }} mr-2">{{ ${$item}->status ? __('admin.active') : __('admin.inactive') }}</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.gender') }}</a>
                                                                <span class="text-muted font-weight-bold">	{{ ${$item}->gender ? __('admin.male') : __('admin.female') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.is_company') }}</a>
                                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><span class="label label-lg label-inline label-light-{{ ${$item}->status ? 'success' : 'danger' }} mr-2">{{ ${$item}->status ? __('user.company') : __('user.not_company') }}</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.subscribe_status') }}</a>
                                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><span class="label label-lg label-inline label-light-{{ ${$item}->status ? 'success' : 'danger' }} mr-2">{{ ${$item}->status ? __('user.subscribed') : __('user.not_subscribed') }}</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.dob') }}</a>
                                                                <span class="text-muted font-weight-bold">{{${$item}->dob}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.phone_number') }}</a>
                                                                <span class="text-muted font-weight-bold">{{${$item}->phone_number}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.street_address') }}</a>
                                                                <span class="text-muted font-weight-bold">{{${$item}->street_address ??  __('admin.empty')}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.post_code') }}</a>
                                                                <span class="text-muted font-weight-bold">{{${$item}->post_code ??  __('admin.empty')}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('user.country_code_id') }}</a>
                                                                <span class="text-muted font-weight-bold">{{ ${$item}->countryCode ? ${$item}->countryCode->name :  __('admin.empty') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('admin.area') }}</a>
                                                                <span class="text-muted font-weight-bold">{{ ${$item}->area ? ${$item}->area->translate()->name :  __('admin.empty') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('admin.currency') }}</a>
                                                                <span class="text-muted font-weight-bold">{{ ${$item}->currency ? ${$item}->currency->translate()->name :  __('admin.empty') }}</span>
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
                                                                        <div class="symbol symbol-50 symbol-lg-120">
                                                                            <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  alt="{{ __($item.'.avatar') }}"
                                                                                src="{{ ${$item}->avatar ? storageImage(${$item}->avatar) : asset('custom/images.jpg') }}">
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <!--end::Icon-->
                                                            <!--begin::Content-->
                                                            <div class="d-flex flex-column">
                                                                <div class="text-dark font-weight-bold font-size-h6 mb-3">
                                                                    {{ __($item.'.avatar') }}</div>
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
									</div>
							    </div>
								<!--end::Tab Content-->
								<!--begin::Tab Content-->
								<div class="tab-pane" id="kt_apps_contacts_view_tab_3" role="tabpanel"></div>
								<!--end::Tab Content-->
							</div>
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
</x-master>
