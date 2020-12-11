<?php

namespace App\Http\Middleware;

use Closure,Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     agregue || (Auth::user()->role == "2") || (Auth::user()->role == "3")*/
    public function handle($request, Closure $next)
    {   
        if((Auth::user()->role == "1") || (Auth::user()->role == "2") || (Auth::user()->role == "3") || (Auth::user()->role == "4")):
            return $next($request);
        else:
            return redirect('/');
        endif;

    }
}
