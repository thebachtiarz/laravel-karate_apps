<?php

use Illuminate\Support\Facades\DB;
use App\User;
use App\Kelas;
use App\Data_Peserta;
use App\Record_Budget;
use App\Static_Budget;
use App\Record_File;
use App\Static_File;
use App\Record_Latihan;
use App\Record_Latihan_Info;
use App\Record_Spp;

# functions
function getMonth($month = '')
{
    $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return $bulan[$month - 1];
}
function conv_date($date)
{
    $bulan = array(
        1 =>
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $exp = explode('-', $date);

    return $exp[2] . ' ' . $bulan[(int) $exp[1]] . ' ' . $exp[0];
}

function conv_getDate($datetime = '')
{
    if ($datetime) {
        $date = conv_date(date('Y-m-d',  strtotime($datetime)));
        return $date;
    } else {
        # nothing
    }
}

function conv_datetime($datetime = '')
{
    if ($datetime) {
        $date = conv_date(date('Y-m-d',  strtotime($datetime)));
        $time = date('H:i:s',  strtotime($datetime));
        return $date . ' ' . $time;
    } else {
        # nothing
    }
}

function get_belt_by_kyu($kyu = '')
{
    if ($kyu) {
        switch ($kyu) {
            case '10':
                return 'Putih';
            case '9':
                return 'Putih';
            case '8':
                return 'Kuning';
            case '7':
                return 'Oranye';
            case '6':
                return 'Hijau';
            case '5':
                return 'Biru I';
            case '4':
                return 'Biru II';
            case '3':
                return 'Coklat I';
            case '2':
                return 'Coklat II';
            case '1':
                return 'Coklat III';
            default:
                return 'Tidak dapat mendefinisikan Kyu';
        }
    } else {
        # null
    }
}

function mycurrency($currency = '')
{
    if ($currency) {
        if ($currency != 0) {
            return number_format($currency, 0, ".", ",");
        } else {
            return "0";
        }
    } else {
        # null
    }
}

function get_randChar($length = '')
{
    if ($length) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }
        return $string;
    } else {
        # nothing
    }
}

# end of functions

# helper for apps

# get user avatar for navbar
function getUserAvatar()
{
    $avatar = DB::table('users')->select('avatar')->where('id', '=', auth()->user()->id)->get();
    if ($avatar != null) {
        foreach ($avatar as $avt) {
            $image = $avt->avatar;
        }
        if (!$image) {
            return asset('images/avatar/default.jpg');
        }
        return asset($image);
    }
}

# get user avatar for biodata
function getAvatarUserById($id = '')
{
    if ($id) {
        $avatar = User::select(['avatar'])->where('id', '=', $id)->first();
        if ($avatar != null) {
            $image = $avatar['avatar'];
            if (!$image) {
                return asset('images/avatar/default.jpg');
            }
            return asset($image);
        }
    }
}

# get user avatar by code
function getAvatarUserByCode($code = '')
{
    if ($code) {
        $avatar = User::select(['avatar'])->where('code', '=', $code)->first();
        if ($avatar != null) {
            $image = $avatar['avatar'];
            if (!$image) {
                return asset('images/avatar/default.jpg');
            }
            return asset($image);
        }
    }
}

# get user avatar by email
function getAvatarUserByEmail($email = '')
{
    if ($email) {
        $avatar = User::select(['avatar'])->where('email', '=', $email)->first();
        if ($avatar != null) {
            $image = $avatar['avatar'];
            if (!$image) {
                return asset('images/avatar/default.jpg');
            }
            return asset($image);
        }
    }
}

# get slugname account by code
function getSlugnameByCode($code = '')
{
    if ($code) {
        $data = User::select(['slug_name'])->where('code', '=', $code)->first();
        if ($data != null) {
            $slugname = $data['slug_name'];
            if (!$slugname) {
                return 'name not found!!';
            }
            return $slugname;
        }
    }
}
# get slugname account by email
function getSlugnameByEmail($email = '')
{
    if ($email) {
        $data = User::select(['slug_name'])->where('email', '=', $email)->first();
        if ($data != null) {
            $slugname = $data['slug_name'];
            if (!$slugname) {
                return 'name not found!!';
            }
            return $slugname;
        }
    }
}

