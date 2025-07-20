{{--Gird Filters--}}
<form action="{{ route('admin.'.plural($item).'.'.$methodName.'Index') }}" method="GET">
    <div class="mb-7">
        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="align-items-center">
                    <label class="col-form-label text-center p-0">{{__($item.'.from_date')}}</label>
                    <div class="col-md-12 p-0">
                        <input class="form-control form-control-lg form-control-solid"
                               name="from_date"
                               value="{{request()->query('from_date')}}"
                               type="date" id="example-date-input"/>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="align-items-center">
                    <label class="col-form-label text-center p-0">{{__($item.'.to_date')}}</label>
                    <div class="col-md-12 p-0">
                        <input class="form-control form-control-lg form-control-solid"
                               name="to_date"
                               value="{{request()->query('to_date')}}"
                               type="date" id="example-date-input"/>
                    </div>
                </div>
            </div>
            <!--<div class="col-md-2">-->
            <!--    <div class="align-items-center">-->
            <!--        <label class="col-form-label text-center p-0">{{__($item.'.filters')}}</label>-->
            <!--        <div class="col-md-12 p-0">-->
            <!--            <select name="filters" class="form-control form-control-lg ">-->
            <!--                <option value="msi">Most sold item</option>-->
            <!--                <option value="lsi">Least sold item</option>-->
            <!--            </select>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="col-md-3 row">
                <div class="col-6 mt-5">
                    <button class="btn btn-light-primary font-weight-bold w-100" type="submit">
						{{ __('admin.search') }}
                    </button>
                </div>
                <div class="col-6 mt-5">
                    <a href="{{ route('admin.'.plural($item).'.'.$methodName.'Index') }}" 
                        class="btn btn-light-primary font-weight-bold w-100">
                        {{ __('admin.reset') }}
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group m-0 mt-5">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="btn btn-light font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="flaticon-download-1 text-danger"></i> {{ __('report.reports') }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-md py-5">
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a class="navi-link" href="{{ route('admin.'.plural($item).'.'.'generatePDF', ['methodName' => $methodName, 'from_date' => request()->query('from_date'), 'to_date' =>  request()->query('to_date')]) }}">
                                                <span class="navi-icon"><i class="flaticon2-image-file text-primary"></i></span>
                                                <span class="navi-text">PDF</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a class="navi-link" href="{{ route('admin.'.plural($item).'.'.'exportCSV', ['methodName' => $methodName, 'from_date' => request()->query('from_date'), 'to_date' =>  request()->query('to_date')]) }}">
                                                <span class="navi-icon"><i class="flaticon2-file text-success"></i></span>
                                                <span class="navi-text">CSV</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
