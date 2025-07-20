<div class="form-group row mb-5">
    <label class="col-xl-2 col-lg-2 col-form-label text-center @if($required) required @endif">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    <div class="col-lg-9 col-xl-9">
        <div class="checkbox-inline">
            @foreach($choices as $choice)
            <label class="checkbox checkbox-square checkbox-light-success">
                <input name="{{ $name }}" {{ $oldValue ? ($oldValue->{$name} == 1 ? 'checked' : '') :'' }} type="checkbox" value="{{ $choice->value }}" @if($required) required @endif /> {{ __('admin.'.$choice->name) }}
                <span></span>
            </label>
            @endforeach
            @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>