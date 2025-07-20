import {Toast} from "./default";


$("body").on('click', '.add-to-cart', function (e) {
    e.preventDefault();
    let productId = $(this).data('product');
    let quantityVal = $('.quantity').val();
    let countCartId = $('#icon-cart-count');
    let url = $('#router').data('add-to-cart');
    $.ajax({
        type: "POST",
        url: url,
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'id': productId,
            'quantity': quantityVal
        },
        success: function (data) {
            countCartId.find('#cart-count-item').html(data.countItems);
            Toast.fire({
                icon: "success",
                html: '<spans style="color: #FFFFFF; font-size: 18px;">added to cart</spans>'
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            Toast.fire({
                icon: "warning",
                html: '<spans style="color: #FFFFFF; font-size: 18px;">please login first</spans>'
            });
        }
    });
});

$("body").on('click', '#apply_coupon', function (e) {
    e.preventDefault();
    $('#code_message').html('')
    let couponCode = $('#coupon_code').val();
    let url = $(this).data('link') + "/" + couponCode;
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data.error === 'error') {
                $('#code_message').html(data.message)
            } else {
                $('#code_message').html(data.message).css('color', 'rgb(113, 255, 60)')
                $('#coupon').val(data.coupon.id)
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('#code_message').html('Enter Code Please');

        }
    });
});

$("body").on('click', '.add-to-wishlist', function (e) {
    e.preventDefault();
    console.log('h2');
    let productId = $(this).data('product');
    let wishlistCount = $('#icon-wishlist-count')
    let url = $('#router').data('add-to-wish') + "/" + productId;
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            wishlistCount.find('#cart-wishlist-item').html(data.countItems);
            if (data.message === "success") {
                if (productId === data.value) {
                    $(this)
                        .toggleClass("added")
                        .addClass("load-more-overlay loading");
                    setTimeout(function () {
                        $(this).removeClass("load-more-overlay loading");
                        $(this)
                            .toggleClass("w-icon-heart")
                            .toggleClass("w-icon-heart-full")
                    }, 500);
                    // $('#add-to-wishlist').removeClass('w-icon-heart').addClass('w-icon-heart-full');
                }
            } else {
                Toast.fire({
                    icon: "warning",
                    html: '<spans style="color: #FFFFFF; font-size: 18px;">please login first</spans>'
                });
            }
        },
        error: function () {
            Toast.fire({
                icon: "warning",
                html: '<spans style="color: #FFFFFF; font-size: 18px;">please login first</spans>'
            });
        }
    });
});

$(".update-cart").on('click', function (e) {
    e.preventDefault();
    let cartId = $(this).data('cart');
    // let formData = $('#cart_form').serialize()
    let $qty = $('#cart_form :input.quantity');

    // not sure if you wanted this, but I thought I'd add it.
    // get an associative array of just the values.
    let quantities = {};
    $qty.each(function () {
        quantities[this.name] = $(this).val();
    });
    let url = $('#router').data('update-cart');
    $.ajax({
        type: "POST",
        url: url,
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'quantities': JSON.stringify(quantities),
            'cart_id': cartId,
        },
        success: function (data) {
            if (data.message == "success") {
                Toast.fire({
                    icon: "success",
                    html: '<spans style="color: #FFFFFF; font-size: 18px;">cart updated successfully</spans>'
                });

                window.location.reload();/**/
            }
        }
    });
});


$("#clear-cart").on('click', function (e) {
    e.preventDefault();
    let cartId = $(this).data('cart');
    let url = $('#router').data('remove-products');
    let home = $('#home_page').data('home');
    $.ajax({
        type: "POST",
        url: url,
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'cart_id': cartId,
        },
        success: function (data) {
            if (data.message == "success") {
                Toast.fire({
                    icon: "success",
                    html: '<spans style="color: #FFFFFF; font-size: 18px;">cart updated successfully</spans>'
                });
                if (data.countItems === 0) {
                    window.location.href = home;
                } else {
                    window.location.reload();
                }
            }
        }
    });
});


$(window).on('load', function (e) {
    let globalError = $('#global_error').val();
    if (globalError) {
        Toast.fire({
            icon: "error",
            html: '<spans style="color: #FFFFFF; font-size: 18px;"> ' + globalError + ' </spans>'
        });
    }

    let globalWarning = $('#global_warning').val();
    if (globalWarning) {
        Toast.fire({
            icon: "warning",
            html: '<spans style="color: #FFFFFF; font-size: 18px;"> ' + globalWarning + ' </spans>'
        });
    }

    let globalSuccess = $('#global_success').val();
    if (globalSuccess) {
        Toast.fire({
            icon: "success",
            html: '<spans style="color: #FFFFFF; font-size: 18px;"> ' + globalSuccess + ' </spans>'
        });
    }
})

//test add mobile model
$('#trigger-cart-items').on('click', function (e) {
    e.preventDefault();
    $.ajax({
        type: "GET",
        url: '/fetchData',
        success: function (data) {

            if (typeof(data.subtotal) ==="string"){
                $('#cart-items').html(data.data)
                let price = '<label>Subtotal:</label>\n' +
                    '   <span class="price">'+data.subtotal+'</span>'
                $('#cart-subtotal').html(price)
            }else {
                $('#cart-items').html('<span class="text-center my-3" style="display: block"> '+data.message+'</span>')
            }
            console.log(data )
        }
    });
})
