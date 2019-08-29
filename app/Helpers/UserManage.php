<?php

use Illuminate\Support\Facades\DB;
use App\User;
use App\Kelas;
use App\Acc_class;
use App\Data_Peserta;
use App\Static_Budget;
use App\Static_File;
use App\PrivateChildsParents;
use App\Guest_Otentifikasi as GO;

# ADMIN
# get all user except admin
function getUsersExceptAdmin()
{
    if (auth()->user()->status = 'bestnimda') {
        return DB::table('users')->select(['id', 'status', 'name', 'email', 'code', 'created_at'])->whereNotIn('status', ['bestnimda', 'guests'])->get();
    } else {
        return json_encode('You do not have an access for get that data');
    }
}
# make in table
function getUsersExceptAdminInTable()
{
    echo '<div class="table-responsive"><table class="table table-borderless table-light table-hover table-condensed tableDataJSON"><thead class="bg-primary"><tr><th>#</th><th>Nama</th><th>Status</th><th>Email</th><th>Otentifikasi</th><th>Aksi</th></tr></thead><tbody>';
    if (json_decode(getUsersExceptAdmin()) != NULL) {
        $no = 1;
        foreach (getUsersExceptAdmin() as $key) {
            if ($key->code != NULL) {
                echo '<tr class="success"><td>' . $no . '</td><td>' . $key->name . '</td><td>' . getStatusUserById($key->status) . '</td><td>' . $key->email . '</td><td>Sudah</td><td class="align-middle"><a href="/setting/apps/users/' . $key->id . '/edit" class="btn btn-sm btn-warning">Edit</a>&ensp;<a href="/setting/apps/users/' . $key->id . '/delete" class="btn btn-sm btn-danger delete-req" onclick="deleteFunc()" data-type="User">Hapus</a></td></tr>';
            } else {
                echo '<tr class="danger"><td>' . $no . '</td><td>' . $key->name . '</td><td>' . getStatusUserById($key->status) . '</td><td>' . $key->email . '</td><td>Belum</td><td class="align-middle"><a href="/setting/apps/users/' . $key->id . '/edit" class="btn btn-sm btn-warning">Edit</a>&ensp;<a href="/setting/apps/users/' . $key->id . '/delete" class="btn btn-sm btn-danger delete-req" onclick="deleteFunc()" data-type="User">Hapus</a></td></tr>';
            }
            $no++;
        }
    }
    echo '</tbody></table></div>';
}

# get all class for admin management
function getAllClassForAdminManagement()
{
    if (auth()->user()->status = 'bestnimda') {
        return DB::table('kelas_data')->select(['id', 'kode_kelas', 'kode_pelatih', 'nama_kelas', 'created_at'])->get();
    } else {
        return json_encode('You do not have an access for get that data');
    }
}
# make as table
function getAllClassForAdminManagementInTable()
{
    echo '<div class="table-responsive"><table class="table table-borderless table-light table-hover table-condensed tableDataJSON"><thead class="bg-primary"><tr><th>#</th><th>Nama Kelas</th><th>Pemilik</th><th>Dibuat</th><th>Aksi</th></tr></thead><tbody>';
    if (json_decode(getAllClassForAdminManagement()) != NULL) {
        $no = 1;
        foreach (getAllClassForAdminManagement() as $key) {
            echo '<tr><td>' . $no . '</td><td>' . $key->nama_kelas . '</td><td>' . getNamePltByCode($key->kode_pelatih) . '</td><td>' . conv_getDate($key->created_at) . '</td>
            <td class="align-middle"><a href="/setting/apps/class/' . $key->id . '/edit" class="btn btn-sm btn-warning">Edit</a>&ensp;<a href="/setting/apps/class/' . $key->id . '/delete" class="btn btn-sm btn-danger delete-req" data-type="Kelas">Hapus</a></td></tr>';
            $no++;
        }
    }
    echo '</tbody></table></div>';
}

# get all new register
function getAllNewRegister()
{
    if (auth()->user()->status = 'bestnimda') {
        return DB::table('users')->select(['id', 'status', 'name', 'email', 'code', 'created_at'])->where('status', ['guests'])->get();
    } else {
        return json_encode('You do not have an access for get that data');
    }
}
# make as table
function getAllNewRegisterInTable()
{
    echo '<div class="table-responsive"><table class="table table-borderless table-light table-hover table-condensed tableDataJSON"><thead class="bg-primary"><tr><th>#</th><th>Nama</th><th>Status</th><th>Email</th><th>Otentifikasi</th><th>Aksi</th></tr></thead><tbody>';
    if (json_decode(getAllNewRegister()) != NULL) {
        $no = 1;
        foreach (getAllNewRegister() as $key) {
            if ($key->code != NULL) {
                echo '<tr class="success"><td>' . $no . '</td><td>' . $key->name . '</td><td>' . getStatusUserById($key->status) . '</td><td>' . $key->email . '</td><td>Sudah</td><td class="align-middle"><a href="/setting/apps/users/' . $key->id . '/edit" class="btn btn-sm btn-warning">Edit</a>&ensp;<a href="/setting/apps/users/' . $key->id . '/delete" class="btn btn-sm btn-danger delete-req" onclick="deleteFunc()" data-type="User">Hapus</a></td></tr>';
            } else {
                echo '<tr class="danger"><td>' . $no . '</td><td>' . $key->name . '</td><td>' . getStatusUserById($key->status) . '</td><td>' . $key->email . '</td><td>Belum</td><td class="align-middle"><a href="/setting/apps/users/' . $key->id . '/edit" class="btn btn-sm btn-warning">Edit</a>&ensp;<a href="/setting/apps/users/' . $key->id . '/delete" class="btn btn-sm btn-danger delete-req" onclick="deleteFunc()" data-type="User">Hapus</a></td></tr>';
            }
            $no++;
        }
    }
    echo '</tbody></table></div>';
}


