<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('front.verify')}}</title>

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
                    <h4 class="form-title">{{__('front.Confirm code')}}</h4>
                    @include('website.base._error')
                    <form method="POST" action="{{route('user.verification.code')}}" >
                            @csrf
                            <input hidden name="email" value="{{session()->get('user')->email}}" required>
                            <input hidden name="user_id" value="{{session()->get('user')->id}}" required>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="code" placeholder="Code"/>
                        </div>
                        <div class="form-group form-button">
                            <button type="submit" class="btn btn-primary btn-sm w-100 ">{{__('front.verify')}}</button>
                        </div>
                    </form>
                    <form method="POST" action="{{route('user.verification.resendcode')}}" class="mt-4">
                        @csrf
                        <input hidden name="email" value="{{session()->get('user')->email}}" required>
                        <input hidden name="user_id" value="{{session()->get('user')->id}}" required>
                        <button type="submit" class="btn btn-sm w-100 bg-transparent" >{{__('front.Resend code')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>
