<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PilotAuthCheck
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
        
        if(!(session()->has('pilot')) && ($request->segment(1) != 'pilot_companies')) {
            return redirect(env('APP_URL').'/pilot_companies') -> with('fail', 'You must be logged in');
        }
        if((session()->has('pilot')) && ($request->path() == 'pilot_companies')) {
            return redirect(env('APP_URL').'/');
        }
        
        return $next($request) -> header("Cache-Control", "no-cache, no-store, max-age=0, must-revalidate")
                               -> header("pragma", "no-cache")
                               -> header("Expires", "Mon, 26 Jul 1997 05:00:00 GMT");
    }
}
