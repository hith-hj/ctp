<div class="tinymce form-group row" dir="{{ $locale=='ar' ? 'rtl' : '' }}">
    <label class="col-xl-2 col-lg-2 col-form-label text-center @if($required) required @endif" for="kt-tinymce-{{ $locale }}">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    <br>
    <div class="col-lg-9 col-xl-9">
        <textarea class="rich  @error($name.':'.$locale) is-invalid @enderror" name="{{ $name }}:{{ $locale }}" {{ $required ? 'required' : '' }}>
        {{ $oldValue ? ($oldValue->translate($locale) && $oldValue->translate($locale)->{$valueName} ? $oldValue->translate($locale)->{$valueName}: $oldValue->{$valueName}): old($name.':'.$locale) }}
        </textarea>
    </div>
    @error($name.':'.$locale)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<br><br>