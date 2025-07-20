jQuery(document).ready(function() {
    let $registerForm = $('#sheen_value_form');
    if ($registerForm.length) {
        $registerForm.validate({
            rules: {
                'name:en': {
                    required: true
                },
                country: {
                    required: true
                },
                code: {
                    required: true
                },
                rate: {
                    required: true
                },
                symbol: {
                    required: true
                }
            },
            messages: {
                'name:en': {
                    required: 'please enter name'
                },
                country: {
                    required: 'please enter country'
                },
                code: {
                    required: 'please enter code'
                },
                rate: {
                    required: 'please enter rate'
                },
                symbol: {
                    required: 'please enter symbol'
                }
            }
        });
    }
});
