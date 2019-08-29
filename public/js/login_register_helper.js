
$('#passwd_a').on('keyup', function () {
    var warn = `<blockquote><p>Please don't reuse your truly email password, we didn't spend a lot security for this app, savvy..</p></blockquote>`;
    $('#warn_pass').html(warn);
    //console.log('ok');
});

function encLog() {
    var lpass = $('#passwd_login').val();
    var lhide = $('#logHide').val();
    if (lpass) {
        $('#logHide').val(lpass);
        var md = forge.md.sha512.sha384.create();
        md.update(lpass);
        $('#passwd_login').val(md.digest().toHex());
    }
}

function encDaf() {
    var pass_a = $('#passwd_a').val();
    var pass_b = $('#passwd_b').val();
    var dhide = $('#dafHide').val();
    if (pass_a && pass_b) {
        $('#dafHide').val(pass_a);
        var dp_a = forge.md.sha512.sha384.create();
        dp_a.update(pass_a);
        var dp_b = forge.md.sha512.sha384.create();
        dp_b.update(pass_b);
        $('#passwd_a').val(dp_a.digest().toHex());
        $('#passwd_b').val(dp_b.digest().toHex());
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