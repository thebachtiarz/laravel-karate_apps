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

class UserController extends Controller
{
    public function profile()
    {
        if ((Auth::user()->status == 'bestnimda') || (Auth::user()->status == 'moderator') || (Auth::user()->status == 'treasurer') || (Auth::user()->status == 'instructor')) {
            $data = User::select(['users.id', 'users.status', 'users.name', 'users.email', 'users.born', 'users.phone', 'users.id_line', 'users.avatar', 'users.code', 'pelatih_data.msh_pelatih', 'users.created_at'])->where('email', '=', Auth::user()->email)->leftJoin('pelatih_data', 'users.code', '=', 'pelatih_data.kode_pelatih')->first()->toArray();
        } elseif (Auth::user()->status == 'participants') {
            $data = User::select(['users.id', 'users.status', 'users.name', 'users.email', 'users.born', 'users.phone', 'users.id_line', 'users.avatar', 'users.code', 'peserta_data.noinduk', 'users.created_at'])->where('email', '=', Auth::user()->email)->leftJoin('peserta_data', 'users.code', '=', 'peserta_data.kode_peserta')->first()->toArray();
        } else {
            $data = User::select(['id', 'status', 'name', 'email', 'born', 'phone', 'id_line', 'avatar', 'code', 'created_at'])->where('email', '=', Auth::user()->email)->first()->toArray();
        }

        $title = "Karate | Profile";
        // dd($data);
        return view('body.profile.lte_profile_home', compact(['title', 'data']));
    }

    public function profilesave(Request $data)
    {
        if ($data->type == 'editbio') {
            // dd($data->all());
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
        } else {
            # code...
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
}
