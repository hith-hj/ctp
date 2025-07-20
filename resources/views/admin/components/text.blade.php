<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : '' }}">
    <label class="col-xl-2 col-lg-2 col-form-label text-center @if($required) required @endif">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    <div class="col-lg-9 col-xl-9">
        <input type="text" class="form-control form-control-lg @error($name.':'.$locale) is-invalid @enderror" placeholder="{{__('admin.enter')}} {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name)}}" @if($required) required @endif name="{{ $name }}{{ $locale ? ':'. $locale : '' }}" id="{{$name}}" value="{{ $oldValue ? (method_exists($class, 'translate') && $oldValue->translate($locale) && $oldValue->translate($locale)->{$valueName} ? $oldValue->translate($locale)->{$valueName}: $oldValue->{$valueName}): ($locale ? old($name.':'.$locale): old($name)) }}" {{ $readonly ? 'readonly' : '' }} />
    </div>
    @error(($locale ? $name.':'.$locale: $name))
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>