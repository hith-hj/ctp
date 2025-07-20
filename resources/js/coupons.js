jQuery(document).ready(function() {
    let $registerForm = $('#sheen_value_form');
    let _method = $('input[name="_method"]').val();
    let imageRequired = _method !== 'PUT';
    if ($registerForm.length){
        $registerForm.validate({
            rules: {
                'name:en':{
                    required: true
                },
                start_date:{
                    required: true
                },
                end_date:{
                    required: true
                },
                coupon_value:{
                    required: imageRequired
                },
                max_amount:{
                    required: imageRequired
                }
            }
        });

        let nameAr = $('input[name="name:ar"]');
        $registerForm.on('submit', function(e) {
            if (nameAr.val() === '') {
                e.preventDefault();
                $('#ar-tab-1').trigger('click');
                nameAr.addClass('is-invalid');
                nameAr.parent().append('<div class="invalid-feedback text-right">name is required</div>');
                return false;
            }
        });
    }

});
