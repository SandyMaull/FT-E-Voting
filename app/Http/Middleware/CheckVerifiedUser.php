<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckVerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'voter')
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::guard('voter')->user()->verified === 1) {
                return $next($request);
            }
            else {
                Auth::guard('voter')->logout();
                return redirect(route('masuk'))->with('errors', 'User Belum Terverifikasi!');
            }
        }
        return redirect(route('masuk'));
    }
}
