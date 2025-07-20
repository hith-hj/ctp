@extends('front.app')
@section('title')
    {{__('verification')}}
@endsection
@section('content')
    <!-- Start of Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0">{{__('front.my_account')}}</h1>
        </div>
    </div>
    <!-- End of Page Header -->
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('user.index')}}">{{__('front.home')}}</a></li>
                <li>{{__('front.my_account')}}</li>
            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->
    <div class="page-content">
        <div class="container">
            <div class="login-popup login-popup-center d-flex justify-content-center">
                <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                    <ul class="nav nav-tabs text-uppercase" role="tablist">
                        <li class="nav-item">
                            <a href="#sign-in" class="nav-link active">{{__('front.reset_password')}}</a>
                        </li>
                    </ul>
                    <div class="tab-pane active" id="sign-in">
                        <form method="POST" action="{{route('user.reset-password')}}" id="form_password">
                            @csrf
                            @include('front.base._error')

                            <p class="text-center" style="margin-bottom: 34px">{{__('front.new_password')}}</p>
                            <span style="color: rgb(0, 157, 255); "><b><bdi>{{session()->get('user')->phone_number ?session()->get('user')->phone_number:$user->phone_number}}</bdi> </b></span>
                            <div class="d-flex justify-content-center mt-5 verficatiominput" style="direction: ltr;">
                                <input class="form-control" name="reset_token[]" type="text"  id="txt1" maxLength="1" size="1" min="0" max="9"  onkeyup="moveCursor(this,'txt2')" required="required"/>
                                <input class="form-control" name="reset_token[]" type="text" id="txt2" maxLength="1" size="1" min="0" max="9"  onkeyup="moveCursor(this,'txt3')" required="required"/>
                                <input class="form-control" name="reset_token[]" type="text" id="txt3" maxLength="1" size="1" min="0" max="9" onkeyup="moveCursor(this,'txt4')" required="required"/>
                                <input class="form-control" name="reset_token[]" type="text" id="txt4" maxLength="1" size="1" min="0" max="9" onkeyup="moveCursor(this,'txt5')" required="required"/>
                                <input class="form-control" name="reset_token[]" type="text" id="txt5" maxLength="1" size="1" min="0" max="9" onkeyup="moveCursor(this,'txt6')" required="required"/>
                                <input class="form-control" name="reset_token[]" type="text" id="txt6" maxLength="1" size="1" min="0" max="9" required="required"/>
                            </div>
                            <div class="form-group">
                                <label>{{__('front.password')}} *</label>
                                <input type="password"
                                       name="password" id="password" placeholder="{{__('front.password')}}"
                                       required
                                       class="form-control px-4 @error('password') is-invalid @enderror"
                                >
                            </div>
                            <div class="form-group">
                                <label>{{__('front.password_confirm')}} *</label>
                                <input type="password"
                                       name="password_confirmation" id="password_confirmation" placeholder="{{__('front.password_confirm')}}"
                                       required
                                       class="form-control px-4 @error('password_confirm') is-invalid @enderror"
                                       >
                            </div>
                            <input hidden name="phone_number"
                                   value="{{session()->get('user')->phone_number ?session()->get('user')->phone_number:$user->phone_number}}"
                            >
                            <div class="text-center mt-5 ">
                                <button type="submit"
                                        class="btn btn-primary mx-auto">{{__('front.change_password')}}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('custom/js/jquery.validate.min.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            let $registerForm = $('#form_password');
            if ($registerForm.length) {
                $registerForm.validate({
                    rules: {
                        'reset_token[]': {
                            required: true,
                        },
                        password: {
                            required: true,
                            minlength: 8
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 8,
                            equalTo: "#password"
                        },
                    },
                });
            }
        });

    </script>
@endsection

