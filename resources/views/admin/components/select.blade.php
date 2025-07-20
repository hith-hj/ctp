<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : 'ltr' }}">
    <label class="col-xl-2 col-lg-2 col-form-label text-center @if($required) required @endif" for="{{ $name }}">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    <div class="col-lg-9 col-xl-9">

        @if(count($options) > 0 )
        <select class="form-control form-control-lg form-control-solid @if($nullable) '' @else select2 @endif @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}{{$multiple?'[]':''}}" {{ $multiple ? 'multiple="multiple"' : '' }} {{ $required ? 'required' : '' }} dir="{{ $locale=='ar' ? 'rtl' : '' }}" style="width: 100% !important; opacity: 1 !important;">
            @if($all == true)
            <option {{ $oldValue ? '' : 'selected' }} value="0"> {{ __('admin.all_'.plural($name)) }}</option>
            @endif
            @if($multiple == false)
            <option value="0" {{!$oldValue ? 'selected' : ''}}>{{ __('admin.empty') }}</option>
            @foreach($options as $option)
            @php $option = json_decode(json_encode($option)) @endphp
            <option {{  $oldValue ? (is_object($oldValue) ? 
            ($option->id == $oldValue->id  ? 'selected' : '') : 
            ($option->id == $oldValue ? 'selected' : '')) : (old($name) == $option->id ? 'selected' : '') }} value="{{ $option->id }}">
            {{ method_exists($option, 'translate') && $option->translate($locale) ? 
            ($option->translate($locale)->$displayName != '' ? $option->translate($locale)->$displayName : $option->$displayName) : $option->$displayName }}
            </option>
            @endforeach
            @else
            @foreach($options as $option)
            @php $option = json_decode(json_encode($option)) @endphp
            <option {{ $oldValues ? ( in_array($option->id, $oldValues) ? 'selected' : '') : '' }} 
            value="{{ $option->id }}">
                {{ method_exists($option, 'translate') && $option->translate($locale) ? 
                ($option->translate($locale)->$displayName ?? $option->$displayName ) : 
                $option->$displayName }}
            </option>
            @endforeach
            @endif
        </select>
        @else
        @if(\Illuminate\Support\Facades\Route::has('admin.'.plural($name).'.create'))
        <a href="{{route('admin.'.plural($name).'.create')}}" class="text-center text-dark-75 font-weight-bolder text-hover-danger mt-3 ml-3 font-size-lg" style="line-height:2.5">{{__('admin.no_records_found_add')}}</a>
        @else
        <a class="text-center text-dark-75 font-weight-bolder text-hover-danger mt-3 ml-3 font-size-lg" style="line-height:2.5">{{__('admin.no_records_found')}}</a>
        @endif
        @endif
    </div>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror


</div>
