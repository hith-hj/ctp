{{--Form Inputs--}}
<x-text :name="'title'" :locale="$locale" :oldValue="$entity ?? null" :required="$locale == 'en' ? true : false"></x-text>
<x-text_area :name="'message'" :locale="$locale" :oldValue="$entity ?? null" :required="$locale == 'en' ? true : false"></x-text_area>

    @if($locale == 'en')

        <x-checkbox :name="'send_to_all_users'" :choices="[ newStd(['name' => 'checked', 'value' => '1']) ]"></x-checkbox>
        <x-select-ajax-data :name="'user_id'" url="{{route('admin.usersAutoComplete')}}" :oldValue="isset($entity) ? $entity->user : null"></x-select-ajax-data>
        <x-image-dropify  :name="'image'" :required="false" :oldValue="$entity ?? null"></x-image-dropify>
    @endif



{{--End Form Inputs--}}
