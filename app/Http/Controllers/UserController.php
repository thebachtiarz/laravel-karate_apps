<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Kelas;
use App\Data_Pelatih;
use App\Data_Peserta;
use App\Guest_Otentifikasi as GO;
use App\Acc_class;
use App\PrivateChildsParents;
use App\Record_Latihan;
use App\Record_Budget;
use App\Record_File;
use App\Record_Spp;

class UserController extends Controller
{
    public function profile()
    {
        $title = "Karate | Profile";
        if ((Auth::user()->status == 'bestnimda') || (Auth::user()->status == 'moderator') || (Auth::user()->status == 'treasurer') || (Auth::user()->status == 'instructor')) {
            $data = User::select(['users.id', 'users.status', 'users.name', 'users.email', 'users.born', 'users.phone', 'users.id_line', 'users.avatar', 'users.code', 'pelatih_data.msh_pelatih', 'users.created_at'])->where('email', '=', Auth::user()->email)->leftJoin('pelatih_data', 'users.code', '=', 'pelatih_data.kode_pelatih')->first()->toArray();
        } elseif (Auth::user()->status == 'participants') {
            $data = User::select(['users.id', 'users.status', 'users.name', 'users.email', 'users.born', 'users.phone', 'users.id_line', 'users.avatar', 'users.code', 'peserta_data.noinduk', 'users.created_at'])->where('email', '=', Auth::user()->email)->leftJoin('peserta_data', 'users.code', '=', 'peserta_data.kode_peserta')->first()->toArray();
        } else {
            $data = User::select(['id', 'status', 'name', 'email', 'born', 'phone', 'id_line', 'avatar', 'code', 'created_at'])->where('email', '=', Auth::user()->email)->first()->toArray();
        }

        return view('body.profile.lte_profile_home', compact(['title', 'data']));
    }

