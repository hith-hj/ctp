<!--begin::Advance Table Widget 3-->
<div class="card card-custom gutter-b shadow-lg mt-10">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">{{__('admin.all_settings')}}</span>
        </h3>
        @can('add '.plural($item))
            <div class="card-toolbar">
                <a href="{{ route('admin.'.plural($item).'.create') }}"
                   class="btn btn-primary font-weight-bolder font-size-sm">
                    <i class="fas fa-plus-circle"></i>{{ __('admin.new_'.$item) }}
                </a>
            </div>
        @endcan
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-0 pb-3">
        <!--begin::Table-->
        <div class="table-responsive">
            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                <thead>
                <tr class="text-uppercase">
                    <th style="min-width: 150px" class="pl-7">
                        <span class="text-dark-75">{{__('admin.settings')}}</span>
                    </th>
                    <th class="text-center" style="min-width: 100px">{{__($item.'.key')}}</th>
                    <th class="text-center" style="min-width: 100px">{{__($item.'.type')}}</th>
                    <th class="text-center" style="min-width: 120px">{{ __('admin.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($settings as $key => $setting)
                    <tr>
                        <td class="pl-0 py-8">
                            <div class="d-flex align-items-center">
                                <div>
                                    <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 ml-3 font-size-lg">{{ $setting->id }}</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $setting->key }}</span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ toTitle($setting->type) }}</span>
                        </td>
                        <td class="text-center pr-0">
                            @can('edit '.plural($item))
                                <a href="{{ action('App\Http\Controllers\Admin\SettingController@edit', ['setting' => $setting]) }}" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3" data-toggle="tooltip" title="Edit">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    {{ getSVG('assets/media/svg/icons/Communication/Write.svg') }}
                                </span>
                                </a>
                            @endcan
                            @can('delete '.plural($item))
                                <a href="javascript:void(0);" class="btn btn-icon btn-light btn-hover-primary btn-sm deleteRow" data-toggle="tooltip" title="Delete">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    {{ getSVG('assets/media/svg/icons/General/Trash.svg') }}
                                </span>
                                    <form method="post" action="{{ action('App\Http\Controllers\Admin\SettingController@destroy', ['setting' => $setting]) }}">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </a>
                            @endcan
{{--                            <a href="javascript:void(0);" class="btn btn-icon btn-light btn-hover-primary btn-sm" data-toggle="tooltip" title="Show">--}}
{{--                                <span class="svg-icon svg-icon-md svg-icon-primary">--}}
{{--                                {{ getSVG('assets/media/svg/icons/Navigation/Arrow-right.svg') }}--}}
{{--                                </span>--}}
{{--                            </a>--}}

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 3-->
