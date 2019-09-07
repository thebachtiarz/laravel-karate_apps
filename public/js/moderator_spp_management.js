// get record spp peserta
$('.getRecSppPst').on('click', function () {
    let nama_peserta = $(this).data('pstname');
    let kelas_peserta = $(this).data('pstclass');
    let kode_peserta = $(this).data('pstcode');
    $('#dataRecSpp').removeAttr('hidden');
    getRecordPstValue(nama_peserta, kelas_peserta, kode_peserta);
});

$(document).ready(function () {
    $('.page-scroll').on('click', function (e) {
        let addr = $(this).data('goto');
        let elmAddr = $(addr);
        $('html').animate({
            scrollTop: elmAddr.offset().top - 90
        }, 1250, 'easeInOutExpo');
        e.preventDefault();
    });
});

$('#addspp').on('click', function () {
    $(this).addClass('displayHidden');
    $('#cclspp').removeClass('displayHidden');
    $('#addSppForm').removeClass('displayHidden');
});
$('#cclspp').on('click', function () {
    $(this).addClass('displayHidden');
    $('#addspp').removeClass('displayHidden');
    $('#addSppForm').addClass('displayHidden');
});

$('#sppPullSave').on('click', function () {
    let bulan = $("#spp_bulan option:selected").val();
    let kredit = $('#spp_kredit').val();
    let kelas = $('#spp_kelas').val();
    let peserta = $('#spp_peserta').val();
    let nama = $('#spp_nama').val();
    Swal.fire({
        title: 'Yakin Menambahkan SPP ?',
        text: "",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, yakin!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/kelas/record/spp/push_record',
                data: {
                    untuk_bulan: bulan,
                    kode_kelas: kelas,
                    kode_peserta: peserta
                },
                success: function (data) {
                    if (data[0] == 'true') {
                        Swal.fire(
                            data[1], '', 'success'
                        );
                    } else {
                        Swal.fire(
                            data[1], '', 'error'
                        );
                    }
                    getRecordPstValue(nama, kelas, peserta);
                }
            });
        }
    })
});

function getRecordPstValue(nama_peserta, kelas_peserta, kode_peserta) {
    $.ajax({
        type: 'GET',
        url: '/kelas/record/spp/' + kelas_peserta + '/' + kode_peserta,
        success: function (data) {
            $('#cclspp').addClass('displayHidden');
            $('#addspp').removeClass('displayHidden');
            $('#addSppForm').addClass('displayHidden');
            $('#postPstName').html('Record SPP ' + nama_peserta);
            $('#spp_kelas').val(kelas_peserta);
            $('#spp_peserta').val(kode_peserta);
            $('#spp_nama').val(nama_peserta);
            var showData = '';
            if (data) {
                showData += data;
            } else {
                showData += '<tr><td colspan="5" class="text-center alert-danger" style="font-weight: bold;">Tidak Ada Record SPP</td></tr>';
            }
            $('#dataValRecSpp').html(showData);
        }
    });
};

function onClickFeeSpp(auth, kelas) {
    if (auth == '6') {
        Swal.fire({
            title: 'Ingin Ubah Biaya SPP?',
            text: '',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                window.location.href = '/pengaturan/class/' + kelas + '/edit#spp';
            }
        });
    } else {
        Swal.fire(
            'Biaya SPP Sudah Ditentukan Oleh Pengurus Ranting.', '', 'info'
        );
    }
};