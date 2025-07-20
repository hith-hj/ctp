<br>
<br>
<div class="form-group row col-md-12 mt-10" dir="{{ $locale=='ar' ? 'rtl' : '' }}">
    <label style="white-space: nowrap;" class="col-xl-4 col-lg-4 col-form-label text-center @if($required) required @endif">
        {{ isset($item) ? __($item.'.'. raw($name)) : __('admin.'.raw($name))}}
    </label>
    <div class="{{ $locale=='ar' ? 'mr-10' : 'ml-10' }} image-input border-red-500" id="{{ $name }}">
        @if(!$multiple)
        <div class="image-input-wrapper" style="background-image: url({{ $oldValue && $oldValue->{$name} != '' ? storageImage($oldValue->{$name}) : asset('custom/upload_simge.png') }}); background-size: contain"></div>
        @else
        <div class="image-input-wrapper" style="background-image: url({{ $oldValue && $oldValue->{$name} ? storageImage($oldValue->{$name}[0]) : asset('custom/upload_simge.png') }}); background-size: contain"></div>
        @endif
        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change image">
            <i class="fa fa-pen icon-sm text-muted"></i>
            <!--<input type="file" @if($multiple) multiple @else value="{{$oldValue && $oldValue->{$name} != ''? $oldValue->{$name} : '' }}" @endif name="{{ $name }}{{ $multiple ? '[]' : '' }}" accept=".png, .jpg, .jpeg" @if($required) required @endif />-->
            <input type="file" @if($multiple) multiple @else value="{{$oldValue && $oldValue->{$name} != ''? $oldValue->{$name} : '' }}" @endif name="{{ $name }}{{ $multiple ? '[]' : '' }}" accept=".png, .jpg, .jpeg" />
            <input type="hidden" name="image_remove" />
        </label>

        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image">
            <i class="ki ki-bold-close icon-xs text-muted"></i>
        </span>
    </div>
    @error($name)
    @enderror
</div>
@if($multiple)
@if($oldValue && $oldValue->{$name})
<p class="float-left">current images <span class="badge-primary pl-2 pr-2" style="border-radius: 5px">{{ $oldValue && $oldValue->{$name} ? sizeof($oldValue->{$name}) : '' }}</span></p>
<div class="col-md-12 row" dir="ltr">
    <div class="d-flex justify-content-start mr-2 pt-6">
        @foreach($oldValue->{$name} as $singleImage)
        <div class="d-flex flex-column align-items-md-end px-0">
            <!--begin::Logo-->
            <a href="{{ storageImage($singleImage) }}" class="mb-5 fancybox">
                <div class="symbol symbol-100 flex-shrink-0 mr-2">
                    <div class="symbol-label" style="background-image: url({{ storageImage($singleImage) }})">
                    </div>
                    <a href="#" class="remove-image" data-id="{{$oldValue->id ?? null}}" data-url="{{route('admin.removeImage')}}" data-src="{{$singleImage}}">
                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                        </span>
                    </a>
                </div>
            </a>
            <!--end::Logo-->
        </div>
        @endforeach
    </div>
</div>
<br>
<br>
@endif
@endif