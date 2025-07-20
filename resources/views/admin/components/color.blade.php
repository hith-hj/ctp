<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : 'ltr' }}">
    <label class="col-xl-2 col-lg-2 col-form-label text-center @if($required) required @endif">{{ toTitle($name) }}</label>
    <div class="col-lg-9 col-xl-9">
        <div class="input-group-append">
            <input id="hex" type="text" class="form-control form-control-lg form-control-solid @error($name.':'.$locale) is-invalid @enderror" placeholder="Enter {{ toTitle($name) }}" @if($required) required @endif name="{{ $name }}" value="{{ $oldValue ? $oldValue->{$name} : old($name) }}" />
            <input id="favColor" value="{{ $oldValue ? $oldValue->{$name} : '#7070a526' }}" type="color" style="height: 42px; width: 46px; background: #7070a526; border: 0;margin: auto;" />
        </div>
    </div>
    @error($name.':'.$locale)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>