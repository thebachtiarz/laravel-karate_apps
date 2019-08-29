<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Data_Pelatih;
use App\Kelas;

class AdminsController extends Controller
{
    public function setting()
    {
        return view('admins.settings.lte_setting_home', ['title' => 'Karate | Admin Settings']);
    }

    public function edituser($id)
    {
        $user_data = User::find($id)->toArray();

        if (($user_data['status'] == 'bestnimda') || ($user_data['status'] == 'moderator') || ($user_data['status'] == 'treasurer') || ($user_data['status'] == 'instructor')) {
            $data = User::select(['users.id', 'users.status', 'users.name', 'users.email', 'users.born', 'users.phone', 'users.id_line', 'users.code', 'pelatih_data.msh_pelatih', 'users.created_at'])->where('users.id', '=', $id)->leftJoin('pelatih_data', 'users.code', '=', 'pelatih_data.kode_pelatih')->first()->toArray();
        } elseif ($user_data['status'] == 'participants') {
            $data = User::select(['users.id', 'users.status', 'users.name', 'users.email', 'users.born', 'users.phone', 'users.id_line', 'users.code', 'peserta_data.noinduk', 'users.created_at'])->where('users.id', '=', $id)->leftJoin('peserta_data', 'users.code', '=', 'peserta_data.kode_peserta')->first()->toArray();
        } else {
            $data = User::select(['users.id', 'users.status', 'users.name', 'users.email', 'users.born', 'users.phone', 'users.id_line', 'users.code', 'users.created_at'])->where('users.id', '=', $id)->first()->toArray();
        }

        if ($user_data['status'] != 'bestnimda') {
            $title = "Karate | Edit User";
            return view('admins.settings.lte_setting_user_edit', compact(['title', 'data']));
        } else {
            return redirect()->back()->with('failed', 'User Tidak Ditemukan');
        }
    }

    public function hapususer($id)
    {
        User::find($id)->delete();
        return redirect()->back()->with('success', 'User Berhasil Dihapus');
    }

    public function usereditsave(Request $data, $id)
    {
        if ($data->type == 'updateToModerator') {
            // do transaction and update to table users and create new data in pelatih_data
            $new_code = get_randChar(64);
            DB::beginTransaction();
            try {
                // update status user
                DB::table('users')->where('id', $id)->update(['status' => 'moderator', 'code' => $new_code]);
                // buat data pelatih baru
                Data_Pelatih::create([
                    'kode_pelatih' => $new_code,
                    'nama_pelatih' => $data->name_user
                ]);
                DB::commit();
                return redirect()->back()->with('success', 'Update Status Berhasil');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('failed', 'Terdapat Kegagalan Dalam Melakukan Proses');
            }
            // dd($data->all(), $id);
        } else {
            dd('false');
        }
    }

    public function editkelas($id)
    {
        $kelas_data = Kelas::find($id)->toArray();
        $title = "Karate | Edit Kelas";
        return view('admins.settings.lte_setting_class_edit', compact(['title', 'kelas_data']));
    }

    public function hapuskelas($id)
    {
        Kelas::find($id)->delete();
        return redirect()->back()->with('success', 'Kelas Berhasil Dihapus');
    }



    // menu terminal
    public function terminal()
    {
        $title = "Admin Terminal";
        return view('admins.menu.menu_terminal', compact(['title']));
    }

    public function terminalPost(Request $data)
    {
        if ($data->key != NULL) {
            $query = DB::select(DB::raw($data->key));
            if ($query == true) {
                return dd($query);
            } else {
                return dd('false query !!');
            }
        } else {
            return dd('false query !!');
        }
    }
}
