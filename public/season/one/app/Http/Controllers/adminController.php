<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Validation\Rule;

class adminController extends Controller
{
    public function index(Request $request) {
        $requestType= $request->query('request');
        if( $requestType === 'table') {
            $users = Admin::where('id', '!=', '1')->with('roles')->get();
            return response()->json($users);
        } else return view("admin.user.list");
    }

    public function create(Request $request) {
        if( $request->method() === 'GET') {
            $roles = Roles::where('slug', '!=', 'superadmin')->get();
            return view("admin.user.add", ['roles' => $roles]);
        }
        // Update Request
        $success = false;
        $message = "Something went wrong";

        $request->validate([
            'fullname' => 'required',
            'role' => 'required',
            'email' => ['required', 'unique:admin'],
            'password' => ['required', 'min:6'],
        ]);

        $roles = Roles::find($request['role'])->where('slug', '!=', 'superadmin')->get()->first();
        if($roles)
        {
            $user = Admin::create([
                'role_id' => $roles->id,
                'fullname' => $request['fullname'],
                'email' => $request['email'],
                'password' => Crypt::encryptString($request['password'])
            ]);

            if($user)
            {
                $success = true;
                $message = "Successfully added";
            }
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function update(Request $request) {

        $user = Admin::findOrFail(request() -> id);
        if(!$user) return redirect() -> back();

        $roles = Roles::where('slug', '!=', 'superadmin')->get();
        $user -> password = $decrypted_password = Crypt::decryptString($user -> password);
        if( $request->method() === 'GET') return view("admin.user.edit", ["data" => $user, "roles"=>$roles]);

        /* | Update Request | */
        $success = false;
        $message = "Something went wrong";
        $request->validate([
            'fullname' => 'required',
            'role' => 'required',
            'email' => ['required', Rule::unique('admin')->where(function ($query) use ($request) {
                global $user;
                return $query->where('id', '!=', request()->id);
            })],
            'password' => ['required', 'min:6'],
        ]);
        $roles = Roles::where([['slug', '!=', 'superadmin'], ['id', $request['role']]])->get()->first();
            $user -> fullname = $request['fullname'];
            $user -> role_id = $roles->id;
            $user -> email = $request['email'];
            $user -> password = Crypt::encryptString($request['password']);
            $user -> save();
            if($user)
            {
                $success = true;
                $message = "Successfully updated";
            }
        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function delete() {
        $success = false;
        $message = "Something went wrong";

        $user = Admin::findOrFail(request() -> id);
        if($user)
        {
            $user -> delete();
            if($user)
            {
                $success = true;
                $message = "Successfully deleted";
            }
        }
        
        return response()->json(['success' => $success, 'message' => $message]);
    }
}
