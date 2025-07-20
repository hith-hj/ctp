{{--Form Inputs--}}
<x-text :name="'name'" :locale="$locale" :oldValue="$entity ?? null" :required="true"></x-text>

    @if($locale == 'en')
        <div style="margin-left: 15%; margin-right: 15%;" class="table-responsive">
            <div class="col-lg-9 col-xl-9">
                <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center" style="width: 20px">
                                <label data-container="body"  title="Select all" data-toggle="popover" data-placement="top" data-content="{{ __('admin.select_permission') }}" class="checkbox checkbox-lg checkbox-single">
                                    <input type="checkbox" value="1" />
                                    <span></span>
                                </label>
                            </th>
                            <th class="text-left" style="min-width: 150px">{{ __('admin.permission') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(config('permission.permissions') as $key => $permission)
                            <tr>
                                <td class="text-center" class="pl-0">
                                    <label class="checkbox checkbox-lg checkbox-single">
                                        <input class="text-center" type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission }}"
                                            {{ isset($entity) && $entity->hasPermissionTo($permission) ? 'checked' : ''}}
                                        />
                                        <span></span>
                                    </label>
                                </td>
                                <td>
                                    {{ $permission }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
{{--End Form Inputs--}}
