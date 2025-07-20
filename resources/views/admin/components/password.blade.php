<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : '' }}">
    <label class="col-lg-2 col-form-label  text-center @if($required) required @endif">{{ __('admin.'.$name) }}</label>
    <div class="col-lg-9 col-xl-9">
        <input type="password" class="form-control @error($name) is-invalid @enderror" placeholder="{{ __('admin.enter') }} {{ __('admin.'.$name) }}" name="{{ $name }}" value="{{ $oldValue ?? '' }}" />
    </div>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : '' }}">
    <label class="col-lg-2 col-form-label text-center @if($required) required @endif">
        {{ __('admin.confirm') }} {{ __('admin.'.$name) }}
    </label>
    <div class="col-lg-9 col-xl-9">
        <input type="password" class="form-control" placeholder="{{ __('admin.enter')}} {{ __('admin.confirm')}} {{ __('admin.'.$name) }}" name="{{ $name }}_confirmation" />
    </div>
</div>