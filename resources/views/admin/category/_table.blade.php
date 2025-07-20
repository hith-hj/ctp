<!--begin::Advance Table Widget 3-->
<div class="card card-custom gutter-b shadow-lg mt-10">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">{{ __('admin.all_'.plural($item)) }}</span>
        </h3>
        <div class="card-toolbar">
            @can('add '.plural($item))
                <div class="col-lg-6 mt-5 mt-lg-0">
                <a style="white-space: nowrap;" href="{{ route('admin.'.plural($item).'.create') }}"
                    class="btn btn-primary font-weight-bolder font-size-sm">
                    <i class="fas fa-plus-circle"></i>
                    {{ __('admin.new_'.$item) }}
                </a>
                </div>
            @endcan
            <div class="col-lg-6 mt-5 mt-lg-0">
                <button style="white-space: nowrap;font-weight: 600 !important;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#TreeModal">
                    {{ __('category.view_tree') }}
                </button>
            </div>
        </div>

    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-0 pb-3">
        <!--begin::Table-->
            <table class="table table-checkable table-head-custom table-head-bg table-borderless table-vertical-center">
                <thead>
                    <tr class="text-uppercase">
                        <th style="min-width: 200px" class="pl-7">
                            <span class="text-center-dark-75">{{ __('admin.'.plural($item)) }}</span>
                        </th>
                        <th class="text-center" style="min-width: 100px">{{ __('admin.sort_order') }}</th>
                        <th  class="text-center" style="min-width: 100px">{{ __('admin.status') }}</th>
                        <th  class="text-center" style="min-width: 100px">{{ __('admin.type') }}</th>
                        <th class="text-center" style="min-width: 120px">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin.'.$item.'._gridFilter')
                    @foreach($categories as $key => $row)
                    <tr>
                        <td class="pl-0 py-8">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50 flex-shrink-0 mr-2">
                                    <i class="fa fa-caret-down" id="show_{{$row->id}}" style="color: #F64E60;padding-right: 5px;font-size: 1.6rem;">
                                    </i>
                                </div>
                                <div class="symbol symbol-50 flex-shrink-0 mr-2">
                                    @if(!is_null($row->image))
                                        <div class="symbol-label"
                                            style="background-image: url({{ storageImage($row->image) }})">
                                        </div>
                                    @else
                                    <!--    <div class="symbol-label"-->
                                    <!--        style="background-image: url({{asset('web/images/no-image.jpg')}})">-->
                                    <!--    </div>-->
                                    @endif
                                </div>
                                <div>
                                    <a href="#"
                                        class="text-dark-75 font-weight-bolder text-hover-primary mb-1 ml-3 font-size-lg">{{ $row->translate()->name }}</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->sort_order }}</span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg"><span
                                    class="label label-lg label-inline label-light-{{ $row->is_active ? 'success' : 'danger' }} mr-2">{{ $row->is_active ? __('admin.active') : __('admin.inactive') }}</span></span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->type }}</span>
                        </td>
                        <td class="text-center pr-0">
                            @can('edit '.plural($item))
                                <a href="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@edit', ['category' => $row]) }}"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3" data-toggle="tooltip"
                                    title="{{__('admin.edit')}}">
                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                        {{ getSVG('assets/media/svg/icons/Communication/Write.svg') }}
                                    </span>
                                </a>
                            @endcan
                            @can('delete '.plural($item))
                                <a href="javascript:void(0);"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm deleteRow" data-toggle="tooltip"
                                    title="{{ __('admin.delete') }}">
                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                        {{ getSVG('assets/media/svg/icons/General/Trash.svg') }}
                                    </span>
                                    <form method="post"
                                        action="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@destroy', ['category' => $row]) }}">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </a>
                            @endcan
                            <a href="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@show', ['category' => $row]) }}"
                                class="btn btn-icon btn-light btn-hover-primary btn-sm" data-toggle="tooltip"
                                title="{{ __('admin.show') }}">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    {{ getSVG('assets/media/svg/icons/Navigation/Arrow-right.svg') }}
                                </span>
                            </a>

                        </td>
                    </tr>
                    @if (request()->query('search')==null && request()->query('status')==null)
                        <tr style="background: #F9F9F9">
                            <td colspan="5">
                                <div id="extra_{{$row->id}}" style="display: none;">
                                    <div style="padding: 16px 30px;">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-uppercase">
                                                    <th class="{{app()->getLocale() == 'ar' ? 'text-right':'pl-7'}}">
                                                        <span class="text-dark-75">{{ __('admin.sub_categories') }}</span>
                                                    </th>
                                                    <th>{{ __('admin.sort_order') }}</th>
                                                    <th>{{ __('admin.status') }}</th>
                                                    <th>{{ __('admin.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($row->parentCategory()->get() as $key => $value)
                                                    <tr>
                                                        <td style="border-bottom: 1px solid #ECF0F3;" class="pl-0 py-8">
                                                            <div class="d-flex align-items-center">
                                                                @if(!is_null($value->image))
                                                                <div class="symbol symbol-50 flex-shrink-0 mr-2">
                                                                    <div class="symbol-label"
                                                                        style="background-image: url({{ storageImage($value->image) }})">
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div>
                                                                    <a href="#"
                                                                        class="text-dark-75 font-weight-bolder text-hover-primary mb-1 mx-2 font-size-lg">{{ $value->translate()->name }}</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border-bottom: 1px solid #ECF0F3;">
                                                            <span
                                                                class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $value->sort_order }}</span>
                                                        </td>
                                                        <td style="border-bottom: 1px solid #ECF0F3;">
                                                            <span
                                                                class="text-dark-75 font-weight-bolder d-block font-size-lg"><span
                                                                    class="label label-lg label-inline label-light-{{ $value->is_active ? 'success' : 'danger' }} mr-2">{{ $value->is_active ? __('admin.active') : __('admin.inactive') }}</span></span>
                                                        </td>
                                                        <td style="border-bottom: 1px solid #ECF0F3;" class="text-left pr-0">
                                                            <a href="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@edit', ['category' => $value]) }}"
                                                                class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3"
                                                                data-toggle="tooltip" title="{{__('admin.edit')}}">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    {{ getSVG('assets/media/svg/icons/Communication/Write.svg') }}
                                                                </span>
                                                            </a>
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-icon btn-light btn-hover-primary btn-sm deleteRow"
                                                                data-toggle="tooltip" title="{{ __('admin.delete') }}">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    {{ getSVG('assets/media/svg/icons/General/Trash.svg') }}
                                                                </span>
                                                                <form method="post"
                                                                    action="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@destroy', ['category' => $value]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                </form>
                                                            </a>
                                                            <a href="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@show', ['category' => $value]) }}"
                                                                class="btn btn-icon btn-light btn-hover-primary btn-sm"
                                                                data-toggle="tooltip" title="{{ __('admin.show') }}">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    {{ getSVG('assets/media/svg/icons/Navigation/Arrow-right.svg') }}
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            {{ $categories->appends(request()->query())->links() }}
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 3-->
