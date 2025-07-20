<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : 'ltr' }}">
    <label class="col-lg-5 col-form-label text-center @if($required) required @endif">{{ $item ? __($item.'.'.$name) : __('admin.'.$name)}}</label>
    <div class="col-lg-7">
        <div class="switch switch-primary switch-icon">
            <label>
                <input id="{{$name}}" name="{{ $name }}" {{ $oldValue && $oldValue->{$name} == 1 ? 'checked="checked"' : '' }} type="checkbox" @if($required) required @endif />
                <span></span>
            </label>
            @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>