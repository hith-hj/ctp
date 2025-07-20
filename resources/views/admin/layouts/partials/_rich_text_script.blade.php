<script>
    let editor_config = {
        path_absolute : "{{ URL::to('/') }}/",
        selector: 'textarea.rich',
        menubar: 'file edit view insert format tools table tc help',
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | a11ycheck ltr rtl",
        relative_urls: false,
        file_picker_callback: function (callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            let type = 'image' === meta.filetype ? 'Images' : 'Files',
                url  = editor_config.path_absolute + 'laravel-filemanager?editor=tinymce5&type=' + type;


            tinyMCE.activeEditor.windowManager.openUrl({
                url: url,
                title : 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable : "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    }

    tinymce.init(editor_config);
</script>
