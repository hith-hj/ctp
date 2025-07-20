<!DOCTYPE html>
<html lang="en">

<head>
    @include('website.base._meta')
    @yield('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>


<body>
    <div id="global_translations" data-addtocart="{{ __('front.added_to_cart') }}"
        data-viewcart="{{ __('front.viewcart') }}" data-checkout="{{ __('front.checkout') }}"></div>
    @include('website.partails._header')

    @yield('content')

    @include('website.partails._footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary bg-white rounded back-to-top">
        <i class="fa fa-angle-double-up text-primary"></i>
    </a>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('web/js/jquery/jquery.min.js') }}"></script>

    @include('website.base._scripts')

    @yield('scripts')


<!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $key => $error)
                    <script>
                        toastr['error']({!! json_encode($error) !!}, {
                            closeButton: true,
                            tapToDismiss: false,
                            timeOut: 5,
                        });
                    </script>
                @endforeach
            </ul>
        </div>
    @endif
    @if (Session::has('error'))
        <script>
            toastr['error']({!! json_encode(Session::get('error')) !!}, {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 5,
            });
        </script>
    @endif
    @if (Session::has('success'))
        <script>
            toastr['success']({!! json_encode(Session::get('success')) !!}, {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 5,
            });
        </script>
    @endif
</body>

</html>
