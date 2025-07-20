<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : '' }}">
    <label class="col-lg-2 col-form-label text-center @if($required) required @endif">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    <div class="col-lg-9 col-xl-9">
        <input type="email" class="form-control @error($name.':'.$locale) is-invalid @enderror" placeholder="{{ __('admin.enter') }} {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name)}}" name="{{ $name }}" value="{{ $oldValue ? $oldValue->{$name} : old($name) }}" />
    </div>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>