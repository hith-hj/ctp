{{--Form Inputs--}}
    <x-text :name="'name'" :locale="$locale" :oldValue="$entity ?? null" :required="true"></x-text>

    @if($locale == 'en')
        <!--<x-text :name="'icon'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-text>-->
        <x-number :name="'sort_order'" :oldValue="$entity ?? null" :required="true"></x-number>
        <x-select :nullable="true" displayName="name" :name="'parent_category'" :locale="app()->getLocale()"
        :options="getParentsCategories($entity->id ?? null)" :oldValue="$entity->category ?? null" ></x-select>
        <x-radio :name="'is_active'" :choices="getStatusVariables()" :oldValue="$entity ?? null"></x-radio>
        <x-select-ajax-data :displayName="'name'" :name="'attributes'" url="{{route('admin.attributesAutoComplete')}}" :multiple="true" :oldValues="isset($entity) ? $entity->attributes : []"></x-select-ajax-data>
        <div class="row col-md-12">
            <div style="padding-left: 120px;" class="col-md-6">
                @if(isset($entity->image) && !is_null($entity->image))
                    <label id="deleteImageLable" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                    style="
                        position: relative;
                        top: 73px;
                        z-index: 1;
                        left: 135px;
                        cursor:pointer;
                    " onclick="deleteCategoryImage(event)">
                        <i class="fa fa-trash icon-sm text-muted"></i>
                    </label>
                @endif
                <x-image :name="'image'" :oldValue="$entity ?? null" ></x-image>
                <p id="deletedImageLable" class="text-danger "></p>
            </div>
        </div>
    @endif
    
    <script>
        function deleteCategoryImage(event)
        {
            if(confirm('Delete ?')){
                let input = document.createElement('input');
                input.type = 'hidden';
                input.id = 'delete_category_image';
                input.name = 'delete_category_image';
                input.value = '1';
                let form = $('#sheen_value_form').append(input);
            }
            $('#deleteImageLable').hide();
            $('#deletedImageLable').text('image will be deleted on submit');
        }
    </script>

{{--End Form Inputs--}}