# get status user by id
function getStatusUserById($stat = '')
{
    if ($stat) {
        if ($stat == 'bestnimda') {
            return "Administrator";
        } elseif ($stat == 'moderator') {
            return "Pengurus Ranting";
        } elseif ($stat == 'treasurer') {
            return "Bendahara";
        } elseif ($stat == 'instructor') {
            return "Pelatih";
        } elseif ($stat == 'participants') {
            return "Peserta";
        } elseif ($stat == 'parents') {
            return "Orang Tua";
        } elseif ($stat == 'guests') {
            return "Tamu";
        } else {
            return "User Gak Jelas";
        }
    } else {
        return redirect()->route('home');
    }
}

# get status user by code
function getStatusUserByCode($code = '')
{
    if ($code) {
        $data = User::select(['status'])->where('code', '=', $code)->first();
        if ($data != NULL) {
            return getStatusUserById($data->status);
        } else {
            # code...
        }
    } else {
        # code...
    }
}

# conv status user to index
function convStatUserToIndex($stat = '')
{
    if ($stat) {
        if ($stat == 'bestnimda') {
            return "7";
        } elseif ($stat == 'moderator') {
            return "6";
        } elseif ($stat == 'treasurer') {
            return "5";
        } elseif ($stat == 'instructor') {
            return "4";
        } elseif ($stat == 'participants') {
            return "3";
        } elseif ($stat == 'parents') {
            return "2";
        } elseif ($stat == 'guests') {
            return "1";
        } else {
            return "User Gak Jelas";
        }
    } else {
        return redirect()->route('home');
    }
}
# conv to status name
function convStatUserToStatName($index = '')
{
    if ($index) {
        if ($index == '7') {
            return "bestnimda";
        } elseif ($index == '6') {
            return "moderator";
        } elseif ($index == '5') {
            return "treasurer";
        } elseif ($index == '4') {
            return "instructor";
        } elseif ($index == '3') {
            return "participants";
        } elseif ($index == '2') {
            return "parents";
        } elseif ($index == '1') {
            return "guests";
        } else {
            return "User Gak Jelas";
        }
    } else {
        return redirect()->route('home');
    }
}

# get kelas avatar
function getKelasAvatar($key = '')
{
    if ($key) {
        $avatar = DB::table('kelas_data')->select('avatar')->where('kode_kelas', '=', $key)->get();
        if ($avatar != null) {
            foreach ($avatar as $avt) {
                $image = $avt->avatar;
            }
            if (!$image) {
                return asset('images/room/default.jpg');
            }
            return asset('') . '/' . $image;
        }
    } else {
        # code...
    }
}

# get count of users in user table
function getCountUserTable()
{
    return User::whereNotIn('status', ['bestnimda', 'guests'])->count();
}

# get count of guest (new user)
function getCountOfNewGuests()
{
    return User::where('status', ['guests'])->count();
}

# get count of all class in kelas table
function getCountOfClassTable()
{
    return Kelas::count();
}

# get account name by code
function getAccountNameByCode($code = '')
{
    if ($code) {
        $data = User::select(['name'])->where('code', '=', $code)->first();
        return $data['name'];
    } else {
        # code...
    }
}

# get pelatih name by code
function getNamePltByCode($code = '')
{
    if ($code) {
        $data = DB::table('pelatih_data')->select('nama_pelatih')->where('kode_pelatih', '=', $code)->get();
        if (!$data) {
            return "Pelatih Tidak Dikenal";
        }
        foreach ($data as $dt) {
            return $dt->nama_pelatih;
        }
    } else {
        return "Pelatihnya Siapa?";
    }
}

# get peserta name by code
function getNamePstByCode($kode_peserta = '')
{
    if ($kode_peserta) {
        $data = DB::table('peserta_data')->select('nama_peserta')->where('kode_peserta', '=', $kode_peserta)->get();
        foreach ($data as $dt) {
            return $dt->nama_peserta;
        }
    } else {
        return "no name";
    }
}

