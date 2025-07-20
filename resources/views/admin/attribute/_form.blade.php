{{--Form Inputs--}}
    <x-text :name="'name'" :locale="$locale" :oldValue="$entity ?? null" :required="true"></x-text>

    @if($locale == 'en')
        <x-radio :name="'type'" :choices="getTypesVariables()" :oldValue="$entity ?? null" ></x-radio>
        <x-switch-form :name="'use_as_filter'" :oldValue="$entity ?? null"></x-switch-form>
    @endif

{{--End Form Inputs--}}
