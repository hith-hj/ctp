jQuery(document).ready(function() {
    let $registerForm = $('#sheen_value_form');
    let _method = $('input[name="_method"]').val();
    let imageRequired = _method !== 'PUT';

    if ($registerForm.length) {
        $registerForm.validate({
            rules: {
                'heading:en': {
                    required: true
                },
                'main_heading:en': {
                    required: true
                },
                sort_order: {
                    required: true,
                },
                background_image: {
                    required: imageRequired,
                },
                responsive_image: {
                    required: imageRequired,
                },
                product_id:{
                    url: false,
                    required: false,
                    validUrl: false
                }
            },
            messages: {
                'heading:en': {
                    required: 'please enter heading'
                },
                'main_heading:en': {
                    required: 'please enter main heading'
                },
                display_order: {
                    required: 'please enter display order'
                }
            }
        });
    }

});
