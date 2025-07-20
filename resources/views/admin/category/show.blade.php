<x-master title="{{__('admin.show')}} {{ __('admin.'.$item) }}">

    <x-breadcrumb :item="$item"></x-breadcrumb>
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
					<div class="card card-custom gutter-b">
						<div class="card-body px-0">
							<div class="card card-custom">
								<div class="card-header">
									<div class="card-title">
										<h3 class="card-label">{{ __('category.category_details') }}</h3>
									</div>
									<div class="card-toolbar">
										<ul class="nav nav-light-success nav-bold nav-pills">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_4_1">
													<span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
													<span class="nav-text">{{ __('category.info') }}</span>
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4_2">
													<span class="nav-icon"><i class="flaticon2-drop"></i></span>
													<span class="nav-text">{{ __('category.prod_sub_cat') }}</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<div class="tab-pane fade show active" id="kt_tab_pane_4_1" role="tabpanel"
											aria-labelledby="kt_tab_pane_4_1">
											<div class="card-body pt-3 pb-0">
												<div class="row">
													@foreach(config('translatable.locales') as $key => $locale)
													<div class="col-xl-6">
														<div
															class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
															<div class="d-flex flex-column flex-grow-1 mr-2">
																<a href="#"
																	class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.name') }}
																	{{ $locale }}</a>
																<span
																	class="text-muted font-weight-bold">{{${$item}->translate($locale)->{'name'} }}</span>
																	{{-- <span
																	class="text-muted font-weight-bold">{{${$item}->name }}</span> --}}
															</div>
														</div>
													</div>
													@endforeach
												</div>
												<div class="row">
													<div class="col-xl-6">
														<div
															class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
															<div class="d-flex flex-column flex-grow-1 mr-2">
																<a href="#"
																	class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.status') }}</a>
																<span class="text-muted font-weight-bold">
																	<span
																		class="label label-lg label-inline label-light-{{  ${$item}->is_active ? 'success' : 'danger' }} mr-2">
																		{{ ${$item}->is_active ? __('admin.active') : __('admin.inactive') }}
																	</span>
																</span>
															</div>
														</div>
													</div>
													<div class="col-xl-6">
														<div
															class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
															<div class="d-flex flex-column flex-grow-1 mr-2">
																<a href="#"
																	class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.sort_order') }}</a>
																<span
																	class="text-muted font-weight-bold">{{${$item}->sort_order}}</span>
															</div>
														</div>
													</div>
												</div>
											</div><br><br>
											<div class="card-body pt-3 pb-0">
												<div class="col-md-12 row">
												    @if(!is_null(${$item}->image))
    													<h5>{{ __('category.image') }}</h5>
    													<div class="card-body">
    														<div class="d-flex align-items-center p-5">
    															<!--begin::Icon-->
    															<div class="mr-6">
    																<span class="svg-icon svg-icon-primary svg-icon-4x">
    																	<div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                                                            <a class="fancybox" href="{{ storageImage(${$item}->image) }}">
                                                                                <div class="symbol symbol-50 symbol-lg-120">
    																			    <!--<img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  alt="Image" src="{{ storageImage(${$item}->image) }}">-->
    																			    <img alt="Image" src="{{ storageImage(${$item}->image) }}">
                                                                                </div>
                                                                            </a>
    																	</div>
    																</span>
    															</div>
    															<!--end::Icon-->
    														</div>
    													</div>
                                                    @endif
													@if (${$item}->guide_image)
													<div class="card-body">
														<div class="d-flex align-items-center p-5">
															<!--begin::Icon-->
															<div class="mr-6">
																<span class="svg-icon svg-icon-primary svg-icon-4x">
																	<div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
																		<div class="symbol symbol-50 symbol-lg-120">
																			<img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  alt="Pic"
																				src="{{ storageImage(${$item}->guide_image) }}">
																		</div>
																	</div>
																</span>
															</div>
															<!--end::Icon-->
															<!--begin::Content-->
															<div class="d-flex flex-column">
																<div
																	class="text-dark font-weight-bold font-size-h6 mb-3">
																	{{ __('category.guide_img') }}</a>
																</div>
																<!--end::Content-->
															</div>
														</div>
													</div>
													@endif
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="kt_tab_pane_4_2" role="tabpanel"
											aria-labelledby="kt_tab_pane_4_2">
											<div id="kt_tree_2" class="tree-demo">
												<ul>
													<li
														data-jstree='{  "icon": "fas fa-boxes text-danger" , "opened" : true ,"selected" : true }'>
														{{ ${$item}->translate($locale)->{'name'} }}
														{{-- {{ ${$item}->name }} --}}
														<ul>
															@foreach (${$item}->parentCategory as $subCategory)
															<li
																data-jstree='{"icon": "fas fa-box-open text-danger", "opened" : true }'>
																<a
																	href="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@show', ['category' => $subCategory]) }}">
																	{{ $subCategory->translate($locale)->{'name'} }}
																	{{-- {{ ${$item}->name }} --}}

																</a>
																<ul>
																	@foreach ($subCategory->products as $product)
																	<li
																		data-jstree='{  "icon": "fa fa-file text-default" }'>
																		<a
																			href="{{ action('App\Http\Controllers\Admin\ProductController@show', ['product' => $product]) }};">
																			{{	$product->translate($locale)->{'name'} }}
																			{{-- {{ ${$item}->name }} --}}

																		</a>
																	</li>
																	@endforeach

																</ul>
															</li>
															@endforeach
															@foreach (${$item}->products as $product)
															<li data-jstree='{  "icon": "fa fa-file text-default" }'>
																{{	$product->translate($locale)->{'name'} }}
														{{-- {{ ${$item}->name }} --}}

															</li>
															@endforeach
														</ul>
													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
				</div>
			</div>
			<!--end::Row-->
		</div>
	</div>
	<!--end::Container-->
</x-master>
