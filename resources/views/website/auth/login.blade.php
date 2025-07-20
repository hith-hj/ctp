<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('front.sign_in')}}</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{asset('web/auth/fonts/material-icon/css/material-design-iconic-font.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Main css -->
    <link rel="stylesheet" href="{{asset('web/auth/css/style.css')}}">
    <link href="{{asset('icons/icon.png')}}" rel="icon">

</head>
<body>

<div class="main" style="padding:40px 0;">
    <!-- Sing in  Form -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content py-4">
                <div class="signin-image m-4">
                    <figure class="mb-2"><img src="{{asset('web/auth/images/signin-image.jpg')}}" alt="sing up image"></figure>                   
                </div>




                <div class="signin-form">
                    <h2 class="form-title">{{__('front.sign_in')}}</h2>
                    @include('website.base._error')
                        <form method="POST" action="{{route('user.login.post')}}" id="form-login">
                            @csrf

                        <div class="form-group">
                            <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
{{--                            <input type="text" name="your_name" id="your_name" placeholder="Your Name"/>--}}
                            <input type="email"
                                   name="email" id="email" placeholder="{{__('front.email')}}"
                                   required
                                   value="{{old('email') ?? ''}}"
                                   class=" w-100 left-padding-phone px-4 @error('email') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="your_pass" placeholder="Password"/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                            <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                        </div>
                        <div class="form-group form-button">
                            <button type="submit" class="btn btn-primary btn-sm w-100 ">{{__('front.login')}}</button>
                            {{-- <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/> --}}
                        </div>


                    </form>
                    
                    <div class="d-flex justify-content-around my-4">
                        <a href="{{route('user.index')}}" class="signup-image-link">{{__('front.home')}}</a>

                        <a href="{{route('user.register')}}" class="signup-image-link">{{__('front.register_here')}}</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center pb-2" style=" gap: 20px 5px;">
                <div class="social-login mt-0">
                     <span class="social-label">Or login with</span>
                     <ul class="socials">
                         <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                         <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                         <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                     </ul>
                 </div>
             </div>
        </div>
        
    </section>


</div>

<!-- JS -->
{{--<script src="{{asset('web/js/main.js')}}"></script>--}}

<script src="{{asset('web/auth/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('web/auth/js/main.js')}}"></script>
<script src="{{ asset('custom/js/jquery.validate.min.js') }}"></script>
<script >
    let countryData = window.intlTelInputGlobals.getCountryData(),
        input2 = document.querySelector("#phone_number2"),
        addressDropdown = document.querySelector("#address-country");

    // init plugin

    var iti2 = window.intlTelInput(input2 , {
        utilsScript: "{{asset('web/js/utils.js')}}", // just for formatting/placeholders etc
    });
    jQuery(document).ready(function () {
        let $registerForm = $('#form-login');
        if ($registerForm.length) {
            $registerForm.validate({
                rules: {
                    phone_number: {
                        required: true,
                        minlength: 5,
                    },
                    password: {
                        required: true,
                    },
                },
                messages:{
                    phone_number: {
                        required:"{{__('front.requiredMessage')}}",
                        minlength: "{{__("front.minFive")}}",
                    },
                    password: {
                        required:"{{__('front.requiredMessage')}}",

                    },
                }
            });
        }
    });

    let $registerForm = $('#form-register');
    $.validator.addMethod( "notEqualToValue", function( value, element, param ) {
        return value != param;
    }, "Please select a valid value" );

    if ($registerForm.length) {
        $registerForm.validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                city_id: {
                    required: true,
                    notEqualToValue: 0
                },
                email: {
                    required: true
                },
                phone_number: {
                    required: true,
                    minlength: 5,
                },
                password: {
                    required: true,
                    minlength: 5
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password_1"
                },
            },
        });
    }

</script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
