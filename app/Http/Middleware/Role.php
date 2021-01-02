<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $customRole = null)
    {
        if(Auth::user()->roles == 'Admin' || Auth::user()->roles == $customRole)
        {
            return $next($request);
        }
        $string = 'You dont have Admin';
        if ($customRole){
            return redirect('administrator')->with(['status' => 'error' ,'message' => $string . ' or ' . $customRole . ' access']);
        }
        return redirect('administrator')->with(['status' => 'error' ,'message' => $string . ' access']);
    }
}
