<?php
date_default_timezone_set('Asia/Jakarta');

use App\User;
use App\Kelas;
use App\Acc_class;
use App\Data_Peserta;

# create helper for auth access
// function setAccessStatus($arrStatus, $aggr = '')
// {
//     if (is_array($arrStatus)) {
//         $status = '';
//         for ($i = 0; $i < count($arrStatus); $i++) {
//             if ($i == 0) {
//                 // $status .= parse_str("(" . auth()->user()->status == $arrStatus[$i] . ")");
//             } else {
//                 // $status .= parse_str(" $aggr (" . auth()->user()->status == $arrStatus[$i] . ")");
//             }
//         }
//         return $status;
//     } else {
//         return 'No You Dont!';
//     }
// }

# cek apakah user dapat membuat kelas baru (moderate)
function checkStatusModerate()
{
    if (auth()->user()->code) {
        $getUser = User::select('status')->where('code', '=', auth()->user()->code)->first();
        if ($getUser->status == 'moderator') {
            return 'OK';
        } else {
            return 'FAIL';
        }
    } else {
        return 'No You Dont!';
    }
}

# cek daftar kelas yang dapat diakses oleh user (pelatih)
function getListAccessClassUserByCode()
{
    if (auth()->user()->code) {
        $access = Acc_class::select('kode_kelas')->where('kode_pelatih', '=', auth()->user()->code)->get();
        // dd($access);
        // foreach ($access as $acc) {
        //     echo $acc['kode_kelas'];
        // }
        return $access;
    } else {
        return "No You Dont!";
    }
}

# cek apakah user memiliki akses pada kelas yang dituju
function checkAuthAccClass($class_code = '')
{
    if (auth()->user()->status == 'bestnimda') {
        # you are admin
        return "OK";
    } else {
        # do checking into acc_class table
        $acc = Acc_class::where([['kode_kelas', '=', $class_code], ['kode_pelatih', '=', auth()->user()->code]])->first();
        if ($acc) {
            # ok, you can next to request
            return "OK";
        }
    }
}
# or by id class
function checkAuthAccClassById($id = '')
{
    if ($id) {
        if (auth()->user()->status == 'bestnimda') {
            # you are admin
            return "OK";
        } else {
            # do checking into acc_class table
            $acc = Kelas::where('id', '=', $id)->first();
            if ($acc->kode_kelas != NULL) {
                $acc2 = Acc_class::where([['kode_kelas', '=', $acc->kode_kelas], ['kode_pelatih', '=', auth()->user()->code]])->first();
                if ($acc2 != NULL) {
                    return 'OK';
                } else {
                    return 'FAIL';
                }
            } else {
                return 'FAIL';
            }
        }
    } else {
        return 'FAIL';
    }
}

# cek apakah user (pelatih) memiliki akses untuk melakukan record latihan pada kelas tersebut
function getAccessToRecordClassByUserCode($class_code = '')
{
    $code = auth()->user()->code;
    if ($class_code && $code) {
        $access = Acc_class::where([['kode_kelas', '=', $class_code], ['kode_pelatih', '=', $code]])->first();
        if ($access) {
            return 'OK';
        } else {
            return 'FAIL';
        }
    } else {
        return "No You Dont!";
    }
}

# cek apakah user dapat menambahkan peserta pada kelas
function checkAuthForAddPst($code = '')
{
    if ($code) {
        $getUser = User::select('status')->where('code', '=', $code)->first();
        if (($getUser->status == 'moderator') || ($getUser->status == 'treasurer') || ($getUser->status == 'instructor')) {
            return 'OK';
        } else {
            return 'FAIL';
        }
    } else {
        return 'No You Dont!';
    }
}

# cek apakah terdapat peserta dengan kode tersebut
function checkPstByClassAndCode($class_code = '', $kode_peserta = '')
{
    if ($class_code && $kode_peserta) {
        $check = Data_Peserta::where([['kode_kelas_peserta', '=', $class_code], ['kode_peserta', '=', $kode_peserta]])->first();
        if ($check) {
            return 'OK';
        } else {
            return 'FAIL';
        }
    } else {
        return 'No You Dont!';
    }
}

# cek tahun semester kelas berdasarkan kode kelas
function getThnSmtClassByCode($class_code = '')
{
    if ($class_code) {
        $data = Kelas::select(['thsmt'])->where('kode_kelas', '=', $class_code)->first();
        return $data['thsmt'];
    } else {
        return 'No You Dont!';
    }
}
# cek tahun semester kelas berdasarkan kode kelas
function getThnSmtClassByCodeArray($class_code_array = '')
{
    if ($class_code_array) {
        for ($i = 0; $i < count($class_code_array); $i++) {
            $data = Kelas::select(['thsmt'])->where('kode_kelas', '=', $class_code_array[$i])->first();
            $thsmt[] = $data['thsmt'];
        }
        return $thsmt;
    } else {
        return 'No You Dont!';
    }
}

# cek biaya spp kelas by kode kelas
function getSppFeeClassByCode($class_code = '')
{
    if ($class_code) {
        $data = Kelas::select(['spp'])->where('kode_kelas', '=', $class_code)->first();
        return $data['spp'];
    } else {
        return NULL;
    }
}
