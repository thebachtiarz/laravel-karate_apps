
// save edit sweetalert
$('.saveButton').on('click', function (e) {
    e.preventDefault();
    var tipe = $(this).data('type');
    Swal.fire({
        title: 'Anda Yakin?',
        text: "Melakukan Perubahan " + tipe + "?",
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

$(document).ready(function () {
    let old_pass_val = document.getElementById('old_pass');
    let timeout = null;
    old_pass_val.onkeyup = function (e) {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            $('#the_old_pass').removeClass('has-success');
            $('#the_old_pass').removeClass('has-error');
            $('#feedback_oldpass').html('');
            $('#setnewpassword').html('');
            let md = forge.md.sha512.sha384.create();
            md.update(old_pass_val.value);
            let old_pass_enc = md.digest().toHex();
            // console.log(old_pass_enc);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/profile/checkmypassword',
                data: {
                    old_pass: old_pass_enc
                },
                success: function (data) {
                    if (data[0] == 'true') {
                        $('#the_old_pass').addClass('has-success');
                        $('#feedback_oldpass').html(data[1]);
                        const sleep = (milliseconds) => {
                            return new Promise(resolve => setTimeout(resolve, milliseconds))
                        };
                        sleep(1000).then(() => {
                            $('#setnewpassword').html(data[2]);
                            $('#back_old_pass').val(old_pass_enc);
                            let elmAddr = $('#setnewpassword');
                            $('html').animate({
                                scrollTop: elmAddr.offset().top - 95
                            }, 1250, 'easeInOutExpo');
                            wantBlinkIt();
                        });
                    } else {
                        $('#the_old_pass').addClass('has-error');
                        $('#feedback_oldpass').html(data[1]);
                    }
                }
            });
        }, 2000);
    };
});

$(document).ready(function () {
    $('.showDetailTrainButton').on('click', function () {
        let goto = $(this).data('goto');
        let unhide = $(this).data('unhide');
        $(this).addClass('displayHidden');
        $('#' + unhide).removeClass('displayHidden');
        $('#' + goto).removeClass('displayHidden');
        let datetime = $(this).data('datetime');
        let kelas = $(this).data('kelas');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/kelas/record/latihan/detail',
            data: {
                datetime: datetime,
                kode_kelas: kelas
            },
            success: function (data) {
                if (data[0] == 'true') {
                    let datavalue = `<ol class="fa-ul">`;
                    for (let index = 0; index < data[1].length; index++) {
                        datavalue += `<li><span class="fa-li"><i class="fas fa-user-tie fa-sm"></i></span><span class="label label-success">` + data[1][index] + `</span></li>`;
                    }
                    datavalue += '</ol>';
                    $('#' + goto).html(datavalue);
                } else {
                    let message = `<div class="callout callout-danger">` + data[1] + `</div>`;
                    $('#' + goto).html(message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                let message = `<div class="callout callout-danger"><p><i class="fas fa-ban"></i>&ensp;` + textStatus + ` ` + jqXHR.status + `</p><p><i class="fas fa-info-circle"></i>&ensp;` + errorThrown + `</p></div>`;
                $('#' + goto).html(message);
            }
        });
    });

    $('.hideDetailTrainButton').on('click', function () {
        let goto = $(this).data('goto');
        let unhide = $(this).data('unhide');
        $(this).addClass('displayHidden');
        $('#' + unhide).removeClass('displayHidden');
        $('#' + goto).addClass('displayHidden');
    });
});

$('#savenewpass').on('click', function () {
    $('#back_new_pass').val('');
    $('#back_confirm_pass').val('');
    let new_pass = $('#new_pass').val();
    let confirm_pass = $('#confirm_pass').val();
    if (new_pass && confirm_pass) {
        let ma = forge.md.sha512.sha384.create();
        let mb = forge.md.sha512.sha384.create();
        ma.update(new_pass);
        mb.update(confirm_pass);
        let new_pass_enc = ma.digest().toHex();
        let confirm_pass_enc = mb.digest().toHex();
        if (new_pass_enc == confirm_pass_enc) {
            $('#back_new_pass').val(new_pass_enc);
            $('#back_confirm_pass').val(confirm_pass_enc);
        }
    }
});

function wantBlinkIt() {
    $(".blinkIt").delay(0).animate({
        "background-color": "#00FC76"
    }, 0, function () {
        $(".blinkIt").animate({
            "background-color": "#fff"
        }, 5000);
    });
}