<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\User;

class HomeController extends Controller
{
    public function home()
    {
        if (Auth::user()->code) {
            // return view('home.index', ['title' => 'Karate | Home']);
            return View::make('home.lte_home', ['title' => 'Karate | Home']);
        } else {
            $data = Auth::user()->created_at;
            $expire = date('Y-m-d', strtotime('+6 days', strtotime($data)));
            // return view('home.home_usernocode', ['title' => 'Karate | Home']);
            return View::make('home.lte_home_usernocode', ['title' => 'Karate | Home', 'expire' => $expire]);
        }
    }
}
