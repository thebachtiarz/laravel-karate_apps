// auto submit select form
$(document).ready(function () {
    $('#thsmt').on('change', function () {
        let form = $(this).closest('form');
        form.find('#submitThSmt').click();
    });

});

$(document).ready(function () {
    $('option[value=' + getUrlParameter('thsmt') + ']').attr('selected', true);
});

// autoselect peserta when reload
$(document).ready(function () {
    $('#pst1').attr('selected', true);
    let peserta = $("#pst1").val();
    $('.recordLatihan, .recordPersyaratan, .recordSpp').attr('hidden', 'value');
    $('#' + peserta).removeAttr("hidden");
});

// select peserta
$(document).ready(function () {
    $('#selPeserta').on('change', function () {
        let peserta = $("#selPeserta option:selected").val();
        $('.recordLatihan, .recordPersyaratan, .recordSpp').attr('hidden', 'value');
        $('#' + peserta).removeAttr("hidden");
    });
});

// auto selected celect form by url get parameter
function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};
