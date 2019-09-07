<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->user()) {
            return redirect('/home')->with('info', 'Anda Sudah Login');
        } else {
            return view('auth.login');
        }
    }

    public function signin(Request $data)
    {
        $validate = Validator::make($data->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            if ($data->count) {
                if ($data->count == '1') {
                    return redirect()->away('https://www.google.com/search?q=cara+login+yang+baik+dan+benar');
                } else {
                    $count = $data->count - 1;
                    session()->flash('pull', $count);
                    if ($data->count == '3') {
                        $msg = "Silahkan Mencoba Kembali";
                    } elseif ($data->count == '2') {
                        $msg = "Kok Masih Ngeyel Sih";
                    }
                    session()->flash('failed', $msg);
                    return redirect('/')->withErrors($validate)->withInput();
                }
            } else {
                $count = '3';
                session()->flash('pull', $count);
                return redirect('/')->withErrors($validate)->withInput();
            }
        } else {
            if ($data->only(['email', 'password'])) {
                if (Auth::attempt($data->only('email', 'password'))) {
                    if (Auth::user()->code) {
                        return redirect('/home')->with('success', 'Selamat Datang ' . auth()->user()->name);
                    } else {
                        $data = Auth::user()->created_at;
                        $expire = date('Y-m-d', strtotime('+6 days', strtotime($data)));
                        if (date('Y-m-d') <= $expire) {
                            return redirect('/home')->with('success', 'Selamat Datang ' . auth()->user()->name);
                        } else {
                            User::where('email', '=', Auth::user()->email)->delete();
                            Auth::logout();
                            return redirect('/')->with('failed', 'Akun Anda sudah kedaluwarsa, karena tidak segera melakukan otentifikasi, silahkan mendaftar kembali.');
                        }
                    }
                }
                return redirect('/')->with('failed', 'Akun Tidak Ditemukan.');
            } else {
                return redirect('/')->with('failed', 'Harap isi Email dan Password dengan benar.');
            }
        }
    }

    public function daftar(Request $key)
    {
        if ($key->has('mediasize')) {
            return view('auth.register_mobile', ['title' => 'Register Apps']);
        }
        return view('auth.register', ['title' => 'Register Apps']);
    }

    public function register(Request $data)
    {
        $validate = Validator::make($data->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'pass_a' => 'required',
            'pass_b' => 'required|same:pass_a'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('failed', 'Registrasi gagal, harap periksa kembali')->withErrors($validate)->withInput();
        } else {
            User::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => bcrypt($data->pass_b),
                'remember_token' => str_random(60),
                'status' => "guests"
            ]);
            session()->flash('success', 'Registrasi berhasil, selamat datang');
            return redirect()->route('login');
        }
    }

    public function lupa_password()
    {
        return "Halaman Lupa Password";
    }

    public function forget_password(Request $data)
    {
        return "Input ke tabel Password Reset";
    }

    public function signout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Anda Berhasil Logout');
    }
}