# get class name by code
function getClassNameByCode($class_code = '')
{
    if ($class_code) {
        $data = Kelas::select('nama_kelas')->where('kode_kelas', '=', $class_code)->first();
        if ($data) {
            return $data->nama_kelas;
        }
        return "Kelas Tidak Dikenal";
    } else {
        return "Kelas Tidak Dikenal";
    }
}

# get class code by peserta code
function getClassCodeByPstCode($kode_peserta = '')
{
    if ($kode_peserta) {
        $data = Data_Peserta::select(['kode_kelas_peserta'])->where('kode_peserta', '=', $kode_peserta)->first();
        return $data['kode_kelas_peserta'];
    } else {
        # code...
    }
}

# get peserta name by email
function getPstNameByEmail($email = '')
{
    if ($email) {
        $data = User::select(['name'])->where('email', '=', $email)->first();
        if ($data) {
            return $data['name'];
        }
        return "Akun Tidak Dikenal";
    } else {
        return "Akun Tidak Dikenal";
    }
}

# get kyu peserta
function getKyuPeserta()
{
    $data = Data_Peserta::select(['tingkat'])->where('kode_peserta', '=', auth()->user()->code)->first();
    return $data['tingkat'];
}

# get keterangan latihan by code
function getKetLatihanByCode($code = '')
{
    if ($code) {
        $data = Record_Latihan_Info::select(['keterangan'])->where('kode_info', '=', $code)->first();
        return $data->keterangan;
    } else {
        return "Keterangan Tidak Ditemukan";
    }
}

# get keterangan pembayaran ujian by code peserta and code kelas
function getKeteranganPaymentExamnByCodeAndClass($class_code = '', $kode_peserta = '')
{
    if ($class_code && $kode_peserta) {
        $saldo = 'Saldo Rp. ' . mycurrency(get_lastSaldoUser_by_code($class_code, $kode_peserta)) . ',-&ensp;';
        $biaya = 'Biaya Ujian Rp. ' . mycurrency(getCostExamnPstByClassAndCode($class_code, $kode_peserta)) . ',-&ensp;';
        if (get_lastSaldoUser_by_code($class_code, $kode_peserta) < getCostExamnPstByClassAndCode($class_code, $kode_peserta)) {
            echo $saldo . $biaya;
            echo '<font class="text-danger" style="font-weight: bold;">Kurang Rp. ' . mycurrency(getExamnLessPaymentPst(getCostExamnPstByClassAndCode($class_code, $kode_peserta), get_lastSaldoUser_by_code($class_code, $kode_peserta))) . ',-</font>';
        } elseif (get_lastSaldoUser_by_code($class_code, $kode_peserta) > getCostExamnPstByClassAndCode($class_code, $kode_peserta)) {
            echo $saldo . $biaya;
            echo '<font class="text-success" style="font-weight: bold;">Lebih Rp. ' . mycurrency(getExamnMorePaymentPst(getCostExamnPstByClassAndCode($class_code, $kode_peserta), get_lastSaldoUser_by_code($class_code, $kode_peserta))) . ',-</font>&emsp;';
            echo '<a href="/kelas/record/persyaratan/cashback?class_code=' . $class_code . '&kode_peserta=' . $kode_peserta . '" class="btn btn-success cashback-examn">Kembalikan</a>';
        } else {
            if (get_lastSaldoUser_by_code($class_code, $kode_peserta) == 0) {
                // echo 'Bayar Wae Durung Kok Iso Lunas!!';
            } else {
                echo '<font class="text-primary" style="font-weight: bold;">Biaya Ujian Lunas!!</font>';
            }
        }
    } else {
        return "Keterangan Biaya Tidak Ditemukan";
    }
}

# get count of peserta by class
function getCountPesertaByClassCode($class_code = '')
{
    if ($class_code) {
        return DB::table('peserta_data')->where('kode_kelas_peserta', '=', $class_code)->count();
    } else {
        # null
    }
}

# get count peserta in class
function getCountPstInClass($class_code = '')
{
    if ($class_code) {
        return DB::table('peserta_data')->where('kode_kelas_peserta', '=', $class_code)->count();
    } else {
        # code...
    }
}

# get count pelatih in class
function getCountPltInClass($class_code = '')
{
    if ($class_code) {
        return DB::table('acc_class')->where('kode_kelas', '=', $class_code)->count();
    } else {
        # code...
    }
}

