@extends('website.app')
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
                <li> - {{__('front.my_account')}} - {{session()->get('user')->first_name}}</li>
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
                            <a href="#sign-in" class="nav-link active">{{__('front.verification')}}</a>
                        </li>
                    </ul>
                    
                    <form method="POST" action="{{route('user.verification.code')}}" >
                        @csrf
                        <div class="tab-content text-center" style="padding:10px">
                            <span style="color: rgb(0, 157, 255); "><b><bdi>{{session()->get('user')->phone_number ?? $user->phone_number}}</bdi> </b></span>
                            <div class="d-flex justify-content-center mt-5 verficatiominput">
                                <input class="form-control" name="activation_code[]" type="text"  id="txt1" maxLength="1" size="1" min="0" max="9"  onkeyup="moveCursor(this,'txt2')" required="required"/>
                                <input class="form-control" name="activation_code[]" type="text" id="txt2" maxLength="1" size="1" min="0" max="9"  onkeyup="moveCursor(this,'txt3')" required="required"/>
                                <input class="form-control" name="activation_code[]" type="text" id="txt3" maxLength="1" size="1" min="0" max="9" onkeyup="moveCursor(this,'txt4')" required="required"/>
                                <input class="form-control" name="activation_code[]" type="text" id="txt4" maxLength="1" size="1" min="0" max="9" onkeyup="moveCursor(this,'txt5')" required="required"/>
                                <input class="form-control" name="activation_code[]" type="text" id="txt5" maxLength="1" size="1" min="0" max="9" onkeyup="moveCursor(this,'txt6')" required="required"/>
                                <input class="form-control" name="activation_code[]" type="text" id="txt6" maxLength="1" size="1" min="0" max="9" required="required"/>
                            </div>
    
                            <input hidden name="phone_number" value="{{session()->get('user')->phone_number ?? $user->phone_number}}">
                            <div class="text-center mt-5 ">
                                <button type="submit"  class="btn btn-primary mx-auto">{{__('front.verification')}}</button>
                                <a href="javascript:void(0);" id="resend_verification_code" 
                                    data-phone="{{session()->get('user')->phone_number ?? $user->phone_number}}" 
                                    data-url="{{route('user.resendVerification')}}" 
                                    style="color: rgb(0, 157, 255);font-size: 12px;">
                                    {{__('front.resend')}}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('custom/js/jquery.validate.min.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            let $registerForm = $('#form_verification');
            if ($registerForm.length) {
                $registerForm.validate({
                    rules: {
                        "activation_code[]": {
                            required: true
                        },
                    },
                });
            }

            $('#resend_verification_code').on('click', function (e){
                let url = $(this).data('url');
                let phone = $(this).data('phone');
                e.preventDefault();
                $.ajax(
                    {
                        url: url,
                        type: 'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                           phone_number: phone
                        },
                        success: function(result){
                            Swal.fire({
                                text: '{{__('front.verification_code_send_success')}}',
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "<i class='la la-thumbs-o-up'></i> OK!",
                                showCancelButton: false,
                                customClass: {
                                    confirmButton: "btn btn-success",
                                }
                            });
                        }
                    });
            })
        });
    </script>
@endsection


