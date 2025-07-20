{{--Form Inputs--}}
    <x-text :name="'title'" :locale="$locale" :oldValue="$entity ?? null" :required="false"></x-text>
    <x-text :name="'brief'" :locale="$locale" :oldValue="$entity ?? null" :required="false"></x-text>

    @if($locale == 'en')
        <x-number :name="'sort_order'" :oldValue="$entity ?? null" :required="true"></x-number>
        <x-select-ajax-data :name="'product_id'" url="{{route('admin.productsAutoComplete')}}" 
        :locale="app()->getLocale()" 
        :displayName="'name'" 
        :oldValue="isset($entity) ? $entity->product : null"></x-select-ajax-data>
        <div class="row col-md-12">
            <div style="padding-left: 120px;" class="col-md-6">
                <x-image :name="'background_image'" :oldValue="$entity ?? null" :required="true"></x-image>
            </div>
            <div style="padding-left: 120px;" class="col-md-6">
                <x-image :name="'responsive_image'" :oldValue="$entity ?? null" :required="true"></x-image>
            </div>
        </div>
    @endif


{{--End Form Inputs--}}