# get thsmt now #THIS_IS_VALID
function getThSmtNow()
{
    $thn = date('y');
    $bln = date('m');
    if ($bln >= 1 && $bln <= 6) {
        $thsmt = ($thn - 1) . $thn . '02';
    } elseif ($bln >= 7 && $bln <= 12) {
        $thsmt = $thn . ($thn + 1) . '01';
    } else {
        $thsmt = '';
    }
    return $thsmt;
}

# create thsmt info
function createThSmtInfoPeserta($thsmt = '', $code_peserta = '')
{
    if ($thsmt) {
        return makeSubstrFromThSmt($thsmt);
    } else {
        if ($code_peserta) {
            return makeSubstrFromThSmt(getThnSmtClassByCode(getClassCodeByPstCode($code_peserta)));
        } else {
            return makeSubstrFromThSmt(getThnSmtClassByCode(getClassCodeByPstCode(auth()->user()->code)));
        }
    }
}

# get percentation training
function getTimeTrainClassByCode($class_code = '')
{
    if ($class_code) {
        $data = DB::table('kelas_data')->select('durasi_latihan')->where('kode_kelas', '=', $class_code)->get();
        foreach ($data as $dt) {
            return $dt->durasi_latihan;
        }
    } else {
        # code...
    }
}

function getSumTrainPstByCode($kode_peserta = '', $thsmt = '')
{
    if ($kode_peserta) {
        if ($thsmt) {
            $data = DB::table('record_latihan')->select(DB::raw('SUM(durasi) as total_latihan'))->where([['kode_peserta', '=', $kode_peserta], ['thsmt', '=', $thsmt]])->get();
        } else {
            $data = DB::table('record_latihan')->select(DB::raw('SUM(durasi) as total_latihan'))->where([['kode_peserta', '=', $kode_peserta], ['thsmt', '=', getThnSmtClassByCode(getClassCodeByPstCode($kode_peserta))]])->get();
        }
        foreach ($data as $dt) {
            if ($dt->total_latihan) {
                return $dt->total_latihan;
            } else {
                return "0";
            }
        }
    } else {
        # code...
    }
}

function getPercentTrainPstByClassAndCode($class_code = '', $kode_peserta = '', $thsmt = '')
{
    if ($class_code && $kode_peserta) {
        $trainReq = getTimeTrainClassByCode($class_code);
        $trainSum = getSumTrainPstByCode($kode_peserta, $thsmt);
        $grandsum = (($trainSum / $trainReq) * 100);
        if ($grandsum > 0) {
            return (float) number_format($grandsum, 2);
        } else {
            return '';
        }
    } else {
        # code...
    }
}
# end of get percentation training

# create progress training bar by code peserta
function getProgresTrainBarByCodePst($class_code = '', $kode_peserta = '', $thsmt = '')
{
    if ($class_code && $kode_peserta) {
        $get_data = getPercentTrainPstByClassAndCode($class_code, $kode_peserta, $thsmt);
        if (!is_string($get_data)) {
            if (($get_data >= 0) && ($get_data < 25)) {
                $stat = 'danger';
            } elseif (($get_data >= 25) && ($get_data < 50)) {
                $stat = 'warning';
            } elseif (($get_data >= 50) && ($get_data < 75)) {
                $stat = 'info';
            } elseif (($get_data >= 75) && ($get_data <= 100)) {
                $stat = 'success';
            } else {
                return 'Sangat Rajin Latihan!';
            }
            echo '<div class="progress"><div class="progress-bar progress-bar-' . $stat . ' progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: ' . $get_data . '%;" aria-valuenow="' . $get_data . '">' . $get_data . ' %</div></div>';
        } else {
            return $get_data;
        }
    } else {
        # code...
    }
}

