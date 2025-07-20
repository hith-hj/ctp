<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{asset('web/auth/fonts/material-icon/css/material-design-iconic-font.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Main css -->
    <link rel="stylesheet" href="{{asset('web/auth/css/style.css')}}">
    <link href="{{asset('icons/icon.png')}}" rel="icon">

    <style>

        /*body {*/
        /*    margin:0px;*/
        /*    height:100vh;*/
        /*    background: #1283da;*/
        /*}*/
        .center {
            height:100%;
            display:flex;
            align-items:center;
            justify-content:center;

        }
        .form-input {
            width:350px;
            padding:20px;
            background:#fff;
            box-shadow: -3px -3px 7px rgba(94, 104, 121, 0.377),
            3px 3px 7px rgba(94, 104, 121, 0.377);
        }
        .form-input input {
            display:none;

        }
        .form-input label {
            display:block;
            width:45%;
            height:45px;
            margin-left: 25%;
            line-height:50px;
            text-align:center;
            color:#cbbbbb;
            font-size:15px;
            font-family:"Open Sans",sans-serif;
            text-transform:Uppercase;
            font-weight:600;
            border-radius:5px;
            cursor:pointer;
        }

        .form-input img {
            width:100%;
            display:none;

            margin-bottom:30px;
        }
        .type1 {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 1px solid;
        }

    </style>

</head>
<body>

<div class="main py-3">

    <!-- Sign up form -->
    <section class="signup">
        <div class="container">
            <div class="signup-content py-4 px-2">
                <div class="signup-form m-0 p-0">
                    <h2 class="form-title">Sign up</h2>
                    <form method="POST" action="{{route('user.register.post')}}" id="form-login" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group center type1">
                            <div class="imgUp">
                                <div class="form-input">
                                    <div class="preview">
                                        <img id="file-ip-1-preview">
                                    </div>
                                    <label for="file-ip-1">Image</label>
                                    <input type="file"  name='avatar' id="file-ip-1" accept="image/*" onchange="showPreview(event);">
                                </div>
                            </div>
                        </div>
                        @error('avatar')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                        <div class="form-group mb-3">
                            @include('website.base._error')
                        </div>
                        <div class="form-group mb-2">
                            <label for="first_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text"
                                   class=" @error('first_name') border-danger @enderror"
                                   name="first_name" id="first-name"
                                   placeholder="{{__('front.first_name')}}"
                                   autocomplete="first_name" autofocus
                                   value="{{old('first_name')}}">
                        </div>
                        @error('first_name')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                        <div class="form-group mb-2">
                            <label for="last_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text"
                                   placeholder="{{__('front.last_name')}}"
                                   class="@error('last_name') border-danger @enderror"
                                   name="last_name" id="last-name"
                                   autocomplete="last_name" autofocus
                                   value="{{old('last_name')}}">
                        </div>
                        @error('last_name')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                        <div class="form-group mb-2">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" placeholder="{{__('front.email')}}"
                                   class="@error('email') border-danger @enderror"
                                   name="email" id="email_1" autocomplete="email" autofocus
                                   value="{{old('email')}}">
                        </div>
                        @error('email')
                            <span class="text-danger" role="alert">{{ $message }} </span>
                        @enderror
                        <div class="form-group mb-2 ">
                            <label for="phone_number"><i class="zmdi zmdi-phone"></i></label>
                            <input type="text" name="phone_number" id="phone_number" 
                               placeholder="{{__('front.phone')}}" required title="Phone number must start with your country code [+XXX]" 
                               pattern="[+][0-9]{1,3}[0-9]{6,9}"
                               class=" left-padding-phone px-4 interTel @error('phone_number') border-danger @enderror"
                               value="{{old('phone_number')}}"> 
                        </div>
                        @error('phone_number')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                        <div class="form-group mb-2">
                            <label for="{{__('front.password')}}"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" class=" " name="password" id="password_1"
                                   placeholder="{{__('front.password')}}"
                                   required
                                   value={{old('password')}}>
                        </div>
                        @error('password')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                        
                        <div class="form-group mb-2">
                            <label for="{{__('front.password_confirm')}}"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" class=" " name="password_confirmation" id="password_2"
                                   placeholder="{{__('front.password_confirm')}}"  required>
                        </div>
    
                        <div class="form-group form-button">
                            <button type="submit" class="btn btn-primary btn-sm w-100 ">
                                {{__('front.sign_up')}}
                            </button>
                        </div>
    
                    </form>
                </div>
                <div class="signup-image m-1">
                    <figure><img src="{{asset('web/auth/images/signup-image.jpg')}}" alt="sing up image"></figure>
                    <div class="d-flex justify-content-around">
                        <a href="{{route('user.login')}}" class="signup-image-link" >{{__('front.login')}}</a>
                        <a href="{{route('user.index')}}" class="signup-image-link">{{__('front.home')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- JS -->

<script src="{{asset('web/js/main.js')}}"></script>
<script src="{{asset('web/auth/vendor/jquery/jquery.min.js')}}"></script>
<script type="text/javascript">
    function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-ip-1-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }
</script>

    <script>
        
        $('[data-toggle="datepicker"]').datepicker({
        format: 'yyyy-MM-dd',
        startDate: new Date(),
        autoHide: true,
    });

        function addToWishlist(id, e) {
        e.preventDefault();
        let  wishlistCount  = $('#icon-wishlist-count')
        let url = "{{route('user.add-wishlist')}}" + "/" + id;
        $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
        wishlistCount.find('#cart-wishlist-item').html(data.countItems);
        if (data.deleted === 1) {
        $('#data-item-wishlist-'+id).fadeOut();
    }
        if (data.countItems ===0){
        window.location.href = "{{ route('user.index')}}";
    }
    },
        error: function () {
        Swal.fire({
        text: '{{__('front.you_are_not_auth')}}',
        icon: "warning",
        buttonsStyling: false,
        confirmButtonText: "<i class='la la-thumbs-o-up'></i> OK!",
        showCancelButton: false,
        customClass: {
        confirmButton: "btn btn-success",
    }
    });
    }
    });
    }


        function removeItem(id, cartId, productId) {
        $('#remove-product-' + id).fadeOut();
        let countCartId = $('#icon-cart-count');
        let url = "{{route('user.remove-products')}}";
        $.ajax({
        type: "POST",
        url: url,
        data: {
        _token: '{{csrf_token()}}',
        'product_id': productId,
        'cart_id': cartId,
    },
        success: function (data) {
        countCartId.find('#cart-count-item').html(data.countItems);
        if (data.countItems ===0){
        window.location.href = "{{ route('user.index')}}";
    }
    }
    });
    }

        function expand_filter(e) {
        e.preventDefault();
        let filter = document.getElementById("service_form");
        filter.classList.toggle("expand-service");
    }

        function upload() {
        $("#upload_impage_user").click();
    }

        function onFileSelected(event) {
        this.selectedFile = event.target.files;
        var file = this.selectedFile[0];
        var reader = new FileReader();

        reader.onloadend = function () {
        $("#imagePreview_user").css(
        "background-image",
        'url("' + reader.result + '")'
        );
    };
        if (file) {
        reader.readAsDataURL(file);
    } else {
        $("#imagePreview_user").css(
        "background-image",
        'url("../web/images/no-image.jpg")'
        );
    }
    }


</script>

</body>
</html>

