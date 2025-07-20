{{--Form Inputs--}}
<x-text :name="'name'" :required="false" :locale="$locale" :oldValue="$entity ?? null" :required="true"></x-text>
<!--<x-text-area :name="'description'" :locale="$locale" :oldValue="$entity ?? null"></x-rich-text-box>-->

@if($locale == 'en')
    <!--<x-text :name="'sku'" :required="false"  :locale="''" :required="true" :oldValue="$entity ?? null"></x-text>-->
    <x-number :name="'price'" decimal="true" :locale="''" :required="true"  :oldValue="$entity ?? null"></x-number>
    <x-number :name="'capital_price'" decimal="true" :locale="''" :required="true"  :oldValue="$entity ?? null"></x-number>
    <x-number :name="'price_before_discount'" decimal="true" :locale="''" :required="true"  :oldValue="$entity ?? null"></x-number>
    <x-number :name="'sort_order'" decimal="false" :required="false" :required="true" :oldValue="$entity ?? null"></x-number>
    <x-number :name="'quantity'" decimal="false" :required="false" :oldValue="$entity ?? null"></x-number>
    <x-select :nullable="true" displayName="name" :name="'category'" :locale="app()->getLocale()" :required="true" :options="getSubCategories()" :oldValue="$entity->category ?? null"  ></x-select>
    <x-radio :name="'status'" :choices="getStatusVariables()" :oldValue="$entity ?? null" ></x-radio>
    <div class="col-md-12 row">
        <div class="col-6">
            <x-image-dropify :name="'images'" :required="true" :multiple="true" :oldValue="$entity ?? null"></x-image-dropify>
        </div>
        <div class="col-6">
            <x-image-dropify :name="'featured_image'" :required="true" :oldValue="$entity ?? null"></x-image-dropify>
        </div>
    </div>
    <x-slot name="richTextBoxScript"></x-slot>
    <x-slot name="colorScript"></x-slot>
@endif
    
<x-rich-text-box :name="'description'" :locale="$locale" :oldValue="$entity ?? null"></x-rich-text-box>
{{--End Form Inputs--}}