# get record saldo balance peserta by class and code
function getSaldoBalancePstByClassAndCode($class_code = '', $kode_peserta = '', $thsmt = '')
{
    if ($class_code && $kode_peserta) {
        if ($thsmt) {
            $record_balance = DB::table('peserta_req_budget')->where([['kode_kelas', '=', $class_code], ['kode_peserta', '=', $kode_peserta], ['thsmt', '=', $thsmt]])->orderBy('created_at', 'asc')->get();
        } else {
            $record_balance = DB::table('peserta_req_budget')->where([['kode_kelas', '=', $class_code], ['kode_peserta', '=', $kode_peserta], ['thsmt', '=', getThnSmtClassByCode($class_code)]])->orderBy('created_at', 'asc')->get();
        }

        if (json_decode($record_balance) != NULL) {
            $no = 1;
            foreach ($record_balance as $key) {
                echo '
				<tr>
				<td class="text-center align-middle">' . $no . '</td>
				<td class="text-center align-middle">' . conv_datetime($key->created_at) . '</td>
				<td class="text-right align-middle">' . $key->aggregate . '&ensp;Rp. ' . mycurrency($key->kredit) . '</td>
				<td class="text-center align-middle">' . $key->keterangan . '</td>
				<td class="text-right align-middle">Rp. ' . mycurrency($key->saldo) . '</td>
				<td class="text-center align-middle">' . getNamePltByCode($key->kode_pj) . '</td>
				</tr>
				';
                $no++;
            }
        } else {
            return '<td colspan="6" class="text-center align-middle alert-danger">Belum Memiliki Record Pembayaran</td>';
        }
    } else {
        return '<td colspan="6" class="text-center align-middle alert-danger">Peserta Tidak Terdaftar!!</td>';
    }
}

# get last saldo peserta by class and code
function get_lastSaldoUser_by_code($class_code = '', $kode_peserta = '')
{
    if ($class_code && $kode_peserta) {
        $data = DB::table('peserta_req_budget')->select('saldo')->where([['thsmt', '=', getThnSmtClassByCode($class_code)], ['kode_kelas', '=', $class_code], ['kode_peserta', '=', $kode_peserta], ['thsmt', '=', getThnSmtClassByCode($class_code)]])->orderBy('id', 'desc')->limit(1)->get();
        if (json_decode($data) != NULL) {
            foreach ($data as $key) {
                return $key->saldo;
            }
        } else {
            return 0;
        }
    } else {
        # nothing
    }
}

# post a new saldo peserta, increase last saldo and new credit
function post_newSaldoUser_by_code($class_code = '', $kode_peserta = '', $credit = '')
{
    if ($class_code && $kode_peserta && $credit) {
        return (get_lastSaldoUser_by_code($class_code, $kode_peserta) + $credit);
    } else {
        # nothing
    }
}
# post a new saldo peserta, decrease last saldo and new credit
function post_decSaldoUser_by_code($class_code = '', $kode_peserta = '', $credit = '')
{
    if ($class_code && $kode_peserta && $credit) {
        return (get_lastSaldoUser_by_code($class_code, $kode_peserta) - $credit);
    } else {
        # nothing
    }
}

# get tingkat peserta by code
function getPstTingkatByCode($kode_peserta = '')
{
    if ($kode_peserta) {
        $data = Data_Peserta::select('tingkat')->where('kode_peserta', '=', $kode_peserta)->first();
        if (json_decode($data) != NULL) {
            return $data->tingkat;
        } else {
            # code...
        }
    } else {
        # code...
    }
}

# get cost examn peserta by class and code
function getCostExamnPstByClassAndCode($class_code = '', $kode_peserta = '', $thsmt = '')
{
    if ($class_code && $kode_peserta) {
        $getTingkatPst = getPstTingkatByCode($kode_peserta);
        if ($thsmt) {
            $getCost = Static_Budget::select('biaya_ujian')->where([['kode_kelas', '=', $class_code], ['tingkat', '=', $getTingkatPst], ['thsmt', '=', $thsmt]])->first();
        } else {
            $getCost = Static_Budget::select('biaya_ujian')->where([['kode_kelas', '=', $class_code], ['tingkat', '=', $getTingkatPst], ['thsmt', '=', getThnSmtClassByCode($class_code)]])->first();
        }
        if (json_decode($getCost) != NULL) {
            return $getCost->biaya_ujian;
        } else {
            return 0;
        }
    } else {
        # code...
    }
}

