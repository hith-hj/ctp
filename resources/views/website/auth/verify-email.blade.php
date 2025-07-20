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
                    
                    <h3>Email has been sent to {{session()->get('user')->email}} containing verification link pleas check your email</h3>
                    <form method="POST" action="{{route('user.verification.code')}}" id="form-login">
                            @csrf
                            <input hidden name="email" value="{{session()->get('user)->email}}" required>
                            <input hidden name="user_id" value="{{session()->get('user)->id}}" required>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="number" name="code" placeholder="Code"/>
                        </div>
                        <div class="form-group form-button">
                            <button type="submit" class="btn btn-primary btn-sm w-100 ">{{__('front.verify')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection