<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
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
        //return \App::abort(403);
        if(!\Auth::guard('user')->check()){ 
            return \Redirect::route('login');
        }
        return $next($request);
    }
}

