{{--Form Inputs--}}
@if($locale == 'en')

        <x-text :name="'name'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-text>
        <x-text :name="'username'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-text>
        <x-email :name="'email'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-email>
        <x-password :name="'password'" :locale="''" :required="true"></x-password>
        {{-- {{dd($entity->roles(),$entity->roles()->first());}} --}}
        @can('edit roles')
            <x-select :name="'role'" :locale="''" displayName="name" :multiple="false" :options="\Spatie\Permission\Models\Role::get()" :oldValue="!is_null($entity->roles()->first()) ? $entity->roles()->first()->id : null"></x-select>
        @endcan
        <x-radio :name="'status'" :choices="getStatusVariables()" :oldValue="$entity ?? null"></x-radio>
        <x-image :name="'avatar'" :locale="''" :oldValue="$entity ?? null"></x-image>
    @endif
{{--End Form Inputs--}}
