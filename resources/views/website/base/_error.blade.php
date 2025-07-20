@if ($errors->any())
{{--    <div class="font-medium text-danger text-center" style="color:#BD362F;!important">--}}
{{--        {{ __('Whoops! Something went wrong.') }}--}}
{{--    </div>--}}
    <ul class="mt-3  list-inside text-center text-sm text-red-600" style="list-style: none">
        @foreach ($errors->all() as $error)
            <li style="color:#BD362F;!important" class="text-danger">{{ $error }}</li>
        @endforeach
    </ul>
{{--    </div>--}}
@endif
@if(Session::has('error'))
    <div class="alert alert-danger">
        <li style="color:#BD362F;!important" class="text-danger">    {{ Session::get('error')}}</li>
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success">
        <li class="text-success">{{ Session::get('success')}}</li>
    </div>
@endif
