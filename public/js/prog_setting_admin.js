
$(document).ready(function () {
    $('.hiddenReact').on('click', function () {
        var addr = $(this).attr('value');
        $('table').remove('tableDataJSON');
        $('.getHidden').attr('hidden', 'value');
        $('#' + addr).removeAttr("hidden");
        var dataNeed = $(this).data('ajaxjson');
        $.ajax({
            type: 'GET',
            url: '/ajaxgettable/' + dataNeed,
            success: function (data) {
                $('.thisDataJSON').html(data);
            }
        });
    });
    $('.page-scroll').on('click', function (e) {
        var addr = $(this).attr('href');
        var elmAddr = $(addr);
        $('html').animate({
            scrollTop: elmAddr.offset().top - 50
        }, 1250, 'easeInOutExpo');
        e.preventDefault();
    });
});


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



$('#updToMod').on('click', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Anda Yakin?',
        text: "Menjadikan User Ini Menjadi Moderator?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, Yakin!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $('#updToMod').closest('form').submit();
        }
    })
});


