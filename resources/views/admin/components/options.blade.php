<div id="collapseTwo6" class="collapse" data-parent="#accordionExample6">
    <div class="card-body">
            @foreach ($colors as $color)
                <div class="pb-5">
                    <div class="card-header card-header-right ribbon ribbon-clip ribbon-left">
                        <div class="ribbon-target" style="top: 12px; color: {{ getTextColor($color->code) }};">
                            <span class="ribbon-inner" style="background: {{ $color->code }};"></span>{{$color->name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <x-image  :name="'images'.$color->id" :required="false" :multiple="true" :oldValue="newStd(['images'.$color->id => $color->getProductImages($productId)])"></x-image>
                        </div>
                        <div class="col-lg-7"><br><br>
                            <div class="kt_repeater{{$color->hasOptions($productId)?'_edit':''}}">
                                <div class="form-group row">
                                    <div data-repeater-list="{{$color->id}}" class="col-lg-12">
                                        @if($options)
                                            @foreach ($options as $option)
                                                @if ($option['color']->id == $color->id)
                                                    @foreach ($option['sizes'] as $item)
                                                        <div data-repeater-item="attribute" class="form-group row align-items-center">
                                                            <div class="col-md-3">
                                                                <label>{{ __('product.size') }}:</label>
                                                                <select required name="item_size" class="form-control">
                                                                    <option value="">{{ __('product.empty') }}</option>
                                                                    @foreach($sizes as $size)
                                                                        <option id="{{$size->id}}" value="{{$size->id}}" {{ $item->size_id == $size->id  ? 'selected' : ''}}>{{$size->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>{{ __('product.sort_order') }}:</label>
                                                                <input required name="item_sort_order" value="{{$item->sort_order}}" type="number" min="0" step="any" class="form-control" />
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>{{ __('product.stock') }}:</label>
                                                                <input required name="item_stock" value="{{$item->stock}}" type="number" min="0" step="any" class="form-control" />
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>{{ __('product.price') }}:</label>
                                                                <input required name="item_price" value="{{$item->price}}"  type="number" min="0" step="any" class="form-control" />
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                            <div class="col-md-3" style="padding-top: 25px; padding-left: 25px;">
                                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                    <i class="la la-trash-o"></i>{{ __('product.delete') }}</a>
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            @if (!$color->hasOptions($productId))
                                            @include('admin.layouts.panels._product_options')
                                            @endif
                                        @else
                                             @include('admin.layouts.panels._product_options')
                                        @endif

                                    </div>
                                </div>
                                <label class="col-lg-2 col-form-label text-right"></label>
                                <div class="col-lg-6">
                                    <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                        <i class="la la-plus"></i>{{ __('product.add_options') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="separator separator-dashed my-5"></div>
            @endforeach
        </div>
</div>
