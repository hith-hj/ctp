{{--Gird Filters--}}

<form action="{{ route('admin.'.plural($item).'.index') }}" method="GET">
	<div class="mb-7">
		<div class="row align-items-center">
			<div class="col-lg-11 col-xl-8">
				<div class="row align-items-center">
					<div class="col-md-4 my-2 my-md-0">
						<div class="input-icon">
							<input type="text" name="search" id="kt_datatable_search_search" value="{{request()->query('search')}}" class="form-control" placeholder="{{ __('admin.search') }}..." />
							<span>
								<i class="flaticon2-search-1 text-muted"></i>
							</span>
						</div>
					</div>
                    <div class="col-md-4 my-2 my-md-0">
                        <div class="d-flex align-items-center">
                            <label class="mr-3 mb-0 d-none d-md-block">{{ __('admin.status') }}:</label>
                            <select class="form-control" name="status" id="kt_datatable_search_status">
                                <option value="" {{( request()->query('status') === null ? 'selected' : '')}} > {{ __('order.all') }} </option>
                                @foreach( getStatusVariables() as $status)
                                    <option value="{{ $status->value  }}" {{($status->value == request()->query('status')  && request()->query('status') != null ? 'selected' : '')}}>
                                        {{ $status->name ?? $status->name  }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

					<div class="col-md-4 my-2 my-md-0">
						<div class="d-flex align-items-center">
							<select class="form-control" name="role" id="kt_datatable_search_role">
								<option value=""> {{ __('admin.all_roles') }} </option>
                                @foreach(getRoles() as $role)
								<option value="{{ $role->id }}" {{($role->id == request()->query('role') ? 'selected' : '')}}>
                                    {{ $role->name }}
                                </option>
                                @endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-1 mt-5 mt-lg-0">
					<a style="white-space: nowrap;"  href="{{ route('admin.'.plural($item).'.index') }}" class="btn btn-light-primary px-6 font-weight-bold">{{ __('admin.reset') }}</a>
				</div>
			</div>
		</div>
	</div>
</form>
{{--End Gird Filters--}}
