<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Permission;

class Privilege
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
        $user = Admin::where("id", session('user')->id)->with('roles')->get()->first();
        if($user->roles->slug === 'superadmin') return $next($request);
        if($user) {
            $permission = Permission::where('role_id', $user->role_id)->with('modules')->with('actions')->get();

            if($permission)
            {
                foreach($permission as $p)
                {
                    $modulePath = $request->segment(2);
                    if($p->modules->slug === $modulePath)
                    {
                        if($request->route()->getActionMethod() === $p->actions->slug){
                            return $next($request);
                        }
                    }
                }
            }
        }
        if($request->method() === 'GET') return redirect()->back();
        // return response(['Maintenance'], 503);
        return response(['success' => false, 'message' => 'You do not have Permission!'], 503);
        exit();
    }
}
