
{{-- <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script> --}}
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

    <script async src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script> 

    {{-- <script src="{{ asset('assets/js/pages/widgets.js') }}"></script> --}}

    <script src="{{ asset('assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>

    <script src="{{ asset('assets/js/pages/crud/forms/editors/tinymce.min.js') }}"></script> 

    <script async src="{{ asset('assets/js/pages/features/miscellaneous/sweetalert2.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script> --}}

    {{-- <script src="{{ asset('assets/js/pages/crud/forms/widgets/form-repeater.js') }}"></script> --}}

    <script async src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js')}}"></script>

    <script async src="{{ asset('assets/js/pages/features/miscellaneous/treeview.js')}}"></script>

    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    
    <script src="{{ asset('assets/plugins/custom/dropify/dist/js/dropify.js') }}"></script> 
    
    <script async src="{{ asset('assets/js/pages/crud/file-upload/image-input.js') }}"></script>
    
    <script src="{{ mix('js/app.js') }}"></script>






   
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
<script>

    var KTLayoutSearch = function() {
        // Private properties
        var _target;
        var _form;
        var _input;
        var _closeIcon;
        var _resultWrapper;
        var _resultDropdown;
        var _resultDropdownToggle;
        var _closeIconContainer;
        var _inputGroup;
        var _query = '';

        var _hasResult = false;
        var _timeout = false;
        var _isProcessing = false;
        var _requestTimeout = 200; // ajax request fire timeout in milliseconds
        var _spinnerClass = 'spinner spinner-sm spinner-primary';
        var _resultClass = 'quick-search-has-result';
        var _minLength = 2;

        // Private functions
        var _showProgress = function() {
            _isProcessing = true;
            KTUtil.addClass(_closeIconContainer, _spinnerClass);

            if (_closeIcon) {
                KTUtil.hide(_closeIcon);
            }
        }

        var _hideProgress = function() {
            _isProcessing = false;
            KTUtil.removeClass(_closeIconContainer, _spinnerClass);

            if (_closeIcon) {
                if (_input.value.length < _minLength) {
                    KTUtil.hide(_closeIcon);
                } else {
                    KTUtil.show(_closeIcon, 'flex');
                }
            }
        }

        var _showDropdown = function() {
            if (_resultDropdownToggle && !KTUtil.hasClass(_resultDropdown, 'show')) {
                $(_resultDropdownToggle).dropdown('toggle');
                $(_resultDropdownToggle).dropdown('update');
            }
        }

        var _hideDropdown = function() {
            if (_resultDropdownToggle && KTUtil.hasClass(_resultDropdown, 'show')) {
                $(_resultDropdownToggle).dropdown('toggle');
            }
        }

        var _processSearch = function() {
            if (_hasResult && _query === _input.value) {
                _hideProgress();
                KTUtil.addClass(_target, _resultClass);
                _showDropdown();
                KTUtil.scrollUpdate(_resultWrapper);

                return;
            }

            _query = _input.value;

            KTUtil.removeClass(_target, _resultClass);
            _showProgress();
            _hideDropdown();

            setTimeout(function() {
                $.ajax({
                    url: '{{route('admin.search')}}',
                    data: {
                        query: _query
                    },
                    dataType: 'html',
                    success: function(res) {
                        console.log(res, 'success');
                        _hasResult = true;
                        _hideProgress();
                        KTUtil.addClass(_target, _resultClass);
                        KTUtil.setHTML(_resultWrapper, res);
                        _showDropdown();
                        KTUtil.scrollUpdate(_resultWrapper);
                    },
                    error: function(res) {
                        console.log(res, 'error');
                        _hasResult = false;
                        _hideProgress();
                        KTUtil.addClass(_target, _resultClass);
                        KTUtil.setHTML(_resultWrapper, '<span class="font-weight-bold text-muted">Connection error. Please try again later..</div>');
                        _showDropdown();
                        KTUtil.scrollUpdate(_resultWrapper);
                    }
                });
            }, 1000);
        }

        var _handleCancel = function(e) {
            _input.value = '';
            _query = '';
            _hasResult = false;
            KTUtil.hide(_closeIcon);
            KTUtil.removeClass(_target, _resultClass);
            _hideDropdown();
        }

        var _handleSearch = function() {
            if (_input.value.length < _minLength) {
                _hideProgress();
                _hideDropdown();

                return;
            }

            if (_isProcessing == true) {
                return;
            }

            if (_timeout) {
                clearTimeout(_timeout);
            }

            _timeout = setTimeout(function() {
                _processSearch();
            }, _requestTimeout);
        }

        // Public methods
        return {
            init: function(id) {
                _target = KTUtil.getById(id);

                if (!_target) {
                    return;
                }

                _form = KTUtil.find(_target, '.quick-search-form');
                _input = KTUtil.find(_target, '.form-control');
                _closeIcon = KTUtil.find(_target, '.quick-search-close');
                _resultWrapper = KTUtil.find(_target, '.quick-search-wrapper');
                _resultDropdown = KTUtil.find(_target, '.dropdown-menu');
                _resultDropdownToggle = KTUtil.find(_target, '[data-toggle="dropdown"]');
                _inputGroup = KTUtil.find(_target, '.input-group');
                _closeIconContainer = KTUtil.find(_target, '.input-group .input-group-append');

                // Attach input keyup handler
                KTUtil.addEvent(_input, 'keyup', _handleSearch);
                KTUtil.addEvent(_input, 'focus', _handleSearch);

                // Prevent enter click
                _form.onkeypress = function(e) {
                    var key = e.charCode || e.keyCode || 0;
                    if (key == 13) {
                        e.preventDefault();
                    }
                }

                KTUtil.addEvent(_closeIcon, 'click', _handleCancel);
            }
        };
    };

    // Webpack support
    if (typeof module !== 'undefined') {
        module.exports = KTLayoutSearch;
    }

    var KTLayoutSearchInline = KTLayoutSearch;
    var KTLayoutSearchOffcanvas = KTLayoutSearch;
</script>
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<script>
    var locale = '{{ config('app.locale') }}';
    localStorage.setItem('locale', locale);
</script>
