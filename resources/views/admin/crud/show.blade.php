<x-master title="{{__('admin.'.getAction() )}} {{ __('admin.'.$item) }}">

    <x-breadcrumb :item="$item"></x-breadcrumb>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
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
                                                    @foreach(getTranslatableAttributes($class) as $attr)
                                                        @foreach(config('translatable.locales') as $key => $locale)
                                                        <div class="col-xl-6">
                                                            <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                                <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                    <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __('admin.'.$attr) }} {{ $locale }}</a>
                                                                    <span class="text-muted font-weight-bold">{!! isset(${$item}->translate($locale)->$attr)? ${$item}->translate($locale)->$attr:'' !!} </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    @endforeach
                                                </div>


                                                <div class="row">
                                                    @foreach(getVisibleAttributes($class) as $key => $attr)
                                                    <div class="col-xl-6">
                                                        <div class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.'.$key) }}</a>
                                                                @if($attr == 'status')
                                                                    <span class="text-muted font-weight-bold">
                                                                        <span class="label label-lg label-inline label-light-{{${$item}->$key?'success':'danger'}} mr-2">
                                                                            {{ label(${$item}, $key, $attr) }}
                                                                        </span>
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted font-weight-bold">{{ label(${$item}, $key, $attr) }} </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="row mt-20">
                                                    @foreach(getMediaAttributes($class) as $key => $attr)
                                                        @if($attr == 'image')
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center p-5">
                                                                    <!--begin::Icon-->
                                                                    <div class="mr-6">
                                                                    <span class="svg-icon svg-icon-primary svg-icon-4x">
                                                                        <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                                                            <div class="symbol symbol-50 symbol-lg-120">
                                                                                <a class="fancybox symbol symbol-50 symbol-lg-120" href="{{ ${$item}->{$key} ? storageImage(${$item}->{$key}) : asset('custom/images.jpg') }}">
                                                                                    <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  alt="{{ __($item.'.'.$key) }}"
                                                                                         src="{{ ${$item}->{$key} ? storageImage(${$item}->{$key}) : asset('custom/images.jpg') }}">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                    </div>
                                                                    <!--end::Icon-->
                                                                    <!--begin::Content-->
                                                                    <div class="d-flex flex-column">
                                                                        <div class="text-dark font-weight-bold font-size-h6 mb-3">
                                                                            {{ __($item.'.'.$key) }}</div>
                                                                    </div>
                                                                    <!--end::Content-->
                                                                </div>
                                                            </div>
                                                        @elseif($attr == 'images')
                                                            @if(${$item}->{$key})
                                                                @foreach(${$item}->{$key} as $media)
                                                                <div class="card-body">
                                                                    <div class="d-flex align-items-center p-5">
                                                                        <!--begin::Icon-->
                                                                        <div class="mr-6">
                                                                        <span class="svg-icon svg-icon-primary svg-icon-4x">
                                                                            <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                                                                <div class="symbol symbol-50 symbol-lg-120">
                                                                                    <a class="fancybox symbol symbol-50 symbol-lg-120" href="{{ $media ? storageImage($media) : asset('custom/images.jpg') }}">
                                                                                        <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  alt="{{ __($item.'.'.$key) }}"
                                                                                             src="{{ $media ? storageImage($media) : asset('custom/images.jpg') }}">
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </span>
                                                                        </div>
                                                                        <!--end::Icon-->
                                                                        <!--begin::Content-->
                                                                        <div class="d-flex flex-column">
                                                                            <div class="text-dark font-weight-bold font-size-h6 mb-3">
                                                                                {{ __($item.'.'.$key) }} {{ $loop->index+1 }}</div>
                                                                        </div>
                                                                        <!--end::Content-->
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endforeach

                                                </div>

												<!--end::Body-->
										</div>
											<!--end::Advance Table Widget 2-->
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
        <!--end::Dashboard-->
		</div>
	</div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</x-master>
