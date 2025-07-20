<div data-repeater-item="attribute" class="form-group row align-items-center">
    <div class="col-md-3">
        <label>{{ __('product.size') }}:</label>
        <select name="item_size" required class="form-control">
            <option value="">{{ __('product.empty') }}</option>
            @foreach($sizes as $size)
            <option id="{{$size->id}}" value="{{$size->id}}">{{$size->name}}</option>
            @endforeach
        </select>
        <div class="d-md-none mb-2"></div>
    </div>
    <div class="col-md-2">
        <label>{{ __('product.sort_order') }}:</label>
        <input required name="item_sort_order" type="number" min="0" step="any" class="form-control" />
        <div class="d-md-none mb-2"></div>
    </div>
    <div class="col-md-2">
        <label>{{ __('product.stock') }}:</label>
        <input required name="item_stock" type="number" min="0" step="any" class="form-control" />
        <div class="d-md-none mb-2"></div>
    </div>
    <div class="col-md-2">
        <label>{{ __('product.price') }}:</label>
        <input required name="item_price" type="number" min="0" step="any" class="form-control" />
        <div class="d-md-none mb-2"></div>
    </div>
    <div class="col-md-3" style="padding-top: 25px; padding-left: 25px;">
        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
            <i class="la la-trash-o"></i>{{ __('product.delete') }}</a>
        <div class="d-md-none mb-2"></div>
    </div>
</div>