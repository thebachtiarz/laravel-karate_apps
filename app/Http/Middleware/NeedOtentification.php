<?php

namespace App\Http\Middleware;

use Closure;

class NeedOtentification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((auth()->user()->status == 'guests') || (auth()->user()->status == 'parents') || (needOtentificationAgain() == 'OK')) {
            return $next($request);
        } else {
            return redirect('/home')->with('info', 'Anda Sudah Melakukan Otentifikasi');
        }
    }
}
