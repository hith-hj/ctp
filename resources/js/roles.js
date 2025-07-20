jQuery(document).ready(function() {
    let $registerForm = $('#sheen_value_form');
    if ($registerForm.length) {
        $registerForm.validate({
            rules: {
                name: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: 'please enter name'
                }
            }
        });
    }
});