# MODERATOR
# get count of moderator's class
function getCountOfModeratorClass()
{
    return Kelas::where('kode_pelatih', '=', auth()->user()->code)->count();
}

# get count of moderator otentification request
function getCountModReqOtt()
{
    return GO::where('tujuan_code', '=', auth()->user()->code)->count();
}

# get all access class for moderator
function getAllAccessClassModeratorByCode()
{
    if (auth()->user()->status == 'moderator') {
        return Acc_class::join('kelas_data', 'acc_class.kode_kelas', '=', 'kelas_data.kode_kelas')->where('acc_class.kode_pelatih', '=', auth()->user()->code)->get();
    } else {
        return json_encode('You do not have an access for get that data');
    }
}
# make as table
function getAllAccessClassModeratorByCodeInTable()
{
    echo '<div class="table-responsive"><table class="table table-borderless table-light table-hover table-condensed tableDataJSON"><thead class="bg-primary"><tr><th>#</th><th>Nama Kelas</th><th>Dibuat</th><th>Jumlah Peserta</th><th>Jumlah Pelatih</th><th>Aksi</th></tr></thead><tbody>';
    if (json_decode(getAllAccessClassModeratorByCode()) != NULL) {
        $no = 1;
        foreach (getAllAccessClassModeratorByCode() as $key) {
            echo '<tr><td>' . $no . '</td><td>' . getClassNameByCode($key->kode_kelas) . '</td><td>' . conv_getDate($key->created_at) . '</td><td>' . getCountPstInClass($key->kode_kelas) . ' Peserta</td><td>' . getCountPltInClass($key->kode_kelas) . ' Pelatih</td><td class="align-middle"><a href="/pengaturan/class/' . $key->kode_kelas . '/edit" class="btn btn-sm btn-warning">Edit</a>&ensp;<a href="/pengaturan/class/' . $key->kode_kelas . '/hapus" class="btn btn-sm btn-danger delete-req" data-type="Kelas">Hapus</a></td></tr>';
            $no++;
        }
    }
    echo '</tbody></table></div>';
}

# get all moderator request otentification
function getAllModReqOtt()
{
    if (auth()->user()->status == 'moderator') {
        return GO::where('tujuan_code', '=', auth()->user()->code)->get();
    } else {
        return json_encode('You do not have an access for get that data');
    }
}
# make as table
function getAllModReqOttInTable()
{
    echo '<div class="table-responsive"><table class="table table-borderless table-light table-hover table-condensed tableDataJSON"><thead class="bg-primary"><tr><th>#</th><th>Nama</th><th>Email</th><th>Kelas Tujuan</th><th>Tipe Permintaan</th><th>Pesan</th><th>Aksi</th></tr></thead><tbody>';
    if (json_decode(getAllModReqOtt()) != NULL) {
        $no = 1;
        foreach (getAllModReqOtt() as $key) {
            echo '<tr><td>' . $no . '</td><td>' . getPstNameByEmail($key->asal_email) . '</td><td>' . $key->asal_email . '</td><td>' . getClassNameByCode($key->tujuan_kelas) . '</td><td>' . getStatusUserById(convStatUserToStatName($key->asal_newstat)) . '</td><td>' . $key->asal_info . '</td><td class="align-middle"><a href="/pengaturan/otentifikasi/confirm/' . $key->id . '" class="btn btn-sm btn-primary">Konfirmasi</a>&ensp;<a href="/pengaturan/otentifikasi/delete/' . $key->id . '" class="btn btn-sm btn-danger delete-req" data-type="Permintaan Otentifikasi">Hapus</a></td></tr>';
            $no++;
        }
    }
    echo '</tbody></table></div>';
}

# get count pelatih by class
function getCountPelatihByClass($class_code = '')
{
    if ($class_code) {
        return Acc_class::where('kode_kelas', '=', $class_code)->count();
    } else {
        # code...
    }
}

# get count bendahara by class
function getCountBendaharaByClass($class_code = '')
{
    if ($class_code) {
        return Acc_class::join('users', 'acc_class.kode_pelatih', '=', 'users.code')->where('kode_kelas', '=', $class_code)->whereIn('users.status', ['moderator', 'treasurer'])->count();
    } else {
        # code...
    }
}

