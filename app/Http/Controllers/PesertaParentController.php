<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Record_Latihan;
use App\Record_Budget;
use App\PrivateChildsParents;

class PesertaParentController extends Controller
{
    public function time_training(Request $req)
    {
        $title = 'Karate | Latihan';
        if (auth()->user()->status == 'participants') {
            if ($req->has('thsmt')) {
                $validate = Validator::make($req->all(), [
                    'thsmt' => 'required|numeric|digits_between:6,6'
                ]);
                if ($validate->fails()) {
                    return $this->_redirectFailed('/latihan', 'Riwayat Latihan Tidak Ditemukan');
                } else {
                    $getdata = Record_Latihan::where([['thsmt', '=', $req->thsmt], ['kode_kelas_peserta', '=', getClassCodeByPstCode(auth()->user()->code)], ['kode_peserta', '=', auth()->user()->code]])->orderBy('created_at', 'desc')->get();
                    if (json_decode($getdata) == NULL) {
                        return $this->_redirectFailed('/latihan', 'Riwayat Latihan Tidak Ditemukan');
                    }
                    // $data = $getdata;
                }
            } else {
                // $data = Record_Latihan::where([['thsmt', '=', getThnSmtClassByCode(getClassCodeByPstCode(auth()->user()->code))], ['kode_kelas_peserta', '=', getClassCodeByPstCode(auth()->user()->code)], ['kode_peserta', '=', auth()->user()->code]])->orderBy('created_at', 'desc')->get();
            }
            return view('peserta_parent.lte_time_training', compact(['title']));
        } elseif (auth()->user()->status == 'parents') {
            if ($req->has('thsmt')) {
                $validate = Validator::make($req->all(), [
                    'thsmt' => 'required|numeric|digits_between:6,6'
                ]);
                if ($validate->fails()) {
                    return $this->_redirectFailed('/latihan', 'Riwayat Latihan Tidak Ditemukan');
                } else {
                    // cari kode anak pada tabel private_childs_parents
                    $getChilds = PrivateChildsParents::select(['childs_code'])->where('parents_code', '=', auth()->user()->code)->get();
                    if (json_decode($getChilds) != NULL) {
                        foreach ($getChilds as $getCh) {
                            $getdata = Record_Latihan::where([['thsmt', '=', $req->thsmt], ['kode_kelas_peserta', '=', getClassCodeByPstCode($getCh->childs_code)], ['kode_peserta', '=', $getCh->childs_code]])->orderBy('created_at', 'desc')->first();
                            // if (json_decode($getdata) == NULL) {
                            //     return $this->_redirectFailed('/latihan', 'Riwayat Latihan Tidak Ditemukan');
                            // }
                        }
                        $data = $getChilds;
                    } else {
                        return $this->_redirectFailed('/latihan', 'Riwayat Latihan Tidak Ditemukan');
                    }
                }
            } else {
                // cari kode anak pada tabel private_childs_parents
                $getChilds = PrivateChildsParents::select(['childs_code'])->where('parents_code', '=', auth()->user()->code)->get();
                if (json_decode($getChilds) != NULL) {
                    $data = $getChilds;
                } else {
                    return $this->_redirectFailed('/latihan', 'Riwayat Latihan Tidak Ditemukan');
                }
            }
            return view('peserta_parent.lte_time_training', compact(['title', 'data']));
        } else {
            return redirect()->route('home');
        }
    }

