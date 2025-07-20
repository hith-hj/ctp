<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : 'ltr' }}" id="{{$name}}_section">
    @if($label)
    <label class="col-xl-2 col-lg-2 col-form-label text-center @if($required) required @endif" for="{{ $name }}">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    @endif
    <div class="col-lg-9 col-xl-9">
        <select class="form-control form-control-lg form-control-solid ajax-auto-complete @error($name) is-invalid @enderror" 
        id="{{ $name }}" name="{{ $name }}{{$multiple?'[]':''}}" url="{{ $url }}" 
        data-placeholder="{{ __($item.'.'.$name) }}" {{ $multiple ? 'multiple="multiple"' : '' }} {{ $required ? 'required' : '' }} 
        dir="{{ $locale=='ar' ? 'rtl' : '' }}" style="width: 100% !important; opacity: 1 !important;">
            @if($all == true)
            <option {{ $oldValue ? '' : 'selected' }} value="0"> {{ __('admin.all_'.plural($name)) }}</option>
            @endif
            @if($multiple == false)
            <option value="">{{ __('admin.empty') }}</option>
            @if(isset($oldValue))
            <option selected value="{{ is_object($oldValue) ? $oldValue->id : $oldValue }}">{{ method_exists($oldValue, 'translate') && $oldValue->translate($locale) ? ($oldValue->translate($locale)->$displayName != '' ? $oldValue->translate($locale)->$displayName : $oldValue->$displayName) : $oldValue->$displayName }}</option>
            @endif
            @else
            @foreach($oldValues as $oldValue)
            <option selected value="{{ is_object($oldValue) ? $oldValue->id : $oldValue }}">{{ method_exists($oldValue, 'translate') && $oldValue->translate($locale) ? ($oldValue->translate($locale)->$displayName != '' ? $oldValue->translate($locale)->$displayName : $oldValue->$displayName) : $oldValue->$displayName }}</option>
            @endforeach
            @endif
        </select>
    </div>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>