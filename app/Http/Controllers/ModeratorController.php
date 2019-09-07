<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Acc_class;
use App\Kelas;
use App\User;
use App\Data_Pelatih;
// use App\Record_Budget;
use App\Static_Budget;
use App\Static_File;
use App\Data_Peserta;
use App\Guest_Otentifikasi as GO;
use App\PrivateChildsParents;
use App\Record_Spp;

class ModeratorController extends Controller
{
    public function pengaturan()
    {
        return view('pengaturan.lte_moderator_home', ['title' => 'Karate | Pengaturan']);
    }

    public function editkelas($kelas)
    {
        $check = checkAuthAccClass($kelas);
        if ($check == "OK") {
            $data_kelas = Kelas::where('kode_kelas', '=', $kelas)->first();
            $title = "Karate | " . getClassNameByCode($data_kelas['kode_kelas']);
            return view('pengaturan.lte_moderator_class_edit', compact(['title', 'data_kelas']));
        } else {
            return redirect('/pengaturan')->with('failed', 'Anda tidak memiliki akses pada kelas tersebut');
        }
    }

    public function editkelassave(Request $data, $kelas)
    {
        if ($data->type == "editKelas") {
            $validate = Validator::make($data->all(), [
                'nama_kelas' => 'required',
                'durasi_latihan' => 'required'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses');
            } else {
                Kelas::where('kode_kelas', '=', $kelas)->update([
                    'nama_kelas' => $data->nama_kelas,
                    'durasi_latihan' => $data->durasi_latihan,
                    'avatar' => $data->avatar
                ]);
                return redirect()->back()->with('success', 'Edit Kelas Berhasil');
            }
        } elseif ($data->type == "addPelatih") {
            $validate = Validator::make($data->all(), [
                'pelatih_baru' => 'required|email',
                'kode_kelas' => 'required'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses');
            } else {
                $check1 = User::where('email', '=', $data->pelatih_baru)->first();
                if ($check1 != NULL) {
                    if ($check1['code']) {
                        // cek apakah sudah ada akses kelas user tersebut di tabel
                        $check2 = Acc_class::where([['kode_kelas', '=', $data->kode_kelas], ['kode_pelatih', '=', $check1['code']]])->first();
                        if ($check2 == NULL) {
                            // insert access_class with data pelatih baru
                            Acc_class::create([
                                'kode_kelas' => $data->kode_kelas,
                                'kode_pelatih' => $check1['code']
                            ]);
                            return redirect()->back()->with('success', 'Berhasil menambahkan pelatih baru');
                        } else {
                            return redirect()->back()->with('failed', '' . $data->pelatih_baru . ' Sudah menjadi pelatih pada kelas ini');
                        }
                    } else {
                        // generate code untuk user
                        $new_code = get_randChar(64);
                        $check3 = Data_Pelatih::where('nama_pelatih', '=', $check1->name)->first();
                        if ($check3['kode_pelatih']) {
                            // jika sudah ada data pada tabel pelatih
                            DB::beginTransaction();
                            try {
                                // insert data baru pada akses kelas
                                Acc_class::create([
                                    'kode_kelas' => $data->kode_kelas,
                                    'kode_pelatih' => $new_code
                                ]);
                                DB::commit();
                                return redirect()->back()->with('success', 'Berhasil menambahkan pelatih baru');
                            } catch (\Exception $e) {
                                DB::rollback();
                                return redirect()->back()->with('failed', 'Terdapat Kegagalan Dalam Melakukan Proses');
                            }
                        } else {
                            // jika belum terdapat data pada tabel pelatih
                            DB::beginTransaction();
                            try {
                                // update status user dan update code 
                                User::where('email', '=', $check1['email'])->update(['status' => 'instructor', 'code' => $new_code]);
                                // insert data pada tabel pelatih
                                Data_Pelatih::create([
                                    'kode_pelatih' => $new_code,
                                    'nama_pelatih' => $check1->name
                                ]);
                                // insert data baru pada akses kelas
                                Acc_class::create([
                                    'kode_kelas' => $data->kode_kelas,
                                    'kode_pelatih' => $new_code
                                ]);
                                DB::commit();
                                return redirect()->back()->with('success', 'Berhasil menambahkan pelatih baru');
                            } catch (\Exception $e) {
                                DB::rollback();
                                return redirect()->back()->with('failed', 'Terdapat Kegagalan Dalam Melakukan Proses');
                            }
                        }
                    }
                } else {
                    return redirect()->back()->with('failed', 'Tidak dapat menemukan akun ' . $data->pelatih_baru);
                }
            }
        } elseif ($data->type == "addBendahara") {
            $validate = Validator::make($data->all(), [
                'bendahara_baru' => 'required',
                'kode_kelas' => 'required'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses');
            } else {
                // cek apakah user tersebut adalah pelatih
                $check1 = User::where([['status', '=', 'instructor'], ['code', '=', $data->bendahara_baru]])->first();
                if ($check1['status'] == 'instructor') {
                    // cek apakah pelatih tersebut memiliki akses pada kelas
                    $check2 = Acc_class::where([['kode_kelas', '=', $data->kode_kelas], ['kode_pelatih', '=', $data->bendahara_baru]])->first();
                    if ($check2 != NULL) {
                        User::where('code', '=', $data->bendahara_baru)->update(['status' => 'treasurer']);
                        return redirect()->back()->with('success', 'Berhasil menambahkan bendahara');
                    } else {
                        return redirect()->back()->with('failed', 'Akun tersebut tidak memiliki akses melatih pada kelas ini');
                    }
                } else {
                    return redirect()->back()->with('failed', 'Akun tidak ditemukan');
                }
            }
        } elseif ($data->type == "biayaujian") {
            $validate = Validator::make($data->all(), [
                'kode_kelas' => 'required'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses');
            } else {
                // dd($data->all());
                for ($i = 10; $i >= 1; $i--) {
                    try {
                        // 'kode_kelas', 'tingkat', 'biaya_ujian'
                        $check = Static_Budget::where([['kode_kelas', '=', $data->kode_kelas], ['tingkat', '=', $i], ['thsmt', '=', getThnSmtClassByCode($data->kode_kelas)]])->first();
                        if ($check != NULL) {
                            // jika data ada maka update
                            Static_Budget::where([['kode_kelas', '=', $data->kode_kelas], ['tingkat', '=', $i]])->update(['biaya_ujian' => $data->$i]);
                        } else {
                            // jika data tidak ada maka insert
                            Static_Budget::create([
                                'thsmt' => getThnSmtClassByCode($data->kode_kelas),
                                'kode_kelas' => $data->kode_kelas,
                                'tingkat' => $i,
                                'biaya_ujian' => $data->$i
                            ]);
                        }
                    } catch (\Throwable $th) {
                        // jika biaya ujian tidak terdefinisi
                    }
                }
                return redirect()->back()->with('success', 'Biaya ujian berhasil diperbarui');
            }
        } elseif ($data->type == "berkasujian") {
            $validate = Validator::make($data->all(), [
                'kode_kelas' => 'required',
                'nama_file' => 'required'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses');
            } else {
                $newBerkas = Static_File::create([
                    'thsmt' => getThnSmtClassByCode($data->kode_kelas),
                    'kode_file' => get_randChar(10),
                    'kode_kelas' => $data->kode_kelas,
                    'nama_file' => $data->nama_file
                ]);
                if ($newBerkas == TRUE) {
                    return redirect()->back()->with('success', 'Berhasil Menambahkan Tipe Berkas Ujian');
                } else {
                    return redirect()->back()->with('failed', 'Gagal Menambahkan Tipe Berkas Ujian');
                }
            }
        } elseif ($data->type == "sppkelas") {
            $validate = Validator::make($data->all(), [
                'kode_kelas' => 'required',
                'spp_kelas' => 'required|digits_between:4,6|numeric'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses SPP');
            } else {
                $setSPP = Kelas::where('kode_kelas', '=', $data->kode_kelas)->update(['spp' => $data->spp_kelas]);
                if ($setSPP == TRUE) {
                    return redirect()->back()->with('success', 'Berhasil Menetapkan Biaya SPP');
                } else {
                    return redirect()->back()->with('failed', 'Gagal Menetapkan Biaya SPP');
                }
            }
        } elseif ($data->type == "thsmtkelas") {
            $validate = Validator::make($data->all(), [
                'kode_kelas' => 'required',
                'thsmt_kelas' => 'required|numeric|digits_between:6,6'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('failed', 'Tahun Semester Tidak Sesuai');
            } else {
                $setThSmt = Kelas::where('kode_kelas', '=', $data->kode_kelas)->update(['thsmt' => $data->thsmt_kelas]);
                if ($setThSmt == TRUE) {
                    return redirect()->back()->with('success', 'Berhasil Mengganti Tahun Semester');
                } else {
                    return redirect()->back()->with('failed', 'Gagal Mengganti Tahun Semester');
                }
            }
        } else {
            return "Type Salah";
        }
    }

    public function deleteKelas($kelas)
    {
        $kode_kelas = $kelas;
        $check1 = checkAuthAccClass($kode_kelas);
        if ($check1 == 'OK') {
            // jika sudah ada data pada tabel pelatih
            DB::beginTransaction();
            try {
                // hapus kelas pada tabel kelas by kode kelas
                Kelas::where('kode_kelas', '=', $kode_kelas)->delete();
                // hapus seluruh akses pada kelas tersebut
                Acc_class::where('kode_kelas', '=', $kode_kelas)->delete();
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil menghapus kelas');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('failed', 'Terdapat Kegagalan Dalam Melakukan Proses');
            }
        } else {
            return redirect('/pengaturan')->with('failed', 'Anda tidak memiliki akses pada kelas tersebut');
        }
        // dd($data->all(), $id);
    }

    public function bayarspp(Request $key)
    {
        if ($key->has('key')) {
            $check = checkAuthAccClass($key->key);
            if ($check == 'OK') {
                $title = "Karate | Pembayaran SPP";
                $kelas = $key->key;
                $peserta = Data_Peserta::where('kode_kelas_peserta', '=', $key->key)->orderBy('nama_peserta', 'asc')->get();
                return view('body.spp.lte_bendahara_spp', compact(['title', 'kelas', 'peserta']));
            } else {
                return redirect('/kelas')->with('failed', 'Anda tidak memiliki akses pada kelas tersebut');
            }
        } else {
            return redirect()->route('kelas.home');
        }
    }

    public function otentifikasi($id)
    {
        $title = "Karate | Konfirmasi Otentifikasi";
        $data = GO::find($id);
        if (json_decode($data) != NULL) {
            $getClass = $data->toArray();
            $auth = checkAuthAccClass($getClass['tujuan_kelas']);
            if ($auth == 'OK') {
                return view('pengaturan.lte_confirmott', compact(['title', 'data']));
            } else {
                return redirect('/pengaturan')->with('failed', 'Data tidak ditemukan');
            }
        } else {
            return redirect('/pengaturan')->with('failed', 'Data tidak ditemukan');
        }
    }

    public function otentifikasi_save(Request $data, $id)
    {
        $validate = Validator::make($data->all(), [
            'nama_pemohon' => 'required',
            'nama_ditemukan' => 'required',
            'email_pemohon' => 'required|email',
            'code_ditemukan' => 'required|alpha_num'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses');
        } else {
            $new_stat = GO::select(['asal_newstat'])->where('asal_email', '=', $data->email_pemohon)->first();
            DB::beginTransaction();
            try {
                if ($new_stat['asal_newstat'] == '3') {
                    User::where('email', '=', $data->email_pemohon)->update(['status' => convStatUserToStatName($new_stat['asal_newstat']), 'code' => $data->code_ditemukan]);
                    Data_Peserta::where('kode_peserta', '=', $data->code_ditemukan)->update(['nama_peserta' => $data->nama_pemohon]);
                } elseif ($new_stat['asal_newstat'] == '2') {
                    // cek apakah code_ditemukan(anak) sudah membuat akun pada apps
                    $checkPstUser = User::select(['name'])->where('code', '=', $data->code_ditemukan)->first();
                    if ($checkPstUser['name'] != NULL) {
                        // cek apakah user ini adalah orang tua ataukah masih tamu
                        $checkprt = User::select(['status', 'code'])->where('email', '=', $data->email_pemohon)->first();
                        if ($checkprt['status'] == 'parents') {
                            // cek apakah orang tua sudah menambahkan peserta tujuan atau belum
                            $checkPstPCP = PrivateChildsParents::where([['parents_code', '=', $checkprt['code']], ['childs_code', '=', $data->code_ditemukan]])->first();
                            if ($checkPstPCP['id'] == NULL) {
                                PrivateChildsParents::create(['parents_code' => $checkprt['code'], 'childs_code' => $data->code_ditemukan, 'kode_kelas' => getClassCodeByPstCode($data->code_ditemukan)]);
                            } else {
                                DB::rollback();
                                GO::where('asal_email', '=', $data->email_pemohon)->delete();
                                return redirect('/pengaturan')->with('failed', 'Peserta sudah pernah ditambahkan');
                            }
                        } else {
                            $new_code = get_randChar(64);
                            User::where('email', '=', $data->email_pemohon)->update(['status' => convStatUserToStatName($new_stat['asal_newstat']), 'code' => $new_code]);
                            PrivateChildsParents::create(['parents_code' => $new_code, 'childs_code' => $data->code_ditemukan, 'kode_kelas' => getClassCodeByPstCode($data->code_ditemukan)]);
                        }
                    } else {
                        DB::rollback();
                        return redirect('/pengaturan')->with('failed', 'Peserta ' . getNamePstByCode($data->code_ditemukan) . ' Belum Membuat Akun Pada Karate Apps');
                    }
                } else {
                    DB::rollback();
                    return redirect('/pengaturan')->with('failed', 'Otentifikasi gagal dilakukan');
                }
                GO::where('asal_email', '=', $data->email_pemohon)->delete();
                DB::commit();
                return redirect('/pengaturan')->with('success', 'Otentifikasi berhasil dilakukan');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect('/pengaturan')->with('failed', 'Otentifikasi gagal dilakukan');
            }
        }
    }

    public function otentifikasi_delete($id)
    {
        $delete = GO::where([['id', '=', $id], ['tujuan_code', '=', auth()->user()->code]])->delete();
        if ($delete == TRUE) {
            return redirect()->back()->with('success', 'Berhasil menghapus permintaan otentifikasi');
        } else {
            return redirect()->back()->with('failed', 'Gagal menghapus permintaan otentifikasi');
        }
    }

    public function profilePesertaTraining($kelas, $peserta)
    {
        if ($kelas && $peserta) {
            $data = Data_Peserta::select(['users.id', 'users.status', 'users.name', 'users.email', 'users.born', 'users.phone', 'users.id_line', 'users.code', 'peserta_data.noinduk', 'peserta_data.kode_kelas_peserta', 'users.created_at'])->where([['kode_kelas_peserta', '=', $kelas], ['kode_peserta', '=', $peserta]])->leftJoin('users', 'peserta_data.kode_peserta', '=', 'users.code')->first();
            // dd(json_decode($data));
            if ($data != NULL) {
                if ($data['id'] != NULL) {
                    $title = "Profil Peserta | " . getNamePstByCode($peserta);
                    return view('pengaturan.lte_moderator_peserta_profile', compact(['title', 'data']));
                } else {
                    return redirect()->back()->with('failed', 'Peserta Belum Melakukan Otentifikasi');
                }
            } else {
                return redirect()->back()->with('failed', 'Peserta Tidak Ditemukan');
            }
        } else {
            return redirect()->back()->with('failed', 'Peserta Tidak Ditemukan');
        }
    }

    public function deletePesertaTraining($kelas, $peserta)
    {
        if ($kelas && $peserta) {
            $checkPayment = get_lastSaldoUser_by_code($kelas, $peserta);
            if ($checkPayment > 0) {
                return redirect('/pengaturan/peserta/profile/' . $kelas . '/' . $peserta . '#persyaratan')->with('warning', 'Masih Terdapat Simpanan Biaya Pada Peserta Ini');
            } else {
                $delete = Data_Peserta::where([['kode_kelas_peserta', '=', $kelas], ['kode_peserta', '=', $peserta]])->delete();
                if ($delete == TRUE) {
                    return redirect()->back()->with('success', 'Berhasil Menghapus Peserta');
                } else {
                    return redirect()->back()->with('failed', 'Gagal Menghapus Peserta');
                }
            }
        } else {
            return redirect()->back()->with('failed', 'Peserta Tidak Ditemukan');
        }
    }

    # AJAX REQUEST
    public function getdatapeserta(Request $key)
    {
        if ($key->has('kelas')) {
            $check = checkAuthAccClass($key->kelas);
            if ($check == 'OK') {
                $data = Data_Peserta::where('kode_kelas_peserta', '=', $key->kelas)->orderBy('nama_peserta', 'asc')->get();
                if (json_decode($data) != NULL) {
                    for ($i = 0; $i < count($data); $i++) {
                        $peserta[] = ['peserta' => $data[$i]['nama_peserta'], 'tingkat' => 'Kyu ' . $data[$i]['tingkat'] . ' / ' . get_belt_by_kyu($data[$i]['tingkat']), 'induk' => (isset($data[$i]['noinduk'])) ? $data[$i]['noinduk'] : '', 'kode' => $data[$i]['kode_peserta'], 'kelas' => $data[$i]['kode_kelas_peserta']];
                    }
                    return ['true', $peserta];
                } else {
                    return ['false', 'Peserta Tidak Ditemukan'];
                }
            } else {
                return ['false', 'Kelas Tidak Ditemukan'];
            }
        } else {
            # code...
        }
    }

    public function getdatatingkatpeserta(Request $key)
    {
        if ($key->has('kelas')) {
            $check = checkAuthAccClass($key->kelas);
            if ($check == 'OK') {
                $data = Data_Peserta::where('kode_kelas_peserta', '=', $key->kelas)->orderBy('nama_peserta', 'asc')->get();
                if (json_decode($data) != NULL) {
                    for ($i = 0; $i < count($data); $i++) {
                        $peserta[] = ['peserta' => $data[$i]['nama_peserta'], 'tingkat' => 'Kyu ' . $data[$i]['tingkat'] . ' / ' . get_belt_by_kyu($data[$i]['tingkat']), 'induk' => (isset($data[$i]['noinduk'])) ? $data[$i]['noinduk'] : '', 'kode' => $data[$i]['kode_peserta'], 'kelas' => $data[$i]['kode_kelas_peserta']];
                    }
                    return ['true', $peserta];
                } else {
                    return ['false', 'Peserta Tidak Ditemukan'];
                }
            } else {
                return ['false', 'Kelas Tidak Ditemukan'];
            }
        } else {
            # code...
        }
    }

    public function searchPesertaKelas($kelas, $peserta)
    {
        if ($kelas && $peserta) {
            return Data_Peserta::where([['kode_kelas_peserta', '=', $kelas], ['nama_peserta', 'like', '%' . $peserta . '%']])->get()->toJson();
        } else {
            # code...
        }
    }

    public function caripelatihbaru(Request $key)
    {
        if ($key->has('key')) {
            return User::select(['email', 'name'])->where('name', 'like', '%' . $key->key . '%')->whereIn('status', ['guests', 'moderator', 'treasurer', 'instructor'])->whereNotIn('email', [auth()->user()->email])->get()->toJson();
        } else {
            # code...
        }
    }

    public function getdatapelatih(Request $key)
    {
        if ($key->has('kelas')) {
            $data = Acc_class::join('users', 'acc_class.kode_pelatih', '=', 'users.code')->select(['users.name', 'users.code', 'acc_class.created_at'])->where('kode_kelas', '=', $key->kelas)->whereIn('users.status', ['moderator', 'treasurer', 'instructor'])->orderBy('users.name', 'asc')->get();
            if (json_decode($data) != NULL) {
                for ($i = 0; $i < count($data); $i++) {
                    $pelatih[] = ['pelatih' => $data[$i]['name'], 'kode' => $data[$i]['code'], 'tgl_akses' => conv_getDate($data[$i]['created_at'])];
                }
                return ['true', $pelatih];
            } else {
                return ['false', 'Pelatih Tidak Ditemukan'];
            }
        } else {
            # code...
        }
    }

    public function getdatabendahara(Request $key)
    {
        if ($key->has('kelas')) {
            $data = Acc_class::join('users', 'acc_class.kode_pelatih', '=', 'users.code')->select(['users.name', 'users.code', 'acc_class.created_at'])->where('kode_kelas', '=', $key->kelas)->whereIn('users.status', ['moderator', 'treasurer'])->orderBy('users.name', 'asc')->get();
            if (json_decode($data) != NULL) {
                for ($i = 0; $i < count($data); $i++) {
                    $pelatih[] = ['pelatih' => $data[$i]['name'], 'kode' => $data[$i]['code'], 'tgl_akses' => conv_getDate($data[$i]['created_at'])];
                }
                return ['true', $pelatih];
            } else {
                return ['false', 'Pelatih Tidak Ditemukan'];
            }
        } else {
            # code...
        }
    }

    public function getRecordSppPesertaByCode($class_code, $pst_code)
    {
        if ($class_code && $pst_code) {
            return getRecSppPstByClassAndCodeInTbody($class_code, $pst_code);
        } else {
            return NULL;
        }
    }

    public function pushRecordSppPesertaSave(Request $data)
    {
        $validate = Validator::make($data->all(), [
            'untuk_bulan' => 'required',
            'kode_kelas' => 'required|alpha_num',
            'kode_peserta' => 'required|alpha_num'
        ]);

        if ($validate->fails()) {
            return ['false', 'Terdapat Kesalahan Pada Input Data'];
        } else {
            $checkBulan = Record_Spp::select(['thsmt', 'untuk_bulan'])->where([['kode_kelas', '=', $data->kode_kelas], ['kode_peserta', '=', $data->kode_peserta], ['untuk_bulan', '=', $data->untuk_bulan]])->first();
            // cek apakah pada semester dan bulan tersebut peserta telah melakukan pembayaran spp
            if ($checkBulan['thsmt'] . $checkBulan['untuk_bulan'] == getThnSmtClassByCode($data->kode_kelas) . $data->untuk_bulan) {
                return ['false', 'Pembayaran Pada Bulan ' . getMonth($data->untuk_bulan) . ' Telah Dilakukan Oleh Peserta'];
            } else {
                $getFeeSpp = getSppFeeClassByCode($data->kode_kelas);
                if ($getFeeSpp != NULL) {
                    $pushRecSpp = Record_Spp::create([
                        'thsmt' => getThnSmtClassByCode($data->kode_kelas),
                        'kode_kelas' => $data->kode_kelas,
                        'kode_peserta' => $data->kode_peserta,
                        'kredit' => $getFeeSpp,
                        'untuk_bulan' => $data->untuk_bulan,
                        'kode_pj' => auth()->user()->code
                    ]);
                    if ($pushRecSpp == TRUE) {
                        return ['true', 'Berhasil Menambahkan SPP Peserta'];
                    } else {
                        return ['false', 'Gagal Menambahkan SPP Peserta'];
                    }
                } else {
                    return ['false', 'Biaya SPP Belum Ditentukan!'];
                }
            }
        }
    }
}
