<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StartupAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!(session()->has('startup')) && ($request->segment(1) != 'auth')) {
            return redirect(env('APP_URL').'/auth') -> with('fail', 'You must be logged in');
        }
        if((session()->has('startup')) && ($request->path() == 'auth')) {
            return redirect(env('APP_URL').'/');
        }
        return $next($request) -> header("Cache-Control", "no-cache, no-store, max-age=0, must-revalidate")
                               -> header("pragma", "no-cache")
                               -> header("Expires", "Mon, 26 Jul 1997 05:00:00 GMT");
    }
}
