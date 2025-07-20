<div class="form-group row">
    <label class="col-lg-2 col-form-label text-right" for="{{ $name }}">
        {{toTitle($title)}}
    </label>
    <div class="col-lg-9 col-xl-9">
    <input class="form-control form-control-lg form-control-solid"
           placeholder="{{__('admin.enter') .' '. toTitle($title)}}"
           name="{{ $name }}" type="number"
           value="{{ $oldValue ?? '' }}"
           id="{{ $name }}"
           @if($decimal)  step="any" @endif/>
    </div>
</div>
