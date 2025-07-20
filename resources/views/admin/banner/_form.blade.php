{{--Form Inputs--}}
<x-text :name="'title'" :locale="$locale" :oldValue="$entity ?? null" :required="true"></x-text>
<x-text :name="'brief'" :locale="$locale" :oldValue="$entity ?? null" :required="true"></x-text>

@if($locale == 'en')
    <x-select :nullable="true" :name="'applies_to'" :locale="app()->getLocale()" displayName="id"  :multiple="false" :options="config('banner_applies_options')" :oldValue="isset($entity) ? $entity->applies_to : null" :required="true"></x-select>
    <div id="applies_to_option">
        @if(isset($entity) && isset($entity->applies_to))
            @php
                $option = getItemInArrayByColumn($entity->applies_to, config('banner_applies_options'), 'id');
            @endphp
            @if($option['isModel'])
                @if(isset($option['searchColumns']))
                    <x-select-ajax-data :name="$option['name']" displayName="{{$option['displayColumn']}}" :locale="''" url="{{route('admin.'. plural($item) .'.getModels')}}?model={{$option['model']}}&displayColumn={{$option['displayColumn']}}&searchColumns={{  urlencode(serialize($option['searchColumns']))}}"  :oldValue="isset($entity) ? $entity->applicable()->first() : null" :required="true"></x-select-ajax-data>
                @else
                    <x-select-ajax-data :name="$option['name']" displayName="{{$option['displayColumn']}}" :locale="''" url="{{route('admin.'. plural($item) .'.getModels')}}?model={{$option['model']}}&displayColumn={{$option['displayColumn']}}&searchColumn={{ $option['searchColumn']}}" :oldValue="isset($entity) ? $entity->applicable : null" :required="true"></x-select-ajax-data>
                @endif
            @endif
        @endif
    </div>

    <x-number :name="'sort_order'" decimal="false" :required="false" :required="true" :oldValue="$entity ?? null"></x-number>
    <x-image :name="'image'" :oldValue="$entity ?? null" :required="true"></x-image>
@endif


{{--End Form Inputs--}}
