// get pelatih name or class name
$('#searchResult').on('keyup', function () {
    // console.log($(this).val());
    let srcRes = $(this).val();
    let dataNeed = $(this).data('need');
    let addr = $(this).data('goto');
    if (srcRes.length >= 3) {
        $('#' + addr).removeAttr("hidden");
        const header = '<div class="table-responsive"><table class="table table-borderless table-light table-hover table-condensed"><thead class="bg-primary"><tr><th>#</th><th>Nama Pelatih</th><th>Kelas</th><th>Aksi</th></tr></thead><tbody>';
        const footer = '</tbody></table></div>';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/guestajax/search/' + dataNeed + '/' + srcRes,
            success: function (data) {
                var showData = '';
                var z;
                for (z = 0; z < data.length; z++) {
                    showData += '<tr><td>' + (z + 1) + '</td><td>' + data[z].name + '</td><td>' + data[z].nama_kelas + '</td><td><button class="btn btn-sm btn-primary pilihKelas" data-nama="' + data[z].name + '" data-kelas="' + data[z].nama_kelas + '">Pilih</button></td></tr>';
                }
                $('#valueResult').html(header + showData + footer);
                $('.pilihKelas').on('click', function () {
                    $('#inputResult').removeAttr("hidden");
                    var nama_pelatih = $(this).data('nama');
                    var nama_kelas = $(this).data('kelas');
                    $('input#nama_pelatih').val(nama_pelatih);
                    $('input#nama_kelas').val(nama_kelas);
                });
            }
        });
    }
});

// save edit sweetalert
$('.saveButton').on('click', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Anda Yakin?',
        text: "Melakukan Otentifikasi Pada Kelas Ini ?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, Yakin!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $(this).closest('form').submit();
        }
    })
});

// delete sweetalert
$(document).on("click", ".delete-req", function (e) {
    e.preventDefault();
    const href = $(this).attr('href');
    const type = $(this).attr('data-type');
    Swal.fire({
        title: 'Yakin Hapus ' + type + '?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            document.location.href = href;
            result.preventDefault();
        }
    })
});