    public function profilesave(Request $data)
    {
        if ($data->type == 'editbio') {
            if ((Auth::user()->status == 'bestnimda') || (Auth::user()->status == 'moderator') || (Auth::user()->status == 'treasurer') || (Auth::user()->status == 'instructor')) {
                User::find(Auth::user()->id)->update([
                    'name' => $data->name,
                    'born' => $data->born,
                    'phone' => $data->phone,
                    'id_line' => $data->id_line,
                    'avatar' => $data->avatar
                ]);
                Data_Pelatih::where('kode_pelatih', '=', Auth::user()->code)->update([
                    'msh_pelatih' => $data->msh_pelatih,
                    'nama_pelatih' => $data->name
                ]);
                return redirect()->back()->with('success', 'Biodata berhasil diperbarui');
            } elseif (Auth::user()->status == 'participants') {
                User::find(Auth::user()->id)->update([
                    'name' => $data->name,
                    'born' => $data->born,
                    'phone' => $data->phone,
                    'id_line' => $data->id_line,
                    'avatar' => $data->avatar
                ]);
                Data_Peserta::where('kode_peserta', '=', Auth::user()->code)->update([
                    'noinduk' => $data->noinduk,
                    'nama_peserta' => $data->name
                ]);
                return redirect()->back()->with('success', 'Biodata berhasil diperbarui');
            } else {
                User::find(Auth::user()->id)->update([
                    'name' => $data->name,
                    'born' => $data->born,
                    'phone' => $data->phone,
                    'id_line' => $data->id_line,
                    'avatar' => $data->avatar
                ]);
                return redirect()->back()->with('success', 'Biodata berhasil diperbarui');
            }
        } elseif ($data->type == 'editpasswd') {
            $validate = Validator::make($data->all(), [
                'old_pass' => 'required|min:96|max:96',
                'new_pass' => 'required|min:96|max:96',
                'confirm_pass' => 'required|min:96|max:96|same:new_pass'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('failed', 'Harap Perhatikan Kembali Input Password Anda');
            } else {
                if (password_verify($data->old_pass, Auth::user()->password)) {
                    $setNewPasswd = User::where('id', '=', Auth::user()->id)->update(['password' => bcrypt($data->new_pass)]);
                    if ($setNewPasswd == TRUE) {
                        return redirect()->route('logout');
                    } else {
                        return redirect()->back()->with('failed', 'Gagal Memperbarui Password');
                    }
                } else {
                    return redirect()->back()->with('failed', 'Password Lama Anda Tidak Sesuai');
                }
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function viewprofile($slugname)
    {
        // tambahkan otentifikasi kelas peserta agar tidak semua dapat mengakses profil
        if (auth()->user()->status == 'bestnimda') {
            return $this->_getViewprofile($slugname);
        } else {
            // cek apakah profil tujuan adalah dirinya sendiri
            $checkSelf = User::select(['email'])->where('slug_name', '=', $slugname)->first();
            if ($checkSelf['email'] == auth()->user()->email) {
                return redirect()->route('user.profile');
            } else {
                // cek status akun profil tujuan, jika admin maka tidak boleh ditampilkan
                $checkStat = User::select(['status'])->where('slug_name', '=', $slugname)->first();
                if ($checkStat['status'] == 'bestnimda') {
                    return redirect()->back()->with('failed', 'Akun Tidak Ditemukan');
                } else {
                    if (auth()->user()->status == 'moderator') { // jika pencari adalah moderator
                        return $this->_getViewprofile($slugname, $this->_getAccessClass());
                    } elseif (auth()->user()->status == 'treasurer') { // jika pencari adalah bendahara
                        return $this->_getViewprofile($slugname, $this->_getAccessClass());
                    } elseif (auth()->user()->status == 'instructor') { // jika pencari adalah pelatih
                        return $this->_getViewprofile($slugname, $this->_getAccessClass());
                    } elseif (auth()->user()->status == 'participants') { // jika pencari adalah peserta
                        return $this->_getViewprofile($slugname, $this->_getAccessClass());
                    } elseif (auth()->user()->status == 'parents') { // jika pencari adalah orang tua
                        return $this->_getViewprofile($slugname, $this->_getAccessClass());
                    } else {
                        // status = guests or something else
                        return redirect()->back()->with('failed', 'Akun Tidak Ditemukan');
                    }
                    // apabila status tidak ditemukan sekaligus menangkap semua error checkStatus
                    return redirect()->back()->with('failed', 'Akun Tidak Ditemukan');
                    // return $this->_getViewprofile($slugname);
                }
            }
        }
    }

    public function otentifikasi()
    {
        $title = "Otentifikasi Tamu";
        $reqOtt = GO::where('asal_email', '=', auth()->user()->email)->get();
        return view('otentifikasi.otentifikasi_guests', compact(['title', 'reqOtt']));
    }

    public function otentifikasi_save(Request $data)
    {
        $validate = Validator::make($data->all(), [
            'nama_pelatih' => 'required',
            'nama_kelas' => 'required',
            'new_stat' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('failed', 'Harap Periksa Kembali Formulir Anda');
        } else {
            if (($data->new_stat == '3') || ($data->new_stat == '2')) {
                $getData = Kelas::join('users', 'users.code', '=', 'kelas_data.kode_pelatih')->select(['kelas_data.kode_pelatih', 'kelas_data.kode_kelas'])->where([['users.name', '=', $data->nama_pelatih], ['kelas_data.nama_kelas', '=', $data->nama_kelas]])->first();
                $check = GO::where([['tujuan_code', '=', $getData->kode_pelatih], ['tujuan_kelas', '=', $getData->kode_kelas], ['asal_email', '=', auth()->user()->email]])->get();
                if (json_decode($check) == NULL) {
                    GO::create([
                        'tujuan_code' => $getData->kode_pelatih,
                        'tujuan_kelas' => $getData->kode_kelas,
                        'asal_email' => auth()->user()->email,
                        'asal_newstat' => $data->new_stat,
                        'asal_info' => $data->pesan
                    ]);
                    return redirect()->back()->with('success', 'Permintaan Otentifikasi Berhasil Dikirim');
                } else {
                    return redirect()->back()->with('failed', 'Permintaan Otentifikasi Sudah Ada');
                }
            } else {
                return redirect()->back()->with('failed', 'Harap Periksa Kembali Formulir Anda');
            }
        }
    }

    public function otentifikasi_delete($id)
    {
        $delete = GO::where([['id', '=', $id], ['asal_email', '=', auth()->user()->email]])->delete();
        if ($delete == 1) {
            return redirect()->back()->with('success', 'Permintaan Otentifikasi Berhasil Dihapus');
        } else {
            return redirect()->back()->with('failed', 'Gagal Menghapus Permintaan Otentifikasi');
        }
    }



    # AJAX REQUEST
    public function searchDataResult($srcRes)
    {
        if ($srcRes) {
            return Kelas::join('users', 'users.code', '=', 'kelas_data.kode_pelatih')->select(['users.name', 'kelas_data.nama_kelas'])->where('users.name', 'like', '%' . $srcRes . '%')->orWhere('kelas_data.nama_kelas', 'like', '%' . $srcRes . '%')->get();
        }
    }



    # PRIVATE METHOD
    private function _getAccessClass()
    {
        if ((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor')) {
            // cari akses kelas dari acc_class
            $acc = Acc_class::select(['kode_kelas'])->where('kode_pelatih', '=', auth()->user()->code)->get();
            if (json_decode($acc) != NULL) {
                foreach ($acc as $key) {
                    $accClass[] = $key->kode_kelas;
                }
                return $accClass;
            } else {
                // tidak memiliki akses kelas manapun
                return ['null'];
            }
        } elseif (auth()->user()->status == 'participants') {
            // cari akses kelas dari peserta_data
            $acc = Data_Peserta::select(['kode_kelas_peserta'])->where('kode_peserta', '=', auth()->user()->code)->first();
            if ($acc['kode_kelas_peserta'] != NULL) {
                $accClass[] = $acc['kode_kelas_peserta'];
                return $accClass;
            } else {
                // tidak memiliki akses kelas manapun
                return ['null'];
            }
        } elseif (auth()->user()->status == 'parents') {
            // cari akses kelas dari private_childs_parents
            $acc = PrivateChildsParents::select(['kode_kelas'])->where('parents_code', '=', auth()->user()->code)->get();
            if (json_decode($acc) != NULL) {
                foreach ($acc as $key) {
                    $accClass[] = $key->kode_kelas;
                }
                return $accClass;
            } else {
                // tidak memiliki akses kelas manapun
                return ['null'];
            }
        } else {
            // tidak memiliki akses kelas manapun karena status guest atau selain itu
            return ['null'];
        }
    }

    private function _getViewprofile($slugname, $clasCodeArr = '')
    {
        $check = User::select(['id', 'status', 'name', 'email', 'born', 'phone', 'id_line', 'avatar', 'code', 'created_at'])->where('slug_name', '=', $slugname)->first();
        if ($check['email'] != NULL) {
            $data = $check->toArray();
            if ($data['code'] != NULL) {
                if (($data['status'] == 'bestnimda') || ($data['status'] == 'moderator') || ($data['status'] == 'treasurer') || ($data['status'] == 'instructor')) {
                    if ($clasCodeArr) {
                        // cari akses kelas yang dimiliki oleh profil yang dituju, apakah sama dengan akses kelas yang dimiliki oleh pencari
                        $getAccClass = Acc_class::select(['kode_pelatih'])->where('kode_pelatih', '=', $data['code'])->whereIn('kode_kelas', $clasCodeArr)->first();
                        if ($getAccClass['kode_pelatih'] != NULL) {
                            $info = Data_Pelatih::select(['msh_pelatih'])->where('kode_pelatih', '=', $data['code'])->first()->toArray();
                            $bioProfile = $data += $info;
                        } else {
                            return redirect()->back()->with('failed', 'Akun Tidak Ditemukan');
                        }
                    } else {
                        $info = Data_Pelatih::select(['msh_pelatih'])->where('kode_pelatih', '=', $data['code'])->first()->toArray();
                        $bioProfile = $data += $info;
                    }
                } elseif ($data['status'] == 'participants') {
                    if ($clasCodeArr) {
                        $info = Data_Peserta::select(['kode_kelas_peserta', 'tingkat', 'noinduk'])->where('kode_peserta', '=', $data['code'])->whereIn('kode_kelas_peserta', $clasCodeArr)->first();
                        if ($info['kode_kelas_peserta'] != NULL) {
                            $bioProfile = $data += $info->toArray();
                        } else {
                            return redirect()->back()->with('failed', 'Akun Tidak Ditemukan');
                        }
                    } else {
                        $info = Data_Peserta::select(['kode_kelas_peserta', 'tingkat', 'noinduk'])->where('kode_peserta', '=', $data['code'])->first()->toArray();
                        $bioProfile = $data += $info;
                    }
                } else {
                    // status parents
                    if ($clasCodeArr) {
                        // mencari apakah perent ini benar terdapat pada kelas yang dapat diakses
                        $getFamilyInfo = PrivateChildsParents::select(['parents_code'])->whereIn('kode_kelas', $clasCodeArr)->first();
                        if ($getFamilyInfo['parents_code'] != NULL) {
                            $bioProfile = $data;
                        } else {
                            return redirect()->back()->with('failed', 'Akun Tidak Ditemukan');
                        }
                    } else {
                        $bioProfile = $data;
                    }
                }
            } else {
                $bioProfile = $data;
            }
            $title = "Profil | " . $data['name'];
            return view('body.profile.lte_profile_view', compact(['title', 'bioProfile']));
        } else {
            return redirect()->back()->with('failed', 'Akun Tidak Ditemukan');
        }
    }

    # AJAX METHOD
    public function checkMyPasswdLegelity(Request $data)
    {
        if ($data->has('old_pass')) {
            if (password_verify($data->old_pass, Auth::user()->password)) {
                return ['true', '<div class="valid-feedback text-green text-bold" id="old_pass_feedback">Sipp!!... Password Benar!</div>', getInpFormForNewPassword()];
            } else {
                return ['false', '<div class="invalid-feedback text-red text-bold" id="old_pass_feedback">Oops!!... Password Salah!</div>', ''];
            }
        } else {
            return NULL;
        }
    }

    ## API REQUEST METHOD
    public function getApiTimelineUser(Request $data)
    {
        $validate = Validator::make($data->all(), [
            'find_as' => 'required|alpha_num',
            'user_code' => 'required|alpha_num'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->messages()], 422);
        } else {
            if ($data->find_as == 'pelatih') {
                $getRecLatihan = Record_Latihan::select(['thsmt', 'kode_kelas_peserta as kelas', 'kode_peserta as peserta', 'kode_pelatih as pelatih', 'keterangan', 'durasi', 'created_at'])->where('kode_pelatih', '=', $data->user_code)->groupBy('created_at')->get();
                (json_decode($getRecLatihan) != NULL) ? $recLatihan = $getRecLatihan->toArray() : $recLatihan = [];
                for ($i = 0; $i < count($recLatihan); $i++) {
                    $recLatihan[$i] += ['type' => 'latihan']; // add type of data
                }
                $getRecBudget = Record_Budget::select(['thsmt', 'kode_kelas as kelas', 'kode_peserta as peserta', 'kode_pj as pelatih', 'aggregate', 'kredit', 'keterangan', 'saldo', 'created_at'])->where('kode_pj', '=', $data->user_code)->get();
                if (json_decode($getRecBudget) != NULL) {
                    $recBudget = $getRecBudget->toArray();
                    for ($i = 0; $i < count($recBudget); $i++) {
                        $recBudget[$i] += ['type' => 'biaya']; // add type of data
                        array_push($recLatihan, $recBudget[$i]); // push array data $recBudget
                    }
                }
                $getRecFile = Record_File::select(['thsmt', 'kode_kelas as kelas', 'kode_peserta as peserta', 'kode_pj as pelatih', 'kode_file as jenis_file', 'file_info', 'created_at'])->where('kode_pj', '=', $data->user_code)->get();
                if (json_decode($getRecFile) != NULL) {
                    $recFile = $getRecFile->toArray();
                    for ($i = 0; $i < count($recFile); $i++) {
                        $recFile[$i] += ['type' => 'file']; // add type of data
                        array_push($recLatihan, $recFile[$i]); // push array data $recFile
                    }
                }
                $getRecSpp = Record_Spp::select(['thsmt', 'kode_kelas as kelas', 'kode_peserta as peserta', 'kredit', 'untuk_bulan', 'kode_pj as pelatih', 'created_at'])->where('kode_pj', '=', $data->user_code)->get();
                if (json_decode($getRecSpp) != NULL) {
                    $recSpp = $getRecSpp->toArray();
                    for ($i = 0; $i < count($recSpp); $i++) {
                        $recSpp[$i] += ['type' => 'spp']; // add type of data
                        array_push($recLatihan, $recSpp[$i]); // push array data $recSpp
                    }
                }
                usort($recLatihan, [$this, 'date_compare']);
                if ($recLatihan) {
                    return response()->json($this->convertArrayDataTimeline($recLatihan), 200);
                }
                return response()->json(['error' => 'Timeline Data Not Found'], 422);
            } elseif ($data->find_as == 'peserta') {
                $getRecLatihan = Record_Latihan::select(['thsmt', 'kode_kelas_peserta as kelas', 'kode_peserta as peserta', 'kode_pelatih as pelatih', 'keterangan', 'durasi', 'created_at'])->where('kode_peserta', '=', $data->user_code)->groupBy('created_at')->get();
                (json_decode($getRecLatihan) != NULL) ? $recLatihan = $getRecLatihan->toArray() : $recLatihan = [];
                for ($i = 0; $i < count($recLatihan); $i++) {
                    $recLatihan[$i] += ['type' => 'latihan']; // add type of data
                }
                $getRecBudget = Record_Budget::select(['thsmt', 'kode_kelas as kelas', 'kode_peserta as peserta', 'kode_pj as pelatih', 'aggregate', 'kredit', 'keterangan', 'saldo', 'created_at'])->where('kode_peserta', '=', $data->user_code)->get();
                if (json_decode($getRecBudget) != NULL) {
                    $recBudget = $getRecBudget->toArray();
                    for ($i = 0; $i < count($recBudget); $i++) {
                        $recBudget[$i] += ['type' => 'biaya']; // add type of data
                        array_push($recLatihan, $recBudget[$i]); // push array data $recBudget
                    }
                }
                $getRecFile = Record_File::select(['thsmt', 'kode_kelas as kelas', 'kode_peserta as peserta', 'kode_pj as pelatih', 'kode_file as jenis_file', 'file_info', 'created_at'])->where('kode_peserta', '=', $data->user_code)->get();
                if (json_decode($getRecFile) != NULL) {
                    $recFile = $getRecFile->toArray();
                    for ($i = 0; $i < count($recFile); $i++) {
                        $recFile[$i] += ['type' => 'file']; // add type of data
                        array_push($recLatihan, $recFile[$i]); // push array data $recFile
                    }
                }
                $getRecSpp = Record_Spp::select(['thsmt', 'kode_kelas as kelas', 'kode_peserta as peserta', 'kredit', 'untuk_bulan', 'kode_pj as pelatih', 'created_at'])->where('kode_peserta', '=', $data->user_code)->get();
                if (json_decode($getRecSpp) != NULL) {
                    $recSpp = $getRecSpp->toArray();
                    for ($i = 0; $i < count($recSpp); $i++) {
                        $recSpp[$i] += ['type' => 'spp']; // add type of data
                        array_push($recLatihan, $recSpp[$i]); // push array data $recSpp
                    }
                }
                usort($recLatihan, [$this, 'date_compare']);
                if ($recLatihan) {
                    return response()->json($this->convertArrayDataTimeline($recLatihan), 200);
                }
                return response()->json(['error' => 'Timeline Data Not Found'], 422);
            } else {
                return response()->json(['error' => 'What Are You Looking For?'], 422);
            }
        }
    }
    function date_compare($tapi1, $tapi2)
    {
        $datetime1 = strtotime($tapi1['created_at']);
        $datetime2 = strtotime($tapi2['created_at']);
        return $datetime2 - $datetime1;
    }
    function convertArrayDataTimeline($array_data)
    {
        if (is_array($array_data) != NULL) {
            for ($i = 0; $i < count($array_data); $i++) {
                if ($array_data[$i]['type'] == 'latihan') {
                    $convTimeline[] = ['thsmt' => makeSubstrFromThSmt($array_data[$i]['thsmt']), 'kelas' => getClassNameByCode($array_data[$i]['kelas']), 'peserta' => getNamePstByCode($array_data[$i]['peserta']), 'pelatih' => getNamePltByCode($array_data[$i]['pelatih']), 'keterangan' => getKetLatihanByCode($array_data[$i]['keterangan']), 'durasi' => $array_data[$i]['durasi'] . ' Jam', 'created_at' => conv_datetime($array_data[$i]['created_at']), 'type' => $array_data[$i]['type']];
                } elseif ($array_data[$i]['type'] == 'biaya') {
                    $convTimeline[] = ['thsmt' => makeSubstrFromThSmt($array_data[$i]['thsmt']), 'kelas' => getClassNameByCode($array_data[$i]['kelas']), 'peserta' => getNamePstByCode($array_data[$i]['peserta']), 'pelatih' => getNamePltByCode($array_data[$i]['pelatih']), 'aggregate' => $array_data[$i]['aggregate'], 'kredit' => 'Rp. ' . mycurrency($array_data[$i]['kredit']), 'keterangan' => $array_data[$i]['keterangan'], 'saldo' => 'Rp. ' . mycurrency($array_data[$i]['saldo']), 'created_at' => conv_datetime($array_data[$i]['created_at']), 'type' => $array_data[$i]['type']];
                } elseif ($array_data[$i]['type'] == 'file') {
                    $convTimeline[] = ['thsmt' => makeSubstrFromThSmt($array_data[$i]['thsmt']), 'kelas' => getClassNameByCode($array_data[$i]['kelas']), 'peserta' => getNamePstByCode($array_data[$i]['peserta']), 'pelatih' => getNamePltByCode($array_data[$i]['pelatih']), 'jenis_file' => getFileInfoByCode($array_data[$i]['jenis_file']), 'file_info' => $array_data[$i]['file_info'], 'created_at' => conv_datetime($array_data[$i]['created_at']), 'type' => $array_data[$i]['type']];
                } elseif ($array_data[$i]['type'] == 'spp') {
                    $convTimeline[] = ['thsmt' => makeSubstrFromThSmt($array_data[$i]['thsmt']), 'kelas' => getClassNameByCode($array_data[$i]['kelas']), 'peserta' => getNamePstByCode($array_data[$i]['peserta']), 'pelatih' => getNamePltByCode($array_data[$i]['pelatih']), 'kredit' => 'Rp. ' . mycurrency($array_data[$i]['kredit']), 'untuk_bulan' => getMonth($array_data[$i]['untuk_bulan']), 'created_at' => conv_datetime($array_data[$i]['created_at']), 'type' => $array_data[$i]['type']];
                } else {
                    # code...
                }
            }
            return $convTimeline;
        } else {
            # code...
        }
    }
}
