<div class="form-group row mb-5">
    <label class="col-xl-2 col-lg-2 col-form-label text-center">
        {{toTitle($title)}}
    </label>
    <div class="col-lg-9 col-xl-9">
        <div class="checkbox-inline">
            @foreach($choices as $choice)
            <label class="checkbox checkbox-square checkbox-light-success">
                <input name="{{ $name }}" {{ $oldValue ? ($oldValue == 1 ? 'checked' : '') :'' }} type="checkbox" value="{{ $choice->value }}" /> {{ __('admin.'.$choice->name) }}
                <span></span>
            </label>
            @endforeach
        </div>
    </div>
</div>