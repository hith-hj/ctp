{{--Form Inputs--}}
    @if($locale == 'en')
        <x-text :name="'first_name'" :locale="''" :oldValue="$entity ?? null"></x-text>
        <x-text :name="'last_name'" :locale="''" :oldValue="$entity ?? null"></x-text>
        <x-email :name="'email'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-email>
        <x-password :name="'password'" :locale="''" :required="true"></x-password>
        {{-- <x-select :name="'city_id'" :locale="''" displayName="name" :multiple="false" :options="getCities()" :oldValue="isset($entity) ? $entity->city_id : null"></x-select> --}}

        <x-text :name="'phone_number'" :locale="''" :oldValue="$entity ?? null"></x-text>
        <x-text :name="'post_code'" :locale="''" :oldValue="$entity ?? null"></x-text>
        <x-radio :name="'status'" :choices="getStatusVariables()" :oldValue="$entity ?? null"></x-radio>
        <x-image :name="'avatar'" :locale="''" :oldValue="$entity ?? null"></x-image>
    @endif

{{--End Form Inputs--}}
