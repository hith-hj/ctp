<div class="card card-custom shadow-lg mt-10">
    <!--begin::Form-->
    <form action="{{ $action ?? '#' }}" 
    method="POST" id="sheen_value_form" 
    enctype="multipart/form-data" 
    dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
        @csrf
        <div class="card-body">
            <ul class="nav nav-tabs float-right" id="myTab" role="tablist">
                @if($onelanguage)
                <li class="nav-item">
                    <a class="btn btn-icon btn-light-success active pulse pulse-success" id="en-tab-1" data-toggle="tab" href="#section_en">
                        <span class="nav-text">en</span>
                        <span class="pulse-ring"></span>
                    </a>
                </li>
                @else
                @foreach(config('translatable.locales') as $key => $locale)
                <li class="nav-item">
                    <a class="btn btn-icon btn-light-success {{ $key==0 ? 'active' : '' }} pulse pulse-success" id="{{$locale}}-tab-1" data-toggle="tab" href="#section_{{$locale}}">
                        <span class="nav-text">{{ $locale }}</span>
                        <span class="pulse-ring"></span>
                    </a>
                </li>
                @endforeach
                @endif
            </ul>
            <div class="tab-content mt-20" id="myTabContent">
                @foreach(config('translatable.locales') as $key => $locale)
                <div id="section_{{$locale}}" class="tab-pane fade {{ $key==0 ? 'show active' : '' }}" role="tabpanel" aria-labelledby="{{$locale}}-tab-1">
                    @include('admin.'.$item.'._form')
                </div>
                @endforeach
                {{ $slot }}

                @if(isset($entity))
                @method('PUT')
                @endif
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2">{{ $submit == 'PUT' ? __('admin.update') : __('admin.save') }}</button>
            <button type="submit" class="btn btn-secondary" name="add-new">{{ $submit == 'PUT' ? __('admin.update_and_stay') : __('admin.save_and_new') }} </button>
        </div>
    </form>
    <!--end::Form-->
</div>