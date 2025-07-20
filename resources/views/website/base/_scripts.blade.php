
{{--<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>--}}
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('web/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('web/lib/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('web/mail/jqBootstrapValidation.min.js')}}"></script>
<script src="{{asset('web/mail/contact.js')}}"></script>
<script src="{{asset('web/js/intlTelInput.js')}}"></script>

<script src="{{asset('web/js/main.js')}}"></script>
<!-- JavaScript Libraries -->

<!-- Template Javascript -->
<script>

    // $('[data-toggle="datepicker"]').datepicker({
    //     format: 'yyyy-MM-dd',
    //     startDate: new Date(),
    //     autoHide: true,
    // });

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
        let cartItemsCount = $('#cartItemsCount');

        $.ajax({
            type: "POST",
            url: url,
            data: {
                _token: '{{csrf_token()}}',
                'product_id': productId,
                'cart_id': cartId,
            },
            success: function (data) {
                cartItemsCount.html(data.countItems);
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
<script src=""></script>
<script src="{{asset('js/front_scripts.js')}}"></script>
