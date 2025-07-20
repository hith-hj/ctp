<div class="form-group row">
    <label class="col-md-6 col-form-label @if($required) required @endif">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    <div class="col-md-12 col-sm-12">
        <div class="">
            @if($multiple)
            <input type="file" data-container="body" title="Multiple Images" data-toggle="popover" data-placement="right" data-content="{{ __('admin.u_can_upload_multiple_files') }}" name="{{ $name }}[]" multiple class="dropify" @if($required) required @endif data-default-file="{{ $oldValue && $oldValue->{$name} ? storageImage($oldValue->{$name}[0]) : '' }}">
            @else
            <input type="file" name="{{ $name }}" value="{{$oldValue ? $oldValue->{$name} : ''}}" class="dropify" @if($required) required @endif data-default-file="{{ $oldValue ? storageImage($oldValue->{$name}) : '' }}">
            @endif
        </div>
    </div>
    @if($multiple)
    <div class="col-lg-4 col-md-3 mt-20 text-muted">
    </div>
    @endif
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