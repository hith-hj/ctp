<!--begin::Advance Table Widget 3-->
<div class="card card-custom gutter-b shadow-lg mt-10">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">{{ __('currency.all_'.plural($item)) }}</span>
        </h3>
        <div class="card-toolbar">
            @can('add '.plural($item))
                <a style="margin: 6px;" href="{{ route('admin.'.plural($item).'.create') }}" class="btn btn-primary font-weight-bolder font-size-sm">
                    <i class="fas fa-plus-circle"></i>
                    {{ __('currency.new_'.$item) }}
                </a>
            @endcan
            <a style="margin: 6px;" href="{{ route('admin.'.plural($item).'.index', ['request_rates' => true]) }}" class="btn btn-primary font-weight-bolder font-size-sm">
                <i class="fas fa-dollar-sign "></i>
                {{ __('admin.request_rates') }}
            </a>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-0 pb-3">
        <!--begin::Table-->
            @include('admin.'.$item.'._gridFilter')
            <table class="table table-checkable table-head-custom table-head-bg table-borderless table-vertical-center">

                <thead>
                <tr class="text-uppercase">
                    <th style="min-width: 250px" class="pl-7">
                        <span class="text-dark-75">{{ __('currency.'.plural($item)) }}</span>
                    </th>
                    <th class="text-center" style="min-width: 100px">{{ __('currency.rate') }}</th>
                    <th class="text-center" style="min-width: 100px">{{ __('currency.code') }}</th>
                    <th class="text-center" style="min-width: 100px">{{ __('currency.symbol') }}</th>
                    <th class="text-center" style="min-width: 100px">{{ __('currency.isActive') }}</th>
                    <th class="text-center" style="min-width: 100px">{{ __('currency.is_default') }}</th>
                    <th class="text-center" style="min-width: 120px">{{ __('admin.actions') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($currencies as $key => $row)
                    <tr>
                        <td class="pl-0 py-8">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50 flex-shrink-0 mr-2">
                                    <i class="fa fa-caret-right" style="color: #F64E60;"></i>
                                </div>
                                <div>
                                    <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 ml-3 font-size-lg">{{ $row->name }}</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="{{ $row->use_api_rate == 1 ? 'text-dark-75' : 'text-success'}} text-center font-weight-bolder d-block font-size-lg">{{ $row->rate }}</span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->code }}</span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">{{ $row->symbol }}</span>
                        </td>
                        <td>
                            <span class="text-center text-dark-75 font-weight-bolder d-block font-size-lg">
                                <span class="label label-lg label-inline label-light-{{ $row->is_active ? 'success' : 'danger' }} mr-2">
                                    {{ $row->is_active ? __('admin.active') : __('admin.inactive') }}
                                </span>
                            </span>
                        </td>
                        <td>
                            <span class="text-center font-weight-bolder d-block font-size-lg">
                                <span class="label label-lg label-inline label-light-{{ $row->is_default ? 'success' : '' }} mr-2">
                                    {{ $row->is_default ? __('currency.is_default') : '-'}}
                                </span>
                            </span>
                        </td>
                        <td class="text-center pr-0">
                            @can('edit '.plural($item))
                                <a href="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@edit', ['currency' => $row]) }}" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3" data-toggle="tooltip" title="{{__('admin.edit')}}">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    {{ getSVG('assets/media/svg/icons/Communication/Write.svg') }}
                                </span>
                                </a>
                            @endcan
                            @can('delete '.plural($item))
                                <a href="javascript:void(0);" class="btn btn-icon btn-light btn-hover-primary btn-sm deleteRow" data-toggle="tooltip" title="{{ __('admin.delete') }}">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    {{ getSVG('assets/media/svg/icons/General/Trash.svg') }}
                                </span>
                                    <form method="post" action="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@destroy', ['currency' => $row]) }}">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </a>
                            @endcan
                            <a href="{{ action('App\Http\Controllers\Admin\\'.toTitle($item).'Controller@show', ['currency' => $row]) }};"
                               class="btn btn-icon btn-light btn-hover-primary btn-sm" data-toggle="tooltip"
                               title="{{ __('admin.show') }}">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    {{ getSVG('assets/media/svg/icons/Navigation/Arrow-right.svg') }}
                                </span>
                            </a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $currencies->appends(request()->query())->links() }}
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 3-->
