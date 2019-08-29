<?php

namespace App\Http\Middleware;

use Closure;

class AccountNeedOtentification
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
        if (needOtentificationAgain() == 'OK') {
            return redirect('/otentifikasi')->with('info', 'Anda Perlu Melakukan Otentifikasi Kembali');
        } else {
            return $next($request);
        }
    }
}