# get access pelatih in class without moderator
function getPltInClassWithoutModerator($class_code = '')
{
    if ($class_code) {
        return Acc_class::where('kode_kelas', '=', $class_code)->whereNotIn('kode_pelatih', [auth()->user()->code])->get();
    } else {
        # code...
    }
}
# make in select option
function getPltInClassWithoutModeratorSelect($class_code = '')
{
    if ($class_code) {
        $data = getPltInClassWithoutModerator($class_code);
        if ($data != NULL) {
            foreach ($data as $key) {
                echo '<option value="' . $key->kode_pelatih . '">' . getNamePltByCode($key->kode_pelatih) . ' ( ' . getStatusUserByCode($key->kode_pelatih) . ' )</option>';
            }
        }
    } else {
        # code...
    }
}

# get daftar data pelatih
function getDaftarDataPelatihByClass($class_code = '')
{
    if ($class_code) {
        $data = Acc_class::where('kode_kelas', '=', $class_code)->get();
        echo $data;
    } else {
        # code...
    }
}

# get biaya ujian by class and tingkat
function getBiayaUjianByClassAndTingkat($class_code = '', $tingkat = '')
{
    if ($class_code && $tingkat) {
        $data = Static_Budget::select(['biaya_ujian'])->where([['kode_kelas', '=', $class_code], ['tingkat', '=', $tingkat], ['thsmt', '=', getThnSmtClassByCode($class_code)]])->first();
        return $data['biaya_ujian'];
    } else {
        # code...
    }
}

# get berkas persyaratan ujian by class
function getFileExamnDataByClass($class_code = '')
{
    if ($class_code) {
        return Static_File::where([['kode_kelas', '=', $class_code], ['thsmt', '=', getThnSmtClassByCode($class_code)]])->get();
    } else {
        # code...
    }
}
# make as table
function getFileExamnDataByClassInTable($class_code = '')
{
    echo '<div class="table-responsive">
    <table class="table table-borderless table-light table-hover table-condensed tableDataJSON">
    <thead class="bg-primary">
    <tr>
    <th>#</th>
    <th>Jenis Persyaratan</th>
    <th>Aksi</th>
    </tr></thead><tbody>';
    if (json_decode(getFileExamnDataByClass($class_code)) != NULL) {
        $no = 1;
        foreach (getFileExamnDataByClass($class_code) as $key) {
            echo '<tr><td>' . $no . '</td>
            <td>' . $key->nama_file . '</td>
            <td class="align-middle"><a href="/pengaturan/class/' . $key->kode_file . '/delete" class="btn btn-sm btn-danger delete-req" data-type="Berkas">Hapus</a></td></tr>';
            $no++;
        }
    }
    echo '</tbody></table></div>';
}

# available to otentification again if peserta not found in peserta_data table
function needOtentificationAgain()
{
    $code = auth()->user()->code;
    $check = User::select(['status'])->where('code', '=', $code)->first();
    if ($check['status'] == 'participants') {
        $check2 = Data_Peserta::select(['kode_peserta'])->where('kode_peserta', '=', $code)->first();
        if ($check2['kode_peserta'] == NULL) {
            return 'OK';
        } else {
            return 'DONT WORRY';
        }
    } elseif ($check['status'] == 'parents') {
        $check2 = PrivateChildsParents::select(['childs_code'])->where('parents_code', '=', $code)->get();
        if (json_decode($check2) == NULL) {
            return 'OK';
        } else {
            return 'DONT WORRY';
        }
    } else {
        return 'NEVER';
    }
}

# get info parents peserta by peserta code
function getInfoParentsPesertaByCode($kode_peserta = '')
{
    if ($kode_peserta) {
        $getParents = PrivateChildsParents::select(['parents_code'])->where('childs_code', '=', $kode_peserta)->get();
        if (json_decode($getParents) != NULL) {
            foreach ($getParents as $getPr) {
                $dataParents[] = User::select(['id', 'status', 'name', 'slug_name', 'born', 'phone', 'id_line', 'avatar'])->where('code', '=', $getPr->parents_code)->first();
            }
            return $dataParents;
        } else {
            # code...
        }
    } else {
        # code...
    }
}

# get info anak orang tua by code
function getInfoAnakWaliByCode($kode_wali = '')
{
    if ($kode_wali) {
        $getChilds = PrivateChildsParents::select(['childs_code'])->where('parents_code', '=', $kode_wali)->get();
        if (json_decode($getChilds) != NULL) {
            foreach ($getChilds as $getCh) {
                $dataChilds[] = User::select(['id', 'status', 'name', 'slug_name', 'born', 'phone', 'id_line', 'avatar'])->where('code', '=', $getCh->childs_code)->first();
            }
            if ($dataChilds[0] != NULL) {
                return $dataChilds;
            } else {
                return NULL;
            }
        } else {
            # code...
        }
    } else {
        # code...
    }
}
