<div class="form-group row">
    <label class="col-xl-2 col-lg-2 col-form-label text-right">{{ toTitle($title) }}</label>
    <div class="col-col-lg-9 col-xl-9 col-9">
        <div class="switch switch-primary switch-icon">
            <label>
                <input name="{{ $name }}" {{ $oldValue && ($oldValue == 1 || $oldValue == 'yes') ? 'checked="checked"' : '' }} type="checkbox"/>
                <span></span>
            </label>
        </div>
    </div>
</div>
