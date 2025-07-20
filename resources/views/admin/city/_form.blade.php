{{--Form Inputs--}}
    <x-text :name="'name'" :locale="$locale" :oldValue="$entity ?? null" :required="true"></x-text>
    @if($locale == 'en')
        <x-number :name="'sort_order'" :oldValue="$entity ?? null" :required="true"></x-number>
        <x-select displayName="name" :name="'country_id'" :locale="$locale" :required="true" :options="getCountries()" :oldValue="$entity->country ?? null"  ></x-select>
    @endif


{{--End Form Inputs--}}
