<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Data_Peserta;
use App\Kelas;
use App\Juklak_Ujian;

class PesertaController extends Controller
{
    public function add_peserta(Request $data)
    {
        $validate = Validator::make($data->all(), [
            'kode_kelas' => 'required',
            'nama_peserta' => 'required',
            'tingkat' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses')->withErrors($validate)->withInput();
        } else {
            $checkAuth = checkAuthForAddPst(auth()->user()->code);
            if ($checkAuth == 'OK') {
                $newPeserta = Data_Peserta::create([
                    'kode_peserta' => get_randChar(64),
                    'kode_kelas_peserta' => $data->kode_kelas,
                    'nama_peserta' => $data->nama_peserta,
                    'tingkat' => $data->tingkat,
                    'noinduk' => $data->noinduk
                ]);
                if ($newPeserta == TRUE) {
                    return redirect()->back()->with('success', 'Berhasil Menambahkan Peserta Baru');
                } else {
                    return redirect()->back()->with('failed', 'Gagal Menambahkan Peserta Baru');
                }
            } elseif ($checkAuth == 'FAIL') {
                return redirect()->back()->with('failed', 'Anda Tidak Memiliki Izin Untuk Menambahkan Peserta');
            } else {
                return redirect()->route('logout');
            }
        }
    }

    public function training_material()
    {
        $title = "Karate | Materi Ujian";
        if ((auth()->user()->status == 'bestnimda') || (auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor')) {
            return view('body.material.lte_juklak_ujian', compact(['title']));
        } elseif (auth()->user()->status == 'participants') {
            for ($i = (int) getKyuPeserta(); $i <= 10; $i++) {
                if ($i != '9') {
                    $allow[] = (string) $i;
                }
            }
            $allowKyu = $allow;
            return view('body.material.lte_juklak_ujian', compact(['title', 'allowKyu']));
        } else {
            return redirect()->route('home');
        }
    }





    # AJAX REQUEST

    // get juklak ujian with auth
    public function getJuklakUjianAuth(Request $data)
    {
        if ($data->has('kyu')) {
            if ((auth()->user()->status == 'bestnimda') || (auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor')) {
                if (($data->kyu >= 1) && ($data->kyu <= 10)) {
                    $data = Juklak_Ujian::select(['file_url'])->where('auth_kyu', '=', $data->kyu)->first();
                    if ($data['file_url'] != NULL) {
                        return '<iframe src="/viewer/#../filespdf/' . $data['file_url'] . '" height="800" width="100%" style="display: block;" type="application/pdf" allowfullscreen webkitallowfullscreen></iframe>';
                    } else {
                        return NULL;
                    }
                } else {
                    return NULL;
                }
            } elseif (auth()->user()->status == 'participants') {
                if (($data->kyu >= 1) && ($data->kyu <= 10)) {
                    if ($data->kyu >= getKyuPeserta()) { // jika request kyu materi lebih dari kyu peserta sekarang, maka diperbolehkan, jika kurang dari maka tidak diperbolehkan
                        $data = Juklak_Ujian::select(['file_url'])->where('auth_kyu', '=', $data->kyu)->first();
                        if ($data['file_url'] != NULL) {
                            return '<iframe src="/viewer/#../filespdf/' . $data['file_url'] . '" height="800" width="100%" style="display: block;" type="application/pdf" allowfullscreen webkitallowfullscreen></iframe>';
                        } else {
                            return NULL;
                        }
                    } else {
                        return NULL;
                    }
                } else {
                    return NULL;
                }
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
}
