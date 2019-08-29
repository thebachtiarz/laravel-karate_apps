
const pesanB = $('#failed').data('flashdata');
if (pesanB) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 10000
    });

    Toast.fire({
        type: 'error',
        title: pesanB
    });
};