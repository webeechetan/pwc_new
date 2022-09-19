<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Committee_Pilot_Check
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
        if(( !(session()->has('pilot')) && ($request->segment(1) != 'pilot_companies') ) && ( !(session()->has('committee')) && ($request->segment(1) != 'committee_member') )) {
            return redirect(env('APP_URL').'/pilot_companies') -> with('fail', 'You must be logged in');
        }
        if(( (session()->has('pilot')) && ($request->path() == 'pilot_companies') ) || (session()->has('committee')) && ($request->path() == 'committee_member')) {
            return redirect(env('APP_URL').'/');
        }
        
        return $next($request) -> header("Cache-Control", "no-cache, no-store, max-age=0, must-revalidate")
                               -> header("pragma", "no-cache")
                               -> header("Expires", "Mon, 26 Jul 1997 05:00:00 GMT");
    }
}
