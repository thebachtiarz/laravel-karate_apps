
// save edit sweetalert
$('#editSimpan').on('click', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Anda Yakin?',
        text: "Melakukan Perubahan Biodata?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, Yakin!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $('#editSimpan').closest('form').submit();
        }
    })
});