    public function exam_requirements(Request $req)
    {
        $title = 'Karate | Persyaratan Ujian';
        if (auth()->user()->status == 'participants') {
            if ($req->has('thsmt')) {
                // dd($req->thsmt);
                $validate = Validator::make($req->all(), [
                    'thsmt' => 'required|numeric|digits_between:6,6'
                ]);
                if ($validate->fails()) {
                    return $this->_redirectFailed('/persyaratan', 'Riwayat Persyaratan Tidak Ditemukan');
                } else {
                    $getdata = Record_Budget::where([['thsmt', '=', $req->thsmt], ['kode_kelas', '=', getClassCodeByPstCode(auth()->user()->code)], ['kode_peserta', '=', auth()->user()->code]])->orderBy('created_at', 'desc')->get();
                    if (json_decode($getdata) == NULL) {
                        return $this->_redirectFailed('/persyaratan', 'Riwayat Persyaratan Tidak Ditemukan');
                    }
                    $data = $getdata;
                }
            } else {
                $data = Record_Budget::where([['thsmt', '=', getThnSmtClassByCode(getClassCodeByPstCode(auth()->user()->code))], ['kode_kelas', '=', getClassCodeByPstCode(auth()->user()->code)], ['kode_peserta', '=', auth()->user()->code]])->orderBy('created_at', 'desc')->get();
            }
            return view('peserta_parent.lte_requirements_exam', compact(['title']));
        } elseif (auth()->user()->status == 'parents') {
            if ($req->has('thsmt')) {
                $validate = Validator::make($req->all(), [
                    'thsmt' => 'required|numeric|digits_between:6,6'
                ]);
                if ($validate->fails()) {
                    return $this->_redirectFailed('/persyaratan', 'Riwayat Persyaratan Tidak Ditemukan');
                } else {
                    // cari kode anak pada tabel private_childs_parents
                    $getChilds = PrivateChildsParents::select(['childs_code'])->where('parents_code', '=', auth()->user()->code)->get();
                    if (json_decode($getChilds) != NULL) {
                        foreach ($getChilds as $getCh) {
                            $getdata = Record_Budget::where([['thsmt', '=', $req->thsmt], ['kode_kelas', '=', getClassCodeByPstCode($getCh->childs_code)], ['kode_peserta', '=', $getCh->childs_code]])->orderBy('created_at', 'desc')->first();
                            // if (!$getdata) {
                            //     return $this->_redirectFailed('/persyaratan', 'Riwayat Persyaratan Tidak Ditemukan');
                            // }
                        }
                        $data = $getChilds;
                    } else {
                        return $this->_redirectFailed('/persyaratan', 'Riwayat Persyaratan Tidak Ditemukan');
                    }
                }
            } else {
                // cari kode anak pada tabel private_childs_parents
                $getChilds = PrivateChildsParents::select(['childs_code'])->where('parents_code', '=', auth()->user()->code)->get();
                if (json_decode($getChilds) != NULL) {
                    $data = $getChilds;
                } else {
                    return $this->_redirectFailed('/persyaratan', 'Riwayat Persyaratan Tidak Ditemukan');
                }
            }
            return view('peserta_parent.lte_requirements_exam', compact(['title', 'data']));
        } else {
            return redirect()->route('home');
        }
    }

    public function monthly_fee()
    {
        $title = "Karate | SPP Bulanan";
        if (auth()->user()->status == 'participants') {
            return view('peserta_parent.lte_spp_fee', compact(['title']));
        } elseif (auth()->user()->status == 'parents') {
            // cari kode anak pada tabel private_childs_parents
            var_dump('echo');
            $getChilds = PrivateChildsParents::select(['childs_code'])->where('parents_code', '=', auth()->user()->code)->get();
            if (json_decode($getChilds) != NULL) {
                $data = $getChilds;
            } else {
                return $this->_redirectFailed('/persyaratan', 'Riwayat Persyaratan Tidak Ditemukan');
            }
            return view('peserta_parent.lte_spp_fee', compact(['title', 'data']));
        } else {
            return redirect()->route('home');
        }
    }


    # PRIVATE METHOD
    // handle redirect
    private function _redirectFailed($url = '', $message = '')
    {
        if ($message) {
            return redirect($url)->with('failed', $message);
        } else {
            return redirect($url)->with('failed', 'Terdapat Kesalahan Dalam Proses');
        }
    }
}
