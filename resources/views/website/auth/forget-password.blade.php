@extends('website.app')
@section('title')
    {{__('Login')}}
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
            <div class="login-popup login-popup-center">
                <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                    <ul class="nav nav-tabs text-uppercase" role="tablist">
                        <li class="nav-item">
                            <a href="#sign-in"
                               class="nav-link active">{{__('front.forget_password')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="sign-in">
                            <form method="POST" action="{{route('user.send-code')}}" id="form_reset_password">
                                @csrf
                                @include('website.base._error')
                                <p class="text-center" style="margin-bottom: 34px">{{__('front.forget_password_title')}}</p>
                                {{-- <div class="form-group">
                                    <label>{{__('front.phone')}} *</label>
                                    <input type="tel"
                                           name="phone_number" id="phone_number" placeholder="{{__('front.phone')}}"
                                           required
                                           class="form-control px-4 @error('phone_number') is-invalid @enderror"
                                           value="+968">
                                </div> --}}

                                <div class="form-group" style="height: 73px;width:100%">
                                    <label>{{__('front.phone')}} <span style="color: red">*</span></label>
                                    <input type="tel"
                                           name="phone_number" id="phone_number" placeholder="{{__('front.phone')}}"
                                           required
                                           value="{{old('phone_number') ?? '+968'}}"
                                           class="form-control w-100 left-padding-phone px-4 @error('phone_number') is-invalid @enderror">
                                </div>

                                <button type="submit" class="btn btn-primary">{{__('front.send_code')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('custom/js/jquery.validate.min.js') }}"></script>
    <script>

let countryData = window.intlTelInputGlobals.getCountryData(),
        input = document.querySelector("#phone_number"),
        addressDropdown = document.querySelector("#address-country");

        // init plugin
        var iti = window.intlTelInput(input, {
            utilsScript: "{{asset('web/js/utils.js')}}", // just for formatting/placeholders etc
        });
        jQuery(document).ready(function () {
            let $registerForm = $('#form_reset_password');
            if ($registerForm.length) {
                $registerForm.validate({
                    rules: {
                        phone_number: {
                            required: true,
                            minlength: 5
                        },
                    },
                });
            }
        });

    </script>
@endsection
