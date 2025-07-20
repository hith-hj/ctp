@extends('website.app')
@section('title',__('front.contact'))
@section('content')
<!-- Contact Start -->
<div class="container-fluid ">
    <div class="d-flex flex-column align-items-center justify-content-center"
    style="min-height: 300px ;
        background-image:url('{{asset('web/img/pink-bg.png')}}');
        background-size:contain;
        background-position-x: center;
    ">
        <h1 class="font-weight-semi-bold text-white text-uppercase mb-3">
            {{ __('front.contact_us') }}
        </h1>

    </div>
</div>
<div class="container-fluid mb-5 mt-4">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="row">
            <div class="col-lg-7 mb-5">
                @include('website.base._error')
                <div class="contact-form">
                    <div id="success"></div>
                    <form name="sentMessage" id="formId" action="{{route('user.contactUs')}}" method="post" >
                        @csrf
                        <div class="control-group mb-2">
                            <input type="text" class="form-control" id="name" name="name" placeholder="{{__('front.name')}}"
                                   required data-validation-required-message="Please enter your name" />
                        </div>
                        <div class="control-group mb-2">
                            <input type="email" class="form-control" id="email" name="email" placeholder="{{__('front.email')}}"
                                   required data-validation-required-message="Please enter your email" />
                        </div>

                        <div class="control-group mb-2">
                            <textarea class="form-control" rows="3" id="message" name="message" placeholder="{{__('front.message')}}"
                                      required data-validation-required-message="Please enter your message"></textarea>
                        </div>
                        <div>
                            <button class="btn btn-outline-primary py-2 px-4 w-100" type="submit" >
                                <i class="fa fa-check"></i>
                                {{__('front.send')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <h5 class="font-weight-semi-bold">{{__('front.get_in_touch')}}</h5>
                <p>
                    We’re here to help. Whether you have questions about your order, need support with a product, or just want to say hello—our team is always ready to assist.
                </p>

                <h5 class="font-weight-semi-bold">How to Reach Us</h5>
                <div class="d-flex flex-column">
                    <p class="mb-1">
                        <i class="fa fa-map-marker-alt text-primary mr-3"></i>
                       {{getSetting('address') ?? 'address'}}
                    </p>
                    <p class="mb-1">
                        <i class="fa fa-envelope text-primary mr-3"></i>
                        {{getSetting('email')}}
                    </p>
                    <p class="mb-0">
                        <i class="fa fa-phone-alt text-primary mr-3"></i>
                        {{ getSetting('phone') ?? 'phone number'}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

@endsection
@section('scripts')
    <script src="{{ asset('custom/js/jquery.validate.min.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            let $registerForm = $('#formId');
            if ($registerForm.length) {
                $registerForm.validate({
                    rules: {
                        name: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true,
                        },
                        message: {
                            required: true,
                        },
                    },
                });
            }
        });
    </script>
@endsection
