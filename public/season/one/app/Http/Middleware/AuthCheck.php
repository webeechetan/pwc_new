<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
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
        if(!(session()->has('user')) && ($request->path() != 'admin/signup' && $request->path() != 'admin/signin')) {
            return redirect('admin/signin') -> with('fail', 'You must be logged in');
        }
        if((session()->has('user')) && ($request->path() == 'admin/signup' || $request->path() == 'admin/signin')) {
            return redirect('/admin/');
        }
        return $next($request);
    }
}
