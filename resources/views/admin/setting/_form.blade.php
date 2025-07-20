{{--Form Inputs--}}
    <x-slot name="richTextBoxScript"></x-slot>

    @if(isset($entity))
        @if($locale == 'en')
            @if(!isset($custom))
            <x-text :name="'key'" :readonly="true" :locale="''" :oldValue="$entity->key ? $entity : '' " :required="true"></x-text>
            <div class="form-group row mb-16 mt-16">
                <div class="col-xl-2 col-lg-2 col-form-label text-right">
                    <label>{{__($item.'.select_type')}}</label>
                </div>
                <div class="col-lg-9 col-xl-9">
                    <div class="radio-inline col-lg-9 col-xl-9">
                        <label class="radio">
                            <input type="radio" {{ $entity->type == 'text' ? 'checked' : '' }} value="text" name="type"/> {{__($item.'.text')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" {{ $entity->type == 'text_area' ? 'checked' : '' }} value="text_area" name="type"/> {{__($item.'.textarea')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" {{ $entity->type == 'rich_text_box' ? 'checked' : '' }} value="rich_text_box" name="type"/> {{__($item.'.text_editor')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" {{ $entity->type == 'number' ? 'checked' : '' }} value="number" name="type"/> {{__($item.'.number')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" {{ $entity->type == 'image' ? 'checked' : '' }} value="image" name="type"/> {{__($item.'.image')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" {{ $entity->type == 'album' ? 'checked' : '' }} value="album" name="type"/> {{__($item.'.album')}}
                            <span></span>
                        </label><label class="radio">
                            <input type="radio" {{ $entity->type == 'checkbox' ? 'checked' : '' }} value="checkbox" name="type"/> {{__($item.'.checkbox')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" {{ $entity->type == 'select' ? 'checked' : '' }} value="select" name="type"/> {{__($item.'.select')}}
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
            @else
                <input type="hidden" name="key" value="{{$entity->key}}">
                <input type="hidden" name="type" value="{{$entity->type}}">
            @endif
            <div style="{{ $entity->type != 'number' ? 'display: none' : '' }}" class="settings_number">
                <x-number :name="'number'" decimal="true"  :oldValue="$entity->number ?? ''"></x-number>
            </div>
            <div style="{{ $entity->type != 'image' ? 'display: none' : '' }}" class="settings_image">
                <x-image-dropify :name="'image'"  :oldValue="$entity->image ?? ''"></x-image-dropify>
            </div>
            <div style="{{ $entity->type != 'album' ? 'display: none' : '' }}" class="settings_album">
                <x-image-dropify :name="'album'" :oldValue="$entity->album ?? ''" :multiple="true"></x-image-dropify>
            </div>
            <div style="{{ $entity->type != 'checkbox' ? 'display: none' : '' }}" class="settings_checkbox">
                <x-checkbox :choices="[ newStd(['name' => 'checked', 'value' => '1']) ]"  :name="'checkbox'" :oldValue="$entity->checkbox ?? null"></x-checkbox>
            </div>
            <div style="{{ $entity->type != 'select' ? 'display: none' : '' }}" class="settings_select">
                <x-select :name="'select'" :oldValue="$entity->select ?? ''"></x-select>
            </div>
        @endif
            <div style="{{ $entity->type != 'text' ? 'display: none' : '' }}" class="settings_text">
                <x-text :name="'text'" :locale="$locale" :valueName="'value'" :oldValue="$entity->text ?? '' "></x-text>
            </div>
            <div style="{{ $entity->type != 'text_area' ? 'display: none' : '' }}" class="settings_text_area">
                <x-text_area :name="'text_area'" :locale="$locale" :valueName="'value'" :oldValue="$entity->textArea ?? '' "></x-text_area>
            </div>
            <div style="{{ $entity->type != 'rich_text_box' ? 'display: none' : '' }}" class="settings_rich_text_box">
                <x-rich_text_box :name="'rich_text_box'" :locale="$locale" :valueName="'value'" :oldValue="$entity->richTextBox ?? '' "></x-rich_text_box>
            </div>
    @else
        @if($locale == 'en')
            <x-text :name="'key'" :required="true" :locale="''"></x-text>
            <div class="form-group row mb-16">
                <div class="col-xl-2 col-lg-2 col-form-label text-right">
                    <label>{{__($item.'.select_type')}}</label>
                </div>
                <div class="col-lg-9 col-xl-9">
                    <div class="radio-inline">
                        <label class="radio">
                            <input type="radio" value="text" name="type"/> {{__($item.'.text')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" value="text_area" name="type"/> {{__($item.'.textarea')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" value="rich_text_box" name="type"/> {{__($item.'.text_editor')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" value="number" name="type"/> {{__($item.'.number')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" value="image" name="type"/> {{__($item.'.image')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" value="album" name="type"/> {{__($item.'.album')}}
                            <span></span>
                        </label><label class="radio">
                            <input type="radio" value="checkbox" name="type"/> {{__($item.'.checkbox')}}
                            <span></span>
                        </label>
                        <label class="radio">
                            <input type="radio" value="select" name="type"/> {{__($item.'.select')}}
                            <span></span>
                        </label>

                    </div>
                </div>
            </div>
            <div style="display: none" class="settings_number">
                <x-number :name="'number'"></x-number>
            </div>
            <div style="display: none" class="settings_image">
                <x-image-dropify :name="'image'"></x-image-dropify>
            </div>
            <div style="display: none" class="settings_album">
                <x-image-dropify :name="'album'" :multiple="'true'"></x-image-dropify>
            </div>
            <div style="display: none" class="settings_checkbox">
                <x-checkbox :choices="[ newStd(['name' => 'checked', 'value' => '1']) ]"  :name="'checkbox'"></x-checkbox>
            </div>
            <div style="display: none" class="settings_select">
                <x-select :name="'select'"></x-select>
            </div>
        @endif
        <div style="display: none" class="settings_text">
            <x-text :name="'text'" :locale="$locale"></x-text>
        </div>
        <div style="display: none" class="settings_text_area">
            <x-text_area :name="'text_area'" :locale="$locale"></x-text_area>
        </div>
        <div style="display: none" class="settings_rich_text_box">
            <x-rich_text_box :name="'rich_text_box'" :locale="$locale"></x-rich_text_box>
        </div>
    @endif
{{--End Form Inputs--}}