# get payment less examn peserta by class
function getExamnLessPaymentPst($class_cost_examn = '', $user_saldo = '')
{
    if ($class_cost_examn && $user_saldo) {
        return ($class_cost_examn - $user_saldo);
    } else {
        # code...
    }
}

# get payment more examn peserta by class
function getExamnMorePaymentPst($class_cost_examn = '', $user_saldo = '')
{
    if ($class_cost_examn && $user_saldo) {
        return ($user_saldo - $class_cost_examn);
    } else {
        # code...
    }
}

# get File Examn Info By Code
function getFileInfoByCode($code = '')
{
    if ($code) {
        $data = DB::table('static_req_file')->where('kode_file', '=', $code)->get();
        if (json_decode($data) != NULL) {
            foreach ($data as $key) {
                return $key->nama_file;
            }
        } else {
            return 'Jenis tidak dikenal';
        }
    } else {
        # nothing
    }
}

# get record file examn peserta by class and code
function getRecFileExamnPstByClassAndCode($class_code = '', $kode_peserta = '', $thsmt = '')
{
    if ($class_code && $kode_peserta) {
        if ($thsmt) {
            $data = DB::table('peserta_req_file')->where([['kode_kelas', '=', $class_code], ['kode_peserta', '=', $kode_peserta], ['thsmt', '=', $thsmt]])->get();
        } else {
            $data = DB::table('peserta_req_file')->where([['kode_kelas', '=', $class_code], ['kode_peserta', '=', $kode_peserta], ['thsmt', '=', getThnSmtClassByCode($class_code)]])->get();
        }

        if (json_decode($data) != NULL) {
            $no = 1;
            foreach ($data as $key) {
                echo '
				<tr>
				<td class="text-center align-middle">' . getFileInfoByCode($key->kode_file) . '</td>
				<td class="text-center align-middle">' . conv_datetime($key->created_at) . '</td>
				<td class="text-left align-middle">' . $key->file_info . '</td>
				<td class="text-center align-middle">' . getNamePltByCode($key->kode_pj) . '</td>
				</tr>
				';
                $no++;
            }
        } else {
            return '<td colspan="4" class="text-center align-middle alert-danger">Belum Mengumpulkan Persyaratan</td>';
        }
    } else {
        return '<td colspan="4" class="text-center align-middle alert-danger">Peserta Tidak Terdaftar</td>';
    }
}

# get examn file requirement by code peserta which files that have not been collected
function getExamnFileReqHaveNotBeenCollectedByCodePst($class_code = '', $kode_peserta = '', $error_msg = '')
{
    if ($class_code && $kode_peserta) {
        $opt = DB::select('select * from static_req_file WHERE kode_kelas = :kode_req_kelas AND kode_file not in(select kode_file from peserta_req_file where kode_kelas = :kode_kelas AND kode_peserta = :kode_peserta AND thsmt = :thsmt)', ['kode_req_kelas' => $class_code, 'kode_kelas' => $class_code, 'kode_peserta' => $kode_peserta, 'thsmt' => getThnSmtClassByCode($class_code)]);

        if ($opt) {
            foreach ($opt as $key) {
                $selected = ($error_msg == $key->kode_file) ? 'selected' : '';
                echo '<option value="' . $key->kode_file . '" ' . $selected . '>' . $key->nama_file . '</option>';
            }
        } else {
            return '<option value=" " disabled=" " selected hidden=" ">Persyaratan Belum Tersedia</option>';
        }
    } else {
        return '<option value=" " disabled=" " selected hidden=" ">Peserta tidak dikenal</option>';
    }
}

