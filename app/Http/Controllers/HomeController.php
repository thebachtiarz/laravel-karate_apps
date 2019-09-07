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
            // $array = [
            //     '0' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '3'],
            //     '1' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '4'],
            //     '2' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '1'],
            //     '3' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '10'],
            //     '4' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '6'],
            //     '5' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '2'],
            //     '6' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '9'],
            //     '7' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '5'],
            //     '8' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '8'],
            //     '9' => ['a' => 'aaaaa', 'b' => 'bbbbb', 'c' => 'ccccc', 'd' => 'ddddd', 'e' => 'eeeee', 'f' => '7']
            // ];

            // foreach ($array as $key) {
            //     $data[] = $key;
            // }
            // rsort($data);
            // dd($data);

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
