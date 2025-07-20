<x-master title="{{__('user.dashboard.'.getAction() )}} {{ __('user.dashboard.'.$item) }}">

    <x-breadcrumb :item="$item"></x-breadcrumb>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <!-- begin::Card-->
            <div class="card card-custom overflow-hidden">
                <div class="card-body p-0">
                    <!-- begin: Invoice-->
                    <!-- begin: Invoice header-->
                    <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0 {{app()->getLocale() == 'ar' ? 'text-right' : '' }}">
                        <div class="col-md-11">
                            <div class="d-flex justify-content-between pb-5 pb-md-10 flex-column flex-md-row">
                                <h1 class="display-4 font-weight-boldest mb-10">{{ $product->name }}
                                    <div class="border-bottom w-40 m-3"></div>
                                    <span class="d-flex flex-column font-weight-light align-items-md-start opacity-70">
                                        {!! $product->description !!}
                                    </span>
                                </h1>
                                @if(!is_null($product->featured_image) )
                                    <div class="d-flex flex-column align-items-md-end px-0 w-100">
                                        <a href="{{ storageImage($product->featured_image) }}" class="mb-5 fancybox w-75">
                                            <div class="flex-shrink-0 mr-2 w-100">
                                                <div class="w-100"
                                                     style="background-image: url({{ storageImage($product->featured_image) }});
                                                     height:250px;
                                                     background-position: center;
                                                     background-repeat: no-repeat;">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="border-bottom w-100"></div>
                            <div class="d-flex justify-content-between pt-6 ">
                                <!--<div class="d-flex flex-column flex-root">-->
                                <!--    <span class="font-weight-bolder mb-2">{{ __('product.sku') }}</span>-->
                                <!--    <span class="opacity-70">{{ $product->sku }}</span>-->
                                <!--</div>-->
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('product.category') }}</span>
                                    <a class="text-black-50 text-hover-primary"
                                       href="{{ route('admin.categories.show', ['category' => $product->category]) }}">
                                        <span class="opacity-70">{{ $product->category->name }}</span>
                                    </a>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('product.owner') }}</span>
                                    <a class="text-black-50 text-hover-primary"
                                       href="{{ route('admin.admins.show', ['admin' => $product->owner])}}">
                                    <span class="opacity-70">
                                        {{ $product->owner->name }}
                                        - {{ $product->owner->roles()->first()->name }}
                                    </span>
                                    </a>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('product.status') }}</span>
                                    <span class="text-muted font-weight-bold">
                                        <span
                                            class="label label-lg label-inline label-light-{{$product->status ? 'success':'danger'}} mr-2">
                                            {{ $product->status ? __('admin.active') : __('admin.inactive') }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-6 ">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('product.price') }}</span>
                                    <span class="text-danger font-weight-boldest">{{ $product->price }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">{{ __('product.Capital price') }}</span>
                                    <span class="text-danger font-weight-boldest">{{ $product->capital_price ?? 0 }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span
                                        class="font-weight-bolder mb-2">{{ __('product.price_before_discount') }}</span>
                                    <span class="text-danger font-weight-boldest" style="text-decoration:line-through;">
                                        {{ $product->price_before_discount }}
                                    </span>
                                </div>
                            </div>
                            <div class="border-bottom w-100 m-4"></div>
                            <div class="d-flex flex-column align-items-md-start px-0">
                                <span class="font-weight-bolder mb-2">{{__('product.Ranges')}}</span>
                            </div>
                            <div class="d-flexx justify-content-between pt-6 ">
                                @forelse($product->ranges as $range)
                                    <div class="d-flex my-2" style="gap:20px">
                                        <span class="font-weight-bolder mb-2">
                                            {{ __('product.Range price') }}
                                        </span>
                                        <span class="text-primary font-weight-boldest">
                                            {{ $range->price }}
                                        </span>
                                        <span class="font-weight-bolder mb-2">
                                            {{ __('product.Range start') }}
                                        </span>
                                        <span class="text-primary font-weight-boldest">
                                            {{ $range->range_start }}
                                        </span>
                                        <span class="font-weight-bolder mb-2">
                                            {{ __('product.Range end') }}
                                        </span>
                                        <span class="text-primary font-weight-boldest" >
                                            {{ $range->range_end }}
                                        </span>
                                        <span class="font-weight-bolder mb-2">
                                            {{ __('product.delete') }}
                                        </span>
                                        <form method="post" action="{{route('admin.deleteProductPriceRange',['range_id'=>$range->id])}}">
                                            @csrf
                                            <button type="submit" class="btn btn-def btn-sm p-0 m-0">
                                                <i class="fa fa-trash text-danger p-0"></i>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <p>{{__('nothing')}}</p>
                                @endforelse
                            </div>
                            <form method="post" action="{{route('admin.productPriceRanges',['product'=>$product->id])}}">
                                @csrf
                                <div class="d-flex justify-content-between pt-6">
                                    <div class="d-flex flex-column flex-root mx-1">
                                        <span class="font-weight-bolder mb-2">
                                            {{ __('product.Range price') }}
                                        </span>
                                        <input type="number" name="price" class="form-control">
                                    </div>
                                    <div class="d-flex flex-column flex-root mx-1">
                                        <span class="font-weight-bolder mb-2">
                                            {{ __('product.Range start') }}
                                        </span>
                                        <input type="number" name="range_start" class="form-control">
                                    </div>
                                    <div class="d-flex flex-column flex-root mx-1">
                                        <span class="font-weight-bolder mb-2">
                                            {{ __('product.Range end') }}
                                        </span>
                                        <input type="number" name="range_end" class="form-control">
                                    </div>
                                    <div class="d-flex flex-column flex-root mx-1">
                                        <span class="font-weight-bolder mb-2">
                                            {{ __('product.Store') }}
                                        </span>
                                        <button type="submit" class="btn btn-primary">{{__('product.Save')}}</button>
                                    </div>
                                </div>
                            </form>
                            <div class="border-bottom w-100 m-4"></div>
                            
                            <div class="d-flex justify-content-between pt-6">
                                @foreach($product->attributes as $attribute)
                                    <div class="d-flex flex-column flex-root">
                                        <span
                                            class="font-weight-bolder mb-2">{{ $attribute->name . ' ('. $attribute->type .')' }}</span>
                                        <span class="opacity-70">
                                        @if($attribute->type == 'color')
                                                {{ $attribute->pivot->value }}<span id="status_badge"
                                                                                    class="label label-sm label-rounded ml-4"
                                                                                    style="background-color:{{ $attribute->pivot->value }}"></span>
                                            @elseif($attribute->type == 'checkbox')
                                                <span
                                                    class="label label-lg label-inline label-light-{{$attribute->pivot->value ? 'success':'danger'}} mr-2">
                                                {{ $attribute->pivot->value ? __('admin.yes') : __('admin.no') }}
                                            </span>
                                            @elseif($attribute->type == 'number')
                                                <span
                                                    class="text-danger font-weight-boldest">{{ $attribute->pivot->value }}</span>
                                            @else
                                                {{ $attribute->pivot->value }}
                                            @endif
                                    </span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-bottom w-100 m-4 mt-9"></div>
                            <div class="d-flex flex-column align-items-md-start px-0">
                                <span class="font-weight-bolder mb-2">{{__('admin.images')}}</span>
                            </div>
                            <div class="d-flex justify-content-start mr-2 pt-6">
                                @foreach($product->images as $image)
                                    <div class="d-flex flex-column align-items-md-end px-0">
                                        <!--begin::Logo-->
                                        <a href="{{ storageImage($image) }}" class="mb-5 fancybox">
                                            <div class="symbol symbol-100 flex-shrink-0 mr-2">
                                                <div class="symbol-label"
                                                     style="background-image: url({{ storageImage($image) }})">
                                                </div>
                                            </div>
                                        </a>
                                        <!--end::Logo-->
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-bottom w-100 m-4 mt-9"></div>
                        </div>
                    </div>
                    <!-- end: Invoice header-->

                    <!-- end: Invoice-->
                </div>
            </div>
            <!-- end::Card-->
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</x-master>
