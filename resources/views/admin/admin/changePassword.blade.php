<x-master title="{{ __('admin.'.plural($item)) }}">
  <x-breadcrumb :item="$item"></x-breadcrumb>
  <div class="d-flex flex-column">
      <div class="container">
          <div class="rowx">
              <div class="col-xl-12">
                @include('admin.layouts.panels._alerts')
                <form action="{{route('admin.changePassword')}}" method="POST">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                  @csrf
                  <div class="card p-1">
                    <div class="card-heder m-2 p-2">
                        <h3 class="text-lg {{app()->getLocale() == 'ar' ? 'text-right' : 'text-left'}}">{{__('admin.changePassword')}}</h3>
                    </div>
                    <div class="card-body d-flex justify-content-around p-2 {{app()->getLocale() == 'ar' ? 'text-right' : 'text-left'}}">
                        <div class="w-50 mx-1">
                            <label>{{__('admin.oldPassword')}}</label>
                            <input type="password" name="old_password" class="form-control" placeholder="{{__('admin.oldPassword')}}" required>
                            @error('old_password')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="w-50 mx-1">
                            <label>{{__('admin.password')}}</label>
                            <input type="password" name="password" class="form-control" placeholder="{{__('admin.password')}}" required>
                            @error('password')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>                     
                        <div class="w-50 mx-1">
                            <label>{{__('admin.password_confirm')}}</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{__('admin.password_confirm')}}" required>
                        </div>                     
                        <div class="w-25 mx-1">
                            <label>{{__('admin.save')}}</label>
                            <br>
                            <button class="btn btn-success w-100" type="submit">
                              <i class="fa fa-check"></i> 
                              {{__('admin.save')}}
                            </button>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
          </div>
      </div>
  </div>

  <x-slot name="footer"></x-slot>
</x-master>
