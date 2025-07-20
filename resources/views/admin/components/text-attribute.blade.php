<div class="form-group row">
    <label class="col-xl-2 col-lg-2 col-form-label text-right">
        {{toTitle($title)}}
    </label>
    <div class="col-lg-9 col-xl-9">
    <input type="text" class="form-control form-control-lg"
           placeholder="{{__('admin.enter') .' '. toTitle($title)}}"
           name="{{ $name }}"
           value="{{ $oldValue ?? ''}}"
    />
    </div>
</div>
