<div class="form-group row">
    <label class="col-xl-2 col-lg-2 col-form-label text-center">{{ toTitle($title) }}</label>
    <div class="col-lg-9 col-xl-9">
        <div class="input-group-append">
            <input id="hex" type="text" class="form-control form-control-lg form-control-solid" placeholder="Enter {{ toTitle($title) }}" name="{{ $name }}" value="{{ $oldValue ?? '' }}" />
            <input id="favColor" value="{{ $oldValue ? $oldValue : '#7070a526' }}" type="color" style="height: 42px; width: 46px; background: #7070a526; border: 0;margin: auto;" />
        </div>
    </div>
</div>