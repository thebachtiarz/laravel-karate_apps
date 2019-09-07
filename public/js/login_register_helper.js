
$('#passwd_a').on('keyup', function () {
    $('#warn_pass').html(getUrlParameter('mediasize'));
});

function encLog() {
    var lpass = $('#passwd_login').val();
    if (lpass) {
        $('#logHide').val(lpass);
        var md = forge.md.sha512.sha384.create();
        md.update(lpass);
        $('#back_passwd_login').val(md.digest().toHex());
    }
}

function encDaf() {
    var pass_a = $('#passwd_a').val();
    var pass_b = $('#passwd_b').val();
    if (pass_a && pass_b) {
        $('#dafHide').val(pass_a);
        let ma = forge.md.sha512.sha384.create();
        let mb = forge.md.sha512.sha384.create();
        ma.update(pass_a);
        mb.update(pass_b);
        let new_pass_enc = ma.digest().toHex();
        let confirm_pass_enc = mb.digest().toHex();
        $('#back_passwd_a').val(new_pass_enc);
        $('#back_passwd_b').val(confirm_pass_enc);
    }
}

$('#startRegister').on('click', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Anda Yakin?',
        text: "Data yang anda masukkan sudah benar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, Yakin!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $('#startRegister').closest('form').submit();
        }
    })
});

function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    let message = `Please don't reuse your truly email password, we didn't spend a lot security for this app, savvy..`;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return `<div class="callout callout-info text-bold" style="font-style: italic;">` + message + `</div>`;
        } else {
            return `<blockquote>` + message + `</blockquote>`;
        }
    }
};
