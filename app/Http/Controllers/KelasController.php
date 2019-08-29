<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Kelas;
use App\Acc_class;
use App\Data_Peserta;
use App\Record_Latihan;
use App\Record_Latihan_Info;
use App\Record_Budget;
use App\Record_File;

class KelasController extends Controller
{
    public function home()
    {
        if (auth()->user()->status == 'bestnimda') {
            $all_kelas = Kelas::all();
            // dd($all_kelas);
        } else {
            $all_kelas = Acc_class::join('kelas_data', 'acc_class.kode_kelas', '=', 'kelas_data.kode_kelas')->where('acc_class.kode_pelatih', '=', auth()->user()->code)->get();
            // dd($all_kelas);
        }

        $title = "Karate | Kelas";
        return view('body.kelas.lte_kelas_home', compact(['title', 'all_kelas']));
    }

    public function addKelas(Request $data)
    {
        $validate = Validator::make($data->all(), [
            'nama_kelas' => 'required',
            'durasi_latihan' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect('/kelas')->with('failed', 'Terdapat Kesalahan Dalam Proses')->withErrors($validate)->withInput();
        } else {
            // cek apakah user (moderator) dapat membuat kelas baru
            $checkAuth = checkStatusModerate();
            if ($checkAuth == 'OK') {
                $kode_kelas = get_randChar(10);
                DB::beginTransaction();
                try {
                    // buat kelas baru
                    Kelas::create([
                        'kode_kelas' => $kode_kelas,
                        'thsmt' => $this->_getThnSmtNow(),
                        'kode_pelatih' => auth()->user()->code,
                        'nama_kelas' => $data->nama_kelas,
                        'durasi_latihan' => $data->durasi_latihan,
                        'avatar' => $data->avatar
                    ]);
                    // tambahkan akses kelas untuk pembuat kelas
                    Acc_class::create([
                        'kode_kelas' => $kode_kelas,
                        'kode_pelatih' => auth()->user()->code
                    ]);
                    DB::commit();
                    return redirect()->back()->with('success', 'Berhasil Menambahkan Kelas Baru');
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->with('failed', 'Terdapat Kegagalan Dalam Melakukan Proses');
                }
            } elseif ($checkAuth == 'FAIL') {
                return redirect('/home')->with('failed', 'Anda Tidak Memiliki Izin Untuk Membuat Kelas');
            } else {
                return redirect()->route('logout');
            }
        }
    }

    public function rec_latihan(Request $key)
    {
        if ($key->has('key')) {
            $file = Kelas::where('kode_kelas', '=', $key->key)->first();
            if ($file) {
                $check = checkAuthAccClass($file->kode_kelas);
                // jika tidak ada pesan check
                if (!$check) {
                    return redirect('/kelas')->with('failed', 'Akses Dibatalkan');
                } else {
                    $kelas = $file->kode_kelas;
                    $title = "Karate | " . getClassNameByCode($kelas);
                    // jika terdapat kode peserta maka akan menampilkan halaman detail latihan peserta
                    if ($key->has('pst')) {
                        $data_peserta = ['kode_peserta' => $key->pst, 'kode_kelas_peserta' => $key->key];
                        // cek apakah terdapat peserta dengan kode tersebut
                        $check_peserta = checkPstByClassAndCode($key->key, $key->pst);
                        if ($check_peserta == 'OK') {
                            $record_peserta = DB::table('record_latihan')->where([['kode_kelas_peserta', '=', $kelas], ['kode_peserta', '=', $key->pst], ['thsmt', '=', getThnSmtClassByCode($kelas)]])->orderBy('created_at', 'desc')->get();
                            return view('body.kelas.lte_kelas_record_latihan_detail', compact(['title', 'data_peserta', 'record_peserta']));
                        } elseif ($check_peserta == 'FAIL') {
                            return redirect('/kelas')->with('failed', 'Siswa Tidak Ditemukan');
                        } else {
                            return ['message' => $check_peserta];
                        }
                    } else {
                        $peserta = DB::table('peserta_data')->where('kode_kelas_peserta', '=', $kelas)->get();
                        return view('body.kelas.lte_kelas_record_latihan', compact(['title', 'kelas', 'peserta']));
                    }
                }
            } else {
                return redirect('/kelas')->with('failed', 'Kelas Tidak Ditemukan');
            }
        } else {
            return redirect()->route('kelas.home');
        }
    }

    public function rec_persyaratan(Request $key)
    {
        if ($key->has('key')) {
            $file = Kelas::where('kode_kelas', '=', $key->key)->first();
            if ($file) {
                $check = checkAuthAccClass($file->kode_kelas);
                // jika tidak ada pesan check
                if (!$check) {
                    return redirect('/kelas')->with('failed', 'Akses Dibatalkan');
                } else {
                    $kelas = $file->kode_kelas;
                    $title = "Karate | " . getClassNameByCode($kelas);
                    // jika terdapat kode peserta maka akan menampilkan halaman detail latihan peserta
                    if ($key->has('pst')) {
                        $data_peserta = ['kode_peserta' => $key->pst, 'kode_kelas_peserta' => $key->key];
                        // cek apakah terdapat peserta dengan kode tersebut
                        $check_peserta = checkPstByClassAndCode($key->key, $key->pst);
                        if ($check_peserta == 'OK') {
                            return view('body.kelas.lte_kelas_record_persyaratan_detail', compact(['title', 'data_peserta']));
                        } elseif ($check_peserta == 'FAIL') {
                            return redirect('/kelas')->with('failed', 'Siswa Tidak Ditemukan');
                        } else {
                            return ['message' => $check_peserta];
                        }
                    } else {
                        $peserta = DB::table('peserta_data')->where('kode_kelas_peserta', '=', $kelas)->get();
                        return view('body.kelas.lte_kelas_record_persyaratan', compact(['title', 'kelas', 'peserta']));
                    }
                }
            } else {
                return redirect('/kelas')->with('failed', 'Kelas Tidak Ditemukan');
            }
        } else {
            return redirect()->route('kelas.home');
        }
    }

    public function save_record_training(Request $data)
    {
        $validate = Validator::make($data->all(), [
            'class_code' => 'required',
            'code_rec' => 'required',
            'keterangan' => 'required',
            'durasi' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses')->withErrors($validate)->withInput();
        } else {
            // cek apakah pelatih dapat melakukan record
            $check = getAccessToRecordClassByUserCode($data->class_code);
            if ($check == 'OK') {
                $new_rec_code = get_randChar(15);
                DB::beginTransaction();
                try {
                    // melakukan perulangan untuk mengambil data peserta
                    foreach ($data->code_rec as $pst) {
                        Record_Latihan::create([
                            'thsmt' => getThnSmtClassByCode($data->class_code),
                            'kode_kelas_peserta' => $data->class_code,
                            'kode_peserta' => $pst,
                            'kode_pelatih' => auth()->user()->code,
                            'keterangan' => $new_rec_code,
                            'durasi' => $data->durasi
                        ]);
                    }
                    // menambahkan data pada record info
                    Record_Latihan_Info::create([
                        'kode_pelatih' => auth()->user()->code,
                        'kode_info' => $new_rec_code,
                        'keterangan' => $data->keterangan
                    ]);
                    DB::commit();
                    return redirect()->back()->with('success', 'Record Latihan Berhasil Ditambahkan');
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->with('failed', 'Gagal Menyimpan Record Latihan');
                }
            } elseif ($check == 'FAIL') {
                return redirect('/kelas')->with('failed', 'Anda Tidak Memiliki Akses Pada Kelas Tersebut');
            } else {
                return redirect()->route('logout');
            }
        }
    }

    public function save_record_requirement(Request $data)
    {
        if ($data->kode_kelas && $data->kode_peserta) {
            if ($data->type == 'budget') {
                $validate = Validator::make($data->all(), [
                    'kredit' => 'required|min:4|max:6'
                ]);

                if ($validate->fails()) {
                    return redirect()->back()->with('failed', 'Proses Pembayaran Gagal')->withErrors($validate)->withInput();
                } else {
                    Record_Budget::create([
                        'thsmt' => getThnSmtClassByCode($data->kode_kelas),
                        'kode_kelas' => $data->kode_kelas,
                        'kode_peserta' => $data->kode_peserta,
                        'kode_pj' => auth()->user()->code,
                        'aggregate' => '+',
                        'kredit' => $data->kredit,
                        'keterangan' => 'Payment of Exam Fees',
                        'saldo' => post_newSaldoUser_by_code($data->kode_kelas, $data->kode_peserta, $data->kredit)
                    ]);
                    return redirect()->back()->with('success', 'Pembayaran Berhasil Diproses');
                }
            } elseif ($data->type == 'file') {
                $validate = Validator::make($data->all(), [
                    'kode_file' => 'required',
                    'file_info' => 'required'
                ]);

                if ($validate->fails()) {
                    return redirect()->back()->with('failed', 'Proses Persyaratan Gagal')->withErrors($validate)->withInput();
                } else {
                    Record_File::create([
                        'thsmt' => getThnSmtClassByCode($data->kode_kelas),
                        'kode_kelas' => $data->kode_kelas,
                        'kode_peserta' => $data->kode_peserta,
                        'kode_pj' => auth()->user()->code,
                        'kode_file' => $data->kode_file,
                        'file_info' => $data->file_info
                    ]);
                    return redirect()->back()->with('success', 'Persyaratan Berhasil Diproses');
                }
            } else {
                return redirect('/kelas')->with('failed', 'Proses Dibatalkan');
            }
        } else {
            # code...
        }
    }

    public function cashback_payment_examn(Request $key)
    {
        $validate = Validator::make($key->all(), [
            'class_code' => 'required|alpha_num',
            'kode_peserta' => 'required|alpha_num'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses');
        } else {
            if ($key->class_code && $key->kode_peserta) {
                if (get_lastSaldoUser_by_code($key->class_code, $key->kode_peserta) > getCostExamnPstByClassAndCode($key->class_code, $key->kode_peserta)) {
                    $getMore = getExamnMorePaymentPst(getCostExamnPstByClassAndCode($key->class_code, $key->kode_peserta), get_lastSaldoUser_by_code($key->class_code, $key->kode_peserta));
                    $cashback = Record_Budget::create([
                        'thsmt' => getThnSmtClassByCode($key->class_code),
                        'kode_kelas' => $key->class_code,
                        'kode_peserta' => $key->kode_peserta,
                        'kode_pj' => auth()->user()->code,
                        'aggregate' => '-',
                        'kredit' => $getMore,
                        'keterangan' => 'Exam Fee Refunds',
                        'saldo' => post_decSaldoUser_by_code($key->class_code, $key->kode_peserta, $getMore)
                    ]);
                    if ($cashback == TRUE) {
                        return redirect()->back()->with('success', 'Pengembalian Biaya Berhasil Diproses');
                    } else {
                        return redirect()->back()->with('failed', 'Pengembalian Biaya Gagal Diproses');
                    }
                } else {
                    return redirect()->back()->with('failed', 'Tidak Ditemukan Kelebihan Biaya Pada Peserta Tersebut');
                }
            } else {
                return redirect()->back()->with('failed', 'Peserta Tidak Ditemukan');
            }
        }
    }

    public function pesertaBudgetRefundsAll(Request $data)
    {
        $validate = Validator::make($data->all(), [
            'class_code' => 'required|alpha_num',
            'kode_peserta' => 'required|alpha_num'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('failed', 'Terdapat Kesalahan Dalam Proses GAGAL');
        } else {
            if (get_lastSaldoUser_by_code($data->class_code, $data->kode_peserta) > 0) {
                $refundsAll = Record_Budget::create([
                    'thsmt' => getThnSmtClassByCode($data->class_code),
                    'kode_kelas' => $data->class_code,
                    'kode_peserta' => $data->kode_peserta,
                    'kode_pj' => auth()->user()->code,
                    'aggregate' => '-',
                    'kredit' => get_lastSaldoUser_by_code($data->class_code, $data->kode_peserta),
                    'keterangan' => 'Exam Fee Refunds',
                    'saldo' => post_decSaldoUser_by_code($data->class_code, $data->kode_peserta, get_lastSaldoUser_by_code($data->class_code, $data->kode_peserta))
                ]);
                if ($refundsAll == TRUE) {
                    return redirect()->back()->with('success', 'Berhasil Mengembalikan Seluruh Dana Peserta');
                } else {
                    return redirect()->back()->with('failed', 'Gagal Mengembalikan Seluruh Dana Peserta');
                }
            } else {
                return redirect()->back()->with('failed', 'Apa yang mau dikembalikan?');
            }
        }
    }

    // end of file

    # PRIVATE FUNCTION
    # get thsmt now #THIS_IS_VALID
    private function _getThnSmtNow()
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
}
