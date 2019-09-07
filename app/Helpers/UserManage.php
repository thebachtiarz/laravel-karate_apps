<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\User;
use App\Kelas;
use App\Acc_class;
use App\Data_Peserta;
use App\Static_Budget;
use App\Static_File;
use App\Record_Latihan;
use App\Record_Budget;
use App\Record_File;
use App\Record_Spp;
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
# get kode_peserta anak by kode wali
function getPstCodeByWaliCode($kode_wali = '')
{
    if ($kode_wali) {
        $getChilds = PrivateChildsParents::select(['childs_code'])->where('parents_code', '=', $kode_wali)->get();
        if (json_decode($getChilds) != NULL) {
            foreach ($getChilds as $key) {
                $childsCode[] = $key->childs_code;
            }
            return $childsCode;
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

# create own profile timeline
function myProfileTimeline($code = '', $find_as = '')
{ // moderator, treasurer, instructor, participants, parents
    if ($code && $find_as) {
        # account status parents or api request
        if ($find_as == 'pelatih') {
            $getRecLatihan = Record_Latihan::select(['thsmt', 'kode_kelas_peserta', 'kode_peserta', 'kode_pelatih', 'keterangan', 'durasi', 'created_at'])->where('kode_pelatih', '=', $code)->groupBy('created_at')->get();
            (json_decode($getRecLatihan) != NULL) ? $recLatihan = $getRecLatihan->toArray() : $recLatihan = [];
            for ($i = 0; $i < count($recLatihan); $i++) {
                $recLatihan[$i] += ['type' => 'latihan']; // add type of data
            }
            $getRecBudget = Record_Budget::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'aggregate', 'kredit', 'keterangan', 'saldo', 'created_at'])->where('kode_pj', '=', $code)->get();
            if (json_decode($getRecBudget) != NULL) {
                $recBudget = $getRecBudget->toArray();
                for ($i = 0; $i < count($recBudget); $i++) {
                    $recBudget[$i] += ['type' => 'biaya']; // add type of data
                    array_push($recLatihan, $recBudget[$i]); // push array data $recBudget
                }
            }

            $getRecFile = Record_File::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'kode_file', 'file_info', 'created_at'])->where('kode_pj', '=', $code)->get();
            if (json_decode($getRecFile) != NULL) {
                $recFile = $getRecFile->toArray();
                for ($i = 0; $i < count($recFile); $i++) {
                    $recFile[$i] += ['type' => 'file']; // add type of data
                    array_push($recLatihan, $recFile[$i]); // push array data $recFile
                }
            }

            $getRecSpp = Record_Spp::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kredit', 'untuk_bulan', 'kode_pj', 'created_at'])->where('kode_pj', '=', $code)->get();
            if (json_decode($getRecSpp) != NULL) {
                $recSpp = $getRecSpp->toArray();
                for ($i = 0; $i < count($recSpp); $i++) {
                    $recSpp[$i] += ['type' => 'spp']; // add type of data
                    array_push($recLatihan, $recSpp[$i]); // push array data $recSpp
                }
            }

            function date_compare($txa1, $txa2)
            {
                $datetime1 = strtotime($txa1['created_at']);
                $datetime2 = strtotime($txa2['created_at']);
                return $datetime2 - $datetime1;
            }

            // Sort the array  
            usort($recLatihan, 'date_compare');
            // dd(json_encode($recLatihan));
            return createTimelineData($recLatihan);
        } elseif ($find_as == 'peserta') {
            # if $find_as is peserta, then $code must be array
            $getRecLatihan = Record_Latihan::select(['thsmt', 'kode_kelas_peserta', 'kode_peserta', 'kode_pelatih', 'keterangan', 'durasi', 'created_at'])->whereIn('thsmt', getThnSmtClassByCodeArray(getClassCodeByPstCodeArray($code)))->whereIn('kode_peserta', $code)->groupBy('created_at')->get();
            (json_decode($getRecLatihan) != NULL) ? $recLatihan = $getRecLatihan->toArray() : $recLatihan = [];
            for ($i = 0; $i < count($recLatihan); $i++) {
                $recLatihan[$i] += ['type' => 'latihan']; // add type of data
            }
            $getRecBudget = Record_Budget::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'aggregate', 'kredit', 'keterangan', 'saldo', 'created_at'])->whereIn('thsmt', getThnSmtClassByCodeArray(getClassCodeByPstCodeArray($code)))->whereIn('kode_peserta', $code)->get();
            if (json_decode($getRecBudget) != NULL) {
                $recBudget = $getRecBudget->toArray();
                for ($i = 0; $i < count($recBudget); $i++) {
                    $recBudget[$i] += ['type' => 'biaya']; // add type of data
                    array_push($recLatihan, $recBudget[$i]); // push array data $recBudget
                }
            }

            $getRecFile = Record_File::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'kode_file', 'file_info', 'created_at'])->whereIn('thsmt', getThnSmtClassByCodeArray(getClassCodeByPstCodeArray($code)))->whereIn('kode_peserta', $code)->get();
            if (json_decode($getRecFile) != NULL) {
                $recFile = $getRecFile->toArray();
                for ($i = 0; $i < count($recFile); $i++) {
                    $recFile[$i] += ['type' => 'file']; // add type of data
                    array_push($recLatihan, $recFile[$i]); // push array data $recFile
                }
            }

            $getRecSpp = Record_Spp::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kredit', 'untuk_bulan', 'kode_pj', 'created_at'])->whereIn('thsmt', getThnSmtClassByCodeArray(getClassCodeByPstCodeArray($code)))->whereIn('kode_peserta', $code)->get();
            if (json_decode($getRecSpp) != NULL) {
                $recSpp = $getRecSpp->toArray();
                for ($i = 0; $i < count($recSpp); $i++) {
                    $recSpp[$i] += ['type' => 'spp']; // add type of data
                    array_push($recLatihan, $recSpp[$i]); // push array data $recSpp
                }
            }

            function date_compare($txb1, $txb2)
            {
                $datetime1 = strtotime($txb1['created_at']);
                $datetime2 = strtotime($txb2['created_at']);
                return $datetime2 - $datetime1;
            }

            // Sort the array  
            usort($recLatihan, 'date_compare');
            // dd(json_encode($recLatihan));
            return createTimelineData($recLatihan);
        } else {
            # code...
        }
    } else {
        if ((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor')) {
            $getRecLatihan = Record_Latihan::select(['thsmt', 'kode_kelas_peserta', 'kode_peserta', 'kode_pelatih', 'keterangan', 'durasi', 'created_at'])->where('kode_pelatih', '=', auth()->user()->code)->groupBy('created_at')->get();
            (json_decode($getRecLatihan) != NULL) ? $recLatihan = $getRecLatihan->toArray() : $recLatihan = [];
            for ($i = 0; $i < count($recLatihan); $i++) {
                $recLatihan[$i] += ['type' => 'latihan']; // add type of data
            }
            if ((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer')) {
                $getRecBudget = Record_Budget::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'aggregate', 'kredit', 'keterangan', 'saldo', 'created_at'])->where('kode_pj', '=', auth()->user()->code)->get();
                if (json_decode($getRecBudget) != NULL) {
                    $recBudget = $getRecBudget->toArray();
                    for ($i = 0; $i < count($recBudget); $i++) {
                        $recBudget[$i] += ['type' => 'biaya']; // add type of data
                        array_push($recLatihan, $recBudget[$i]); // push array data $recBudget
                    }
                }

                $getRecFile = Record_File::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'kode_file', 'file_info', 'created_at'])->where('kode_pj', '=', auth()->user()->code)->get();
                if (json_decode($getRecFile) != NULL) {
                    $recFile = $getRecFile->toArray();
                    for ($i = 0; $i < count($recFile); $i++) {
                        $recFile[$i] += ['type' => 'file']; // add type of data
                        array_push($recLatihan, $recFile[$i]); // push array data $recFile
                    }
                }

                $getRecSpp = Record_Spp::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kredit', 'untuk_bulan', 'kode_pj', 'created_at'])->where('kode_pj', '=', auth()->user()->code)->get();
                if (json_decode($getRecSpp) != NULL) {
                    $recSpp = $getRecSpp->toArray();
                    for ($i = 0; $i < count($recSpp); $i++) {
                        $recSpp[$i] += ['type' => 'spp']; // add type of data
                        array_push($recLatihan, $recSpp[$i]); // push array data $recSpp
                    }
                }
            }
            // Comparision function 
            function date_compare($ty1, $element2)
            {
                $datetime1 = strtotime($ty1['created_at']);
                $datetime2 = strtotime($element2['created_at']);
                return $datetime2 - $datetime1;
            }

            // Sort the array  
            usort($recLatihan, 'date_compare');
            // dd($recLatihan);
            return createTimelineData($recLatihan);
        } elseif (auth()->user()->status == 'participants') {
            $getRecLatihan = Record_Latihan::select(['thsmt', 'kode_kelas_peserta', 'kode_peserta', 'kode_pelatih', 'keterangan', 'durasi', 'created_at'])->where('kode_peserta', '=', auth()->user()->code)->groupBy('created_at')->get();
            (json_decode($getRecLatihan) != NULL) ? $recLatihan = $getRecLatihan->toArray() : $recLatihan = [];
            for ($i = 0; $i < count($recLatihan); $i++) {
                $recLatihan[$i] += ['type' => 'latihan']; // add type of data
            }
            $getRecBudget = Record_Budget::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'aggregate', 'kredit', 'keterangan', 'saldo', 'created_at'])->where('kode_peserta', '=', auth()->user()->code)->get();
            if (json_decode($getRecBudget) != NULL) {
                $recBudget = $getRecBudget->toArray();
                for ($i = 0; $i < count($recBudget); $i++) {
                    $recBudget[$i] += ['type' => 'biaya']; // add type of data
                    array_push($recLatihan, $recBudget[$i]); // push array data $recBudget
                }
            }

            $getRecFile = Record_File::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'kode_file', 'file_info', 'created_at'])->where('kode_peserta', '=', auth()->user()->code)->get();
            if (json_decode($getRecFile) != NULL) {
                $recFile = $getRecFile->toArray();
                for ($i = 0; $i < count($recFile); $i++) {
                    $recFile[$i] += ['type' => 'file']; // add type of data
                    array_push($recLatihan, $recFile[$i]); // push array data $recFile
                }
            }

            $getRecSpp = Record_Spp::select(['thsmt', 'kode_kelas', 'kode_peserta', 'kredit', 'untuk_bulan', 'kode_pj', 'created_at'])->where('kode_peserta', '=', auth()->user()->code)->get();
            if (json_decode($getRecSpp) != NULL) {
                $recSpp = $getRecSpp->toArray();
                for ($i = 0; $i < count($recSpp); $i++) {
                    $recSpp[$i] += ['type' => 'spp']; // add type of data
                    array_push($recLatihan, $recSpp[$i]); // push array data $recSpp
                }
            }

            function date_compare($tz1, $tz2)
            {
                $datetime1 = strtotime($tz1['created_at']);
                $datetime2 = strtotime($tz2['created_at']);
                return $datetime2 - $datetime1;
            }

            // Sort the array  
            usort($recLatihan, 'date_compare');
            // dd(json_encode($recLatihan));
            return createTimelineData($recLatihan);
        } else {
            # code...
        }
    }
}
# random color
function getRandColor()
{
    return Arr::random(['light-blue', 'aqua', 'green', 'yellow', 'red', 'navy', 'teal', 'purple', 'orange', 'maroon']);
}
# new date array timeline
function newDateArrayTimeline($date)
{
    return '<li class="time-label"><span class="bg-' . getRandColor() . '">' . conv_getDate($date) . '</span></li>';
}
# crate body timeline by type
function createBodyTimelineByType($data_body)
{
    if ($data_body['type'] == 'latihan') { //'thsmt', 'kode_kelas_peserta', 'kode_peserta', 'kode_pelatih', 'keterangan', 'durasi', 'created_at'
        $makeID = Str::random(9);
        return '
        <li>
            <i class="fa fa-running bg-' . getRandColor() . '"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> ' . conv_getTime($data_body['created_at']) . '</span>
                <h3 class="timeline-header">' . getClassNameByCode($data_body['kode_kelas_peserta']) . '</h3>
                <div class="timeline-body">
                    <p><i class="fas fa-info-circle fa-sm"></i>&ensp;' . getKetLatihanByCode($data_body['keterangan']) . '</p>
                    <p><i class="fas fa-user-secret fa-sm"></i>&ensp;' . getNamePltByCode($data_body['kode_pelatih']) . '&ensp;<span class="label label-primary">Pelatih</span></p>
                    <p><i class="fas fa-clock-o fa-sm"></i>&ensp;' . $data_body['durasi'] . ' Jam</p>
                </div>
                <div class="timeline-footer" id="btntraindetail-' . $makeID . '">
                    <button class="btn btn-primary btn-xs showDetailTrainButton" id="openbutton-' . $makeID . '" data-goto="' . $makeID . '" data-unhide="hidebutton-' . $makeID . '" data-datetime="' . $data_body['created_at'] . '" data-kelas="' . $data_body['kode_kelas_peserta'] . '">Lihat Detail Peserta</button>
                    <button class="btn btn-warning btn-xs hideDetailTrainButton displayHidden" id="hidebutton-' . $makeID . '" data-goto="' . $makeID . '" data-unhide="openbutton-' . $makeID . '">Sembunyikan</button>
                </div>
                <div class="timeline-body displayHidden" id="' . $makeID . '"></div>
            </div>
        </li>';
    } elseif ($data_body['type'] == 'biaya') { //'thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'aggregate', 'kredit', 'keterangan', 'saldo', 'created_at'
        $userAuth = ((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor')) ? '<i class="fas fa-user-tie fa-sm"></i>&ensp;' . getNamePstByCode($data_body['kode_peserta']) : '<i class="fas fa-user-secret fa-sm"></i>&ensp;' . getNamePltByCode($data_body['kode_pj']) . '&ensp;<span class="label label-primary">Pelatih</span>';
        $userStat = (auth()->user()->status == 'parents') ? '<p><i class="fas fa-user-tie fa-sm"></i>&ensp;' . getNamePstByCode($data_body['kode_peserta']) . '&ensp;<span class="label label-success">Peserta</span></p>' : '';
        $ketAggregate = ($data_body['aggregate'] == '+') ? '<i class="fa fa-plus fa-sm"></i>&ensp;' : '<i class="fa fa-minus fa-sm"></i>&ensp;';
        return '
        <li>
            <i class="fa fa-file-invoice-dollar bg-' . getRandColor() . '"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> ' . conv_getTime($data_body['created_at']) . '</span>
                <h3 class="timeline-header">' . getClassNameByCode($data_body['kode_kelas']) . '</h3>
                <div class="timeline-body">
                    <p><i class="fas fa-info-circle fa-sm"></i>&ensp;' . $data_body['keterangan'] . '</p>
                    <p>' . $userAuth . '</p>' . $userStat . '
                    <p>' . $ketAggregate . ' Rp. ' . mycurrency($data_body['kredit']) . '</p>
                </div>
            </div>
        </li>';
    } elseif ($data_body['type'] == 'file') { //'thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'kode_file', 'file_info', 'created_at'
        $userAuth = ((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor')) ? '<i class="fas fa-user-tie fa-sm"></i>&ensp;' . getNamePstByCode($data_body['kode_peserta']) : '<i class="fas fa-user-secret fa-sm"></i>&ensp;' . getNamePltByCode($data_body['kode_pj']) . '&ensp;<span class="label label-primary">Pelatih</span>';
        $userStat = (auth()->user()->status == 'parents') ? '<p><i class="fas fa-user-tie fa-sm"></i>&ensp;' . getNamePstByCode($data_body['kode_peserta']) . '&ensp;<span class="label label-success">Peserta</span></p>' : '';
        return '
        <li>
            <i class="fa fa-archive bg-' . getRandColor() . '"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> ' . conv_getTime($data_body['created_at']) . '</span>
                <h3 class="timeline-header">' . getClassNameByCode($data_body['kode_kelas']) . '</h3>
                <div class="timeline-body">
                    <p><i class="fas fa-info-circle fa-sm"></i>&ensp;Pengumpulan Berkas Ujian</p>
                    <p>' . $userAuth . '</p>' . $userStat . '
                    <p><i class="fas fa-archive fa-sm"></i>&ensp;Jenis : ' . getFileInfoByCode($data_body['kode_file']) . '</p>
                    <p><i class="fas fa-file-alt fa-sm"></i>&ensp;Keterangan : ' . $data_body['file_info'] . '</p>
                </div>
            </div>
        </li>';
    } elseif ($data_body['type'] == 'spp') { //'thsmt', 'kode_kelas', 'kode_peserta', 'kredit', 'untuk_bulan', 'kode_pj', 'created_at'
        $userAuth = ((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor')) ? '<i class="fas fa-user-tie fa-sm"></i>&ensp;' . getNamePstByCode($data_body['kode_peserta']) : '<i class="fas fa-user-secret fa-sm"></i>&ensp;' . getNamePltByCode($data_body['kode_pj']) . '&ensp;<span class="label label-primary">Pelatih</span>';
        $userStat = (auth()->user()->status == 'parents') ? '<p><i class="fas fa-user-tie fa-sm"></i>&ensp;' . getNamePstByCode($data_body['kode_peserta']) . '&ensp;<span class="label label-success">Peserta</span></p>' : '';
        return '
        <li>
            <i class="fa fa-dollar-sign bg-' . getRandColor() . '"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> ' . conv_getTime($data_body['created_at']) . '</span>
                <h3 class="timeline-header">' . getClassNameByCode($data_body['kode_kelas']) . '</h3>
                <div class="timeline-body">
                    <p><i class="fas fa-info-circle fa-sm"></i>&ensp;Pembayaran SPP ' . makeSubstrFromThSmt($data_body['thsmt']) . ' - ' . getMonth($data_body['untuk_bulan']) . '</p>
                    <p>' . $userAuth . '</p>' . $userStat . '
                    <p><i class="fa fa-plus fa-sm"></i>&ensp; Rp. ' . mycurrency($data_body['kredit']) . '</p>
                </div>
            </div>
        </li>';
    } else {
        # code...
    }
}
# start create timeline with function
function createTimelineData($recLatihan)
{
    $timelinemaster = '<ul class="timeline timeline-inverse">';
    for ($i =  0; $i < (int) count($recLatihan); $i++) {
        if ($i < 1) {
            # array tanggal pertama
            $timelinemaster .= newDateArrayTimeline($recLatihan[$i]['created_at']);
            $timelinemaster .= createBodyTimelineByType($recLatihan[$i]);
        } else {
            if (conv_getDate($recLatihan[$i]['created_at']) == conv_getDate($recLatihan[$i - 1]['created_at'])) {
                # masuk array dalam tanggal yang sama
                $timelinemaster .= createBodyTimelineByType($recLatihan[$i]);
            } else {
                # buat array tanggal baru
                $timelinemaster .= newDateArrayTimeline($recLatihan[$i]['created_at']);
                $timelinemaster .= createBodyTimelineByType($recLatihan[$i]);
            }
        }
    }
    $timelinemaster .= '<li><i class="fa fa-clock-o bg-' . getRandColor() . '"></i> </li></ul>';
    return $timelinemaster;
}
## end of create timeline with function
