<script>
    let chosenColor = document.getElementById("favColor");
    if (chosenColor != null){
        chosenColor.addEventListener("input", function() {
            document.getElementById("hex").value =  chosenColor.value;
        }, false);
    }

    let cColors = $('.favColor');
    cColors.each(function () {
        $(this).on('change', function () {
            console.log($(this).val());
            $(this).parent().find('input.hex').val($(this).val());
        })
    })
</script>
