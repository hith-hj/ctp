// require('./bootstrap');
//
// require('alpinejs');

import Swal from 'sweetalert2/src/sweetalert2.js'

window.Swal = Swal;

export const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-left',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});
