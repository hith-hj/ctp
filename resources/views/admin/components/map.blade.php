<div class="form-group row">
    <label class="col-xl-2 col-lg-2 col-form-label text-right">{{ __('admin.location_on_map') }}</label>
    <div class="col-lg-9 col-xl-9">
        <input id="pac-input" style="width: 60%!important;left: 185px !important;"  class="controls form-control" type="text" placeholder="search for location">
        <div class="x_title">
            <div class="clearfix"></div>
        </div>
        <div id="map" class="gmaps" style="height: 500px; width: 82%;" ></div>
        <div id="infowindow-content">
            <span id="place-name"  class="title"></span><br>

            <span id="place-address"></span>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-2 col-lg-2 col-form-label text-right">{{ __('admin.latitude') }}</label>
    <div class="col-lg-9 col-xl-9">
        <input type="number" step="any" class="form-control"
               placeholder="latitude"
               name="latitude"
               value="{{ $latitude != null ? $latitude : old('latitude') }}"
        />
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-2 col-lg-2 col-form-label text-right">{{ __('admin.longitude') }}</label>
    <div class="col-lg-9 col-xl-9">
        <input type="number" step="any" class="form-control"
               placeholder="longitude"
               name="longitude"
               value="{{ $longitude != null ? $longitude : old('longitude') }}"
        />
    </div>
</div>