# get record spp peserta by class and code
function getRecSppPstByClassAndCode($class_code = '', $kode_peserta = '')
{
    if ($class_code && $kode_peserta) {
        return Record_Spp::where([['kode_kelas', '=', $class_code], ['kode_peserta', '=', $kode_peserta]])->orderBy('created_at', 'desc')->get();
    } else {
        # code...
    }
}
# make in table tbody
function getRecSppPstByClassAndCodeInTbody($class_code = '', $kode_peserta = '')
{
    if ($class_code && $kode_peserta) {
        $getRecSpp = getRecSppPstByClassAndCode($class_code, $kode_peserta);
        if (json_decode($getRecSpp) != NULL) {
            $i = 1;
            foreach ($getRecSpp as $rec) {
                echo ($i == 1) ? '<tr style="background-color: #D4EDDA; color: #3E774B;">' : '<tr>';
                $flag = ($i == 1) ? '<i class="fab fa-font-awesome-flag fa-xs"></i>' : $i;
                echo '<td class="text-center">' . $flag . '</td><td class="text-center">' . conv_datetime($rec->created_at) . '</td><td class="text-center">Rp. ' . mycurrency($rec->kredit) . '</td><td class="text-center"> Pembayaran SPP ' . makeSubstrFromThSmt($rec->thsmt) . ' - ' . getMonth($rec->untuk_bulan) . '</td><td class="text-center">' . getNamePltByCode($rec->kode_pj) . '</td></tr>';
                $i++;
            }
        } else {
            echo '<tr><td colspan="5" class="text-center alert-danger" style="font-weight: bold;">Tidak Ada Record SPP</td></tr>';
        }
    } else {
        # code...
    }
}

# create breadcrumb by passing an array of code
function createBreadcrumbByArrayOfCode($array_code)
{
    if (is_array($array_code)) {
        $sliced = array_slice($array_code, 0, -1);
        $countcode = count($array_code) - 1;
        $first = current($array_code);
        $end = end($array_code);
        // start creating breadcrumb
        echo '<ol class="breadcrumb">';
        echo '<li><a href="/home"><i class="fas fa-home"></i> Home</a></li>';
        if (count($array_code) > 0) {
            echo '<li class="breadcrumb-item"><a href="/' . $first . '">' . ucwords($first) . '</a></li>';
        }
        if (count($array_code) > 1) {
            for ($i = 1; $i < $countcode; $i++) {
                if (strlen($sliced[$i]) > 10) {
                    $userName = (getAccountNameByCode($sliced[$i])) ? getAccountNameByCode($sliced[$i]) : getNamePstByCode($sliced[$i]) . getNamePltByCode($sliced[$i]);
                    echo '<li class="breadcrumb-item active" aria-current="page">' . $userName . '</li>';
                } else {
                    echo '<li class="breadcrumb-item active" aria-current="page"><a href="/kelas/record/' . Request::segment(3) . '?key=' . $sliced[$i] . '">' . getClassNameByCode($sliced[$i]) . '</a></li>';
                }
            }

            if (strlen($end) > 10) {
                $userName = (getAccountNameByCode($end)) ? getAccountNameByCode($end) : getNamePstByCode($end) . getNamePltByCode($end);
                echo '<li class="breadcrumb-item active" aria-current="page">' . $userName . '</li>';
            } else {
                echo '<li class="breadcrumb-item active" aria-current="page">' . getClassNameByCode($end) . '</li>';
            }
        }
        echo '</ol>';
        // finish create breadcrumb
    } else {
        return 'FAIL';
    }
}

# create option for get semester for search #NOT_USE
function createOptionSemesterForSearch()
{
    $year = date('y');
    if (isset($_GET['thsmt'])) {
        $thsmt = $_GET['thsmt'];
    } else {
        $thsmt = '';
    }

    $opt = '';
    //  ambil 3 tahun ke belakang
    for ($p = 3; $p >= 1; $p--) {
        $thnp = $year - $p;
        // $retVal = ($thsmt == ($thnp - 1) . $thnp . '02') ? ' selected ' : '';
        $opt .= '<option value="' . ($thnp - 1) . $thnp . '02">Th. 20' . ($thnp - 1) . '/20' . $thnp . ' - Smt. 2</option>';
        $opt .= '<option value="' . $thnp . ($thnp + 1) . '01">Th. 20' . $thnp . '/20' . ($thnp + 1) . ' - Smt. 1</option>';
    }
    //  ambil tahun sekarang
    $opt .= '<option value="' . ($year - 1) . $year . '02">Th. 20' . ($year - 1) . '/20' . $year . ' - Smt. 2</option>';
    $opt .= '<option class="selected" value="' . $year . ($year + 1) . '01">Th. 20' . $year . '/20' . ($year + 1) . ' - Smt. 1</option>';
    //  ambil 3 tahun ke depan
    for ($n = 1; $n <= 1; $n++) {
        $thnn = $year + $n;
        $opt .= '<option value="' . ($thnn - 1) . $thnn . '02">Th. 20' . ($thnn - 1) . '/20' . $thnn . ' - Smt. 2</option>';
        $opt .= '<option value="' . $thnn . ($thnn + 1) . '01">Th. 20' . $thnn . '/20' . ($thnn + 1) . ' - Smt. 1</option>';
    }
    echo $opt;
}

