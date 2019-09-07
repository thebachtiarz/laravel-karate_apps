<?php

// handler template theme asset
# online version
function online_asset()
{
    return 'https://bachtiarswebsitecoltd.net/AdminLTE-2.4.17';
}
# offline version
function offline_asset()
{
    return asset('adminlte');
}

# placeholder helper
function placeholder_helper($text = '', $err_msg = '')
{
    if ($err_msg) {
        $message = $err_msg;
    } else {
        $message = $text;
    }
    $null = "''";
    return 'placeholder="' . $message . '" onclick="this.placeholder=' . $null . '" onblur="this.placeholder=' . "'$message'" . '"';
}

# get input form for new password
function getInpFormForNewPassword()
{
    $data = '';
    $data .= '<div><div class="form-group form-row"><label for="new_pass" class="col-sm-3 control-label">Password Baru</label><div class="col-sm-9"><div class="input-group"><div class="input-group-addon blinkIt"><i class="fas fa-unlock-alt"></i></div><input type="password" class="form-control blinkIt" id="new_pass" value="" ';
    $data .= placeholder_helper('Masukkan Password Baru');
    $data .= 'required></div></div></div><div class="form-group form-row"><label for="confirm_pass" class="col-sm-3 control-label">Password Konfirmasi</label><div class="col-sm-9"><div class="input-group"><div class="input-group-addon blinkIt"><i class="fas fa-unlock-alt"></i></div><input type="password" class="form-control blinkIt" id="confirm_pass" value="" ';
    $data .= placeholder_helper('Ulang Kembali Password Baru');
    $data .= ' required></div></div></div></div>';
    // $data .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><input type="text" name="old_pass" id="back_old_pass" required><input type="text" name="new_pass" id="back_new_pass" required><input type="text" name="confirm_pass" id="back_confirm_pass" required><button type="submit" class="btn btn-primary saveButton" id="savenewpass" data-type="Password"><i class="fas fa-save"></i>&ensp;Simpan Perubahan</button></div></div>';
    return $data;
}
