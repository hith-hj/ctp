{{--Gird Filters--}}

<form action="{{ route('admin.'.plural($item).'.index') }}" method="GET">
	<div class="mb-7">
		<div class="row align-items-center">
			<div class="col-lg-9 col-xl-8">
				<div class="row align-items-center">
					<div class="col-md-4 my-2 my-md-0">
						<div class="input-icon">
							<input type="text" name="search" value="{{request()->query('search')}}" class="form-control" placeholder="{{ __('admin.search') }}..." id="search" />
							<span>
								<i class="flaticon2-search-1 text-muted"></i>
							</span>
						</div>
					</div>
					<div class="col-md-4 my-2 my-md-0">
						<div class="d-flex align-items-center">
							<select class="form-control" name="status" id="status">
								<option value="" {{( request()->query('status') === null ? 'selected' : '')}}> {{ __('admin.all_statuses') }} </option>
								@foreach( getStatusVariables() as $status)
									<option value="{{ $status->value  }}" {{($status->value == request()->query('status') && request()->query('status') != null ? 'selected' : '')}}>
										{{ $status->name ?? $status->name  }}
									</option>
                                @endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 mt-5 mt-lg-0">
					<button class="btn btn-light-primary px-6 font-weight-bold" type="submit">
						<span>
							<span>{{ __('admin.search') }}</span>
						</span>
					</button>
				</div>
				<div class="col-lg-6 mt-5 mt-lg-0">
					<a style="white-space: nowrap;" href="{{ route('admin.'.plural($item).'.index') }}" class="btn btn-light-primary px-6 font-weight-bold">{{ __('admin.reset') }}</a>
				</div>
			</div>
		</div>
	</div>
</form>
{{--End Gird Filters--}}
