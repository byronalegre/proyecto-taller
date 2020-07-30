<?php

namespace App\Http\Middleware;

use Closure, Route, Auth;

class Permisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     agregue 
    || (Auth::user()->role == "2") || (Auth::user()->role == "3"))
    if(Auth::user()->role == "0"):
     return redirect('/');*/

    public function handle($request, Closure $next)
    {
        if(((Auth::user()->role == "1") || (Auth::user()->role == "2") || (Auth::user()->role == "3")) && (kvfj(Auth::user()->permisos, Route::currentRouteName()) == true)):
            return $next($request);
        else:
            if(Auth::user()->role == "0"):
                return redirect('/');
            else:
                return redirect('/admin');
            endif;
        endif;
    }
}
