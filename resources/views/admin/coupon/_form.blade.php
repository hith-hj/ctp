{{--Form Inputs--}}
<x-text :name="'name'" :locale="$locale" :oldValue="$entity ?? null" :required="true"></x-text>

    @if($locale == 'en')

        <x-text :name="'code'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-text>
        <x-number :name="'coupon_value'" decimal="true" :locale="''" :required="true"  :oldValue="$entity ?? null"></x-number>
        <x-date :name="'start_date'"  :oldValue="$entity ?? null" :required="true"></x-date>
        <x-date :name="'end_date'"  :oldValue="$entity ?? null" :required="true"></x-date>
        <x-number :name="'min_amount'" decimal="true" :locale="''" :required="true"  :oldValue="$entity ?? null"></x-number>
        <x-number :name="'max_amount'" decimal="true" :locale="''" :required="true"  :oldValue="$entity ?? null"></x-number>
    @endif
{{--End Form Inputs--}}
