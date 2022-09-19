<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin;

class authController extends Controller {
    public function index() {
        // dd(Crypt::encryptString('9Dw@zt;D'));
        // dd(Crypt::decryptString('eyJpdiI6Ilg5azVzN0hhcFg4bG1GdXkxTGZMclE9PSIsInZhbHVlIjoiVnIya1JqTnVRZVFscmxyaVJwMDBzZz09IiwibWFjIjoiNWFjZGZjYzFlZjdhNzkzM2U2MTQzZTAwYWUzMjE5YTZhZTE3YmQwYzNhNTEwYTFiZjM1ZDc0ZTIxYmJkMDIxMyIsInRhZyI6IiJ9'));
        // dd(Crypt::decryptString('eyJpdiI6IkNDTTdMcXhkYUZmSDdicXk1NkxPSnc9PSIsInZhbHVlIjoiclR2VGlpbFZSZW8xMUNnR0FPNXlBQT09IiwibWFjIjoiNmE0ZGZjNTNmY2U5OTZmY2JiY2U4YTYzNmZlNWUyM2M2ZTY3ZGQyNGI5NmFiY2RlYTg0YjdmZmJmNWQyMzkwOCJ9'));
        return view("admin.auth.signin");;
    }

    /*
    | Create
    -------------------- */
    public function create(Request $request) {
        $request->validate([
            'fullName' => 'required',
            'email' => 'required|unique:admin',
            'password' => 'required',
        ]);

        $user = Admin::create([
            'fullname' => $request['fullname'],
            'email' => $request['email'],
            'password' => Crypt::encryptString($request['password']),
            'role_id' => 1,
            'is_active' => 1
        ]);

        if ($user) {
            return back()->with('success', 'Successfully created!');
        } else {
            return back()->with('fail', 'Something went wrong');
        }
    }

    /*
    | Authenticate
    -------------------- */
    public function authentication(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = Admin::where('email', '=', $request->email)->first();
        if (!$user) {
            return back()->with('fail', 'User does not exist');
        }
        try {
            $decrypted_password = Crypt::decryptString($user->password);
            if ($decrypted_password === $request->password) {
                $request->session()->put('user', (object)[
                    "id" => $user->id,
                    "username" => $user->email,
                    "fullname" => $user->fullname,
                ]);
                return redirect('/admin/');
            }
            return back()->with('fail', 'Incorrect password');
        } catch (DecryptException $e) {
            return back()->with('fail', 'Incorrect password');
        }
    }

    /*
    | Signout
    -------------------- */
    public function logout() {
        if (session()->has('user')) {
            session()->pull('user');
            return redirect('/admin/signin');
        }
    }
}
