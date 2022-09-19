<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Module;
use App\Models\Action;
use App\Models\Permission;
use Illuminate\Validation\Rule;

class roleController extends Controller
{
    public function index(Request $request) {
        $requestType= $request->query('request');
        if( $requestType === 'table') {
            $role = Roles::where('id', '!=', '1')->get();
            return response()->json($role);
        } else return view("admin.role.list");
    }

    public function create(Request $request) {
        if( $request->method() === 'GET') {
            $module = Module::all();
            for($i = 0; $i < count($module); $i++)
            {
                $moduleAction = explode(',', $module[$i]->action);
                $actions = Action::whereIn('id', $moduleAction) -> get();
                $module[$i]->allactions = $actions;
            }
            return view("admin.role.add", ['roles' => $module]);
        }
        // Update Request
        $success = false;
        $message = "Something went wrong";

        $request->validate([
            'name' => 'required|unique:role',
            'slug' => 'required|unique:role',
        ]);
        $role = Roles::create([
            'name' => $request['name'],
            'slug' => $request['slug']
        ]);

        if($role)
        {
            $actions = $request['action'];
            foreach($actions as $actionIndex =>  $actionValue)
            {
                $module = Module::findOrFail($actionIndex);
                if($module)
                {
                    foreach($actionValue as $av)
                    {
                        $action = Action::findOrFail($av);
                        if($action)
                        {
                            $permission = Permission::create([
                                'is_active' => 1,
                                'role_id' => $role->id,
                                'module_id' => $module->id,
                                'action_id' => $action->id,
                            ]);
                        }
                    }
                }  
            }
            $success = true;
            $message = "Successfully added";
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function update(Request $request) {
        //Get All Moduls and Their Actions
        $module = Module::all();
        for($i = 0; $i < count($module); $i++)
        {
            $moduleAction = explode(',', $module[$i]->action);
            $actions = Action::where('is_active', 1)->whereIn('id', $moduleAction) -> get();
            $module[$i]->allactions = $actions;
            
            $permissions = Permission::where([['module_id', $module[$i] -> id], ['role_id', request() -> id]]) -> get()->pluck('action_id')->toArray();
            $module[$i]->givenpermission = $permissions;
        }
        // print_r(json_encode($module));
        // die();
        // Getting Selected Role Data
        $role = Roles::where('id', request() -> id)->get()->first();
        // Getting Selected Role Given Permission
        $roleactions = Permission::where('role_id', $role->id)->get()->pluck('action_id')->toArray();
        
        // Redirect if The role is not there
        if(!$role || empty($role)) return redirect() -> back();
        if($role->slug === 'superadmin') return redirect() -> back();
        
        if( $request->method() === 'GET') return view("admin.role.edit", ["data" => $role, 'roleactions' => $roleactions, 'roles' => $module]);

        /* | Update Request | */
        $success = false;
        $message = "Something went wrong";

        $request->validate([
            'name' => ['required', Rule::unique('role')->where(function ($query) use ($request) {
                return $query->where('id', '!=', request()->id);
            })],
            'slug' => ['required', Rule::unique('role')->where(function ($query) use ($request) {
                return $query->where('id', '!=', request()->id);
            })],
        ]);


        $role -> name = $request['name'];
        $role -> slug = $request['slug'];
        $role -> save();
        if($role)
        {
            Permission::where('role_id', request()->id)->delete();
            $actions = $request['action'] ?? [];
            foreach($actions as $actionIndex =>  $actionValue)
            {
                $module = Module::findOrFail($actionIndex);
                if($module)
                {
                    foreach($actionValue as $av)
                    {
                        // if(!in_array($av), $roleactions)
                        // {
                            $action = Action::findOrFail($av);
                            if($action)
                            {
                                $permission = Permission::create([
                                    'is_active' => 1,
                                    'role_id' => $role->id,
                                    'module_id' => $module->id,
                                    'action_id' => $action->id,
                                ]);
                            }
                        // }
                    }
                }  
            }
            $success = true;
            $message = "Successfully updated";
        }

        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function delete() {
        $success = false;
        $message = "Something went wrong";

        $role = Roles::findOrFail(request() -> id);
        
        if($role)
        {
            if($role->slug === 'evaluator' || $role->slug === 'superadmin') {
                $message = "You do not have Permission!";
            } else
            {
                $role -> delete();
                if($role)
                {
                    Permission::where('role_id', request()->id)->delete();
                    $success = true;
                    $message = "Successfully deleted";
                }
            }
        }
        
        return response()->json(['success' => $success, 'message' => $message]);
    }
}