# create option select semester by class code and peserta code (select by type)
function createOptSelectThSmtByClassAndCodePst($class_code = '', $kode_peserta = '', $select_type = '')
{
    if ($class_code && $kode_peserta && $select_type) {
        if ($select_type == 'latihan') {
            $data = Record_Latihan::select('thsmt')->where([['kode_kelas_peserta', '=', $class_code], ['kode_peserta', '=', $kode_peserta]])->groupBy('thsmt')->get();
            foreach ($data as $key) {
                echo '<option value="' . $key->thsmt . '">' . makeSubstrFromThSmt($key->thsmt) . '</option>';
            }
        } elseif ($select_type == 'persyaratan') {
            $data = Record_Budget::select('thsmt')->where([['kode_kelas', '=', $class_code], ['kode_peserta', '=', $kode_peserta]])->groupBy('thsmt')->get();
            foreach ($data as $key) {
                echo '<option value="' . $key->thsmt . '">' . makeSubstrFromThSmt($key->thsmt) . '</option>';
            }
        }
    } else {
        # code...
    }
}
# make substr from thsmt
function makeSubstrFromThSmt($thsmt)
{
    $yearst = substr($thsmt, 0, 2);
    $yearnd = substr($thsmt, 2, 2);
    $smt = substr($thsmt, 4, 2);
    return 'Th. 20' . $yearst . '/20' . $yearnd . ' - Smt. ' . $smt;
}

# create greetings by time now
function createGreetingsByTimeNow()
{
    # Pagi, Siang, Sore, Malam
    $time = date("H");
    if ($time < "4") {
        return "Tidak Tidur Kah?";
    } elseif ($time >= "4" && $time < "11") {
        return "Selamat Pagi";
    } elseif ($time >= "11" && $time < "15") {
        return "Selamat Siang";
    } elseif ($time >= "15" && $time < "18") {
        return "Selamat Sore";
    } elseif ($time >= "18") {
        return "Selamat Malam";
    } else {
        return "Jam Berapa Ini Ya?";
    }
}

# create post training peserta by code
function createPostTrainingPstByCode($kode_peserta = '', $thsmt = '')
{
    if ($kode_peserta) {
        if ($thsmt) {
            $data = Record_Latihan::where([['thsmt', '=', $thsmt], ['kode_kelas_peserta', '=', getClassCodeByPstCode($kode_peserta)], ['kode_peserta', '=', $kode_peserta]])->orderBy('created_at', 'desc')->get();
        } else {
            $data = Record_Latihan::where([['thsmt', '=', getThnSmtClassByCode(getClassCodeByPstCode($kode_peserta))], ['kode_kelas_peserta', '=', getClassCodeByPstCode($kode_peserta)], ['kode_peserta', '=', $kode_peserta]])->orderBy('created_at', 'desc')->get();
        }
        if (json_decode($data) != NULL) {
            foreach ($data as $dt) {
                echo '<div class="post">';
                echo '<div class="user-block">';
                echo '<img class="img-circle img-bordered-sm" src="' . getAvatarUserByCode($dt->kode_pelatih) . '">';
                echo '<span class="username">';
                echo '<a href="/profile/account/' . getSlugnameByCode($dt->kode_pelatih) . '">' . getNamePltByCode($dt->kode_pelatih) . '</a>';
                echo '</span>';
                echo '<span class="description">' . conv_datetime($dt->created_at) . ' :: Durasi ' . $dt->durasi . ' Jam</span>';
                echo '</div>';
                echo '<p>' . getKetLatihanByCode($dt->keterangan) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p class="alert alert-danger" style="font-weight: bold;">Riwayat Latihan Tidak Ditemukan!!</p>';
        }
    } else {
        # code...
    }
}
