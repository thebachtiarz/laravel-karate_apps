// convert view idr currency
var rupiah = document.getElementById("rupiah");
rupiah.addEventListener("keyup", function (e) {
    rupiah.value = formatRupiah(this.value, "Rp. ");
});
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }
    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}
$("#rupiah").keyup(function () {
    var kalimat = $('#rupiah').val();
    var ganti = kalimat.replace(/[.*+?^${}()|[\]\\]/g, '');
    var res = ganti.slice(3, 10);
    $('#creditpst').val(res);
});

// autofill keterangan persyaratan
$('#kode_file').on('change', function () {
    let kode_file = $('#kode_file').find(":selected").text();
    $('#file_info').val(kode_file);
});

// cashback exam fee when more payment sweetalert
$(document).on("click", ".cashback-examn", function (e) {
    e.preventDefault();
    let href = $(this).attr('href');
    Swal.fire({
        title: 'Yakin Kembalikan Biaya ?',
        text: 'Apakah Biaya Sudah Anda Kembalikan Ke Peserta ?',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, lanjut!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            document.location.href = href;
            result.preventDefault();
        }
    })
});