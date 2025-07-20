window.Vue = require('vue');

require("@fancyapps/fancybox/dist/jquery.fancybox.min.css");
require("@fancyapps/fancybox/dist/jquery.fancybox.min.js");

$('document').ready(function() {
    $('.select2').select2();
    $('.dropify').dropify();
    autoComplete();
    percentage();
    $('.fancybox').fancybox({});
    removeImage();
    // clearInterval(interval);
})

function clickLinkConfirm(element, message) {
    Swal.fire({
        title: "Confirm!",
        text: message,
        icon: "warning",
        buttonsStyling: false,
        confirmButtonText: "<i class='la la-thumbs-o-up'></i> Yes delete it!",
        showCancelButton: true,
        cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-default"
        }
    }).then(function(result) {
        if (result.value) {
            $(element).find('form').submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelled",
                "Your item is safe :)",
                "error"
            )
        }
    });
}

$('.deleteRow').click(function(e) {
    clickLinkConfirm(this, "Are you sure you want to delete this item?");
    e.preventDefault();
});

$('input[name="type"]').on('change', function() {
    let selectedItem = 'settings_' + $(this).val();
    $('.settings_text').slideUp();
    $('.settings_text_area').slideUp();
    $('.settings_rich_text_box').slideUp();
    $('.settings_number').slideUp();
    $('.settings_image').slideUp();
    $('.settings_album').slideUp();
    $('.settings_checkbox').slideUp();
    $('.settings_select').slideUp();
    $('.' + selectedItem).slideDown();
});

function autoComplete() {
    let url, name;
    let element = $('.ajax-auto-complete');
    url = element.attr('url');
    name = element.attr('name');

    element.select2({
        placeholder: "search for " + name,
        ajax: {
            url: url,
            dataType: 'json',
            data: function(params) {
                // Query parameters will be ?search=[term]
                return {
                    search: params.term,
                };
            }
        },
        minimumInputLength: 1,
    });
}

function percentage()
{
    let percentage = $('.percentage');
    percentage.keydown(function () {
        // Save old value.
        if (!$(this).val() || (parseInt($(this).val()) <= 100 && parseInt($(this).val()) >= 0))
            $(this).data("old", $(this).val());
    });
    percentage.keyup(function () {
        // Check correct, else revert back to old value.
        if (!$(this).val() || (parseInt($(this).val()) <= 100 && parseInt($(this).val()) >= 0))
            ;
        else
            $(this).val($(this).data("old"));
    });
}

function removeImage()
{
    $('.remove-image').on('click', function (e) {
        e.preventDefault();
        let element = $(this);

        Swal.fire({
            title: "Confirm!",
            text: 'Are you sure you want to remove image?',
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "<i class='la la-thumbs-o-up'></i> Yes delete it!",
            showCancelButton: true,
            cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-default"
            }
        }).then(function(result) {
            if (result.value) {
                confirmRemoveImage(element);
            } else if (result.dismiss === "cancel") {
                Swal.fire(
                    "Cancelled",
                    "Your item is safe :)",
                    "error"
                )
            }
        });
    })
}

function confirmRemoveImage(element)
{
    let url = element.data('url');
    let src = element.data('src');
    let id = element.data('id');

    $.ajax(
        {
            url: url,
            type: 'get',
            headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                image: src,
                id: id,
            },
            success: function(result){
                Swal.fire({
                    text: 'image removed successfully',
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "<i class='la la-thumbs-o-up'></i> OK!",
                    showCancelButton: false,
                    customClass: {
                        confirmButton: "btn btn-danger",
                    }
                });
                element.parent().parent().remove();
            }
        });
}
