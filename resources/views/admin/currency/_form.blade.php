{{--Form Inputs--}}
    <x-text :name="'name'" :locale="$locale" :oldValue="$entity ?? null" :required="true"></x-text>

    @if($locale == 'en')
        <x-text :name="'code'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-text>
        <x-text :name="'symbol'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-text>
        <x-number :name="'rate'" decimal="true" :oldValue="$entity ?? null" :required="true"></x-number>
        <x-radio :name="'is_active'" :choices="getStatusVariables()" :oldValue="$entity ?? null"></x-radio>
        <div class="row m-0 p-0">
            <div class="col-5">
                <x-switch-form :name="'use_api_rate'" :oldValue="$entity ?? null" :locale="app()->getLocale()"></x-switch-form>
            </div>
            <div class="col-5">
                <x-switch-form :name="'is_default'" :oldValue="$entity ?? null" :locale="app()->getLocale()"></x-switch-form>
            </div>
        </div>
    @endif

{{--End Form Inputs--}}
