// autoselect peserta when reload
$(document).ready(function () {
    $('#mtr1').attr('selected', true);
    getMateriPeserta($('#mtr1').val());
});

// select materi peserta
$('#selMateri').on('change', function () {
    let kyuMateri = $("#selMateri option:selected").val();
    getMateriPeserta(kyuMateri);
});

// function get materi peserta by kyu
function getMateriPeserta(tingkat) {
    let progress = '<div class="progress progress-sm active"><div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>';
    $('#viewMateri').html(progress);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/materi/get',
        data: {
            kyu: tingkat
        },
        success: function (data) {
            $('#viewMateri').html(data);
        }
    });
};

function mediascreen(x) {
    if (x.matches) { // If media query matches
        $('.zAlertResolution').removeAttr('hidden');
    } else {
        $('.zAlertResolution').attr('hidden', 'value');
    }
}

var x = window.matchMedia("(max-width: 600px)");
mediascreen(x); // Call listener function at run time
x.addListener(mediascreen); // Attach listener function on state changes