<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\StartupLogin;
use App\Models\Startup;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;
use App\Scopes\SeasonScope;

class startupAuthController extends Controller
{

    public function index() {
        return view("auth.index");
    }

    /*
    | Create
    -------------------- */
    public function create(Request $request)
    {
        $success = false;
        $message = "Something went wrong!";

        $request -> validate([
            'fullname' => 'required',
            'email' => 'required|unique:startup_login',
            'mobile' => 'required|unique:startup_login|min:10|max:10',
            'password' => 'required|min:6',
        ]);
        $cred = [
            'fullname' => $request['fullname'],
            'email' => $request['email'],
            'mobile' => $request['mobile'],
            'password' => Crypt::encryptString($request['password']),
            'is_active' => 1,
        ];
        // dd($cred);
        $startup = StartupLogin::create($cred);

        if($startup) {
            $success = true;
            $message = "Successfully Created";
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }

    /*
    | Authenticate
    -------------------- */
    public function authentication(Request $request)
    {
        $success = false;
        $message = "Something went wrong!";

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $startup = StartupLogin::where('email', '=', $request -> email) -> first();

        if(!$startup || $startup == '' || empty($startup)) {
            $message = 'User does not exist';
        } else
        {
            try {
                $decrypted_password = Crypt::decryptString($startup -> password);
                if($decrypted_password === $request -> password) {
                    if(session() -> has('pilot')) {
                        session() -> pull('pilot');
                    }
                    $request -> session() -> put('startup', (object)[
                        "id" => $startup -> id,
                        "username" => $startup -> email,
                        "fullname" => $startup -> fullname,
                        "mobile" => $startup -> mobile,
                    ]);
                    $success = true;
                    $message = "Successfully logged In";
                } else $message = "Incorrect password";
            } catch (DecryptException $e) {
                $message = "Incorrect password";
            }
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }
    
    /*
    | Signout
    -------------------- */
    public function signout() {  
        if(session() -> has('startup')) {
            session() -> pull('startup');
            return redirect(env('APP_URL').'/');
        }
    }

    public function myaccount() {
        $startup = Startup::where('startup_id', session('startup')->id)
        -> withCount([
            'screening' => function($query) {
                $query -> where('approved', 1);
            }, 
            'meeting1' => function($query) {
                $query -> where('approved', 1);
            }, 
            'meeting2' => function($query) {
                $query -> where('approved', 1);
            },
            'finalcall' => function($query) {
                $query -> where('approved', 1);
            }
        ])
        ->with([
            'screening' => function($query){
                $query = $query ->  select(['id', 'pilot_companies_id', 'startup_id', 'approved']) 
                -> with([
                    'pilot_companies' => function($query1){
                        $query1 = $query1 ->  select(['id', 'name']);
                        return $query1;
                    }
                ]);
                return $query;
            },
            'meeting1' => function($query){
                $query = $query ->  select(['id', 'pilot_companies_id', 'startup_id', 'approved']) 
                -> with([
                    'pilot_companies' => function($query1){
                        $query1 = $query1 ->  select(['id', 'name']);
                        return $query1;
                    }
                ]);
                return $query;
            },
            'meeting2' => function($query){
                $query = $query ->  select(['id', 'pilot_companies_id', 'startup_id', 'approved']) 
                -> with([
                    'pilot_companies' => function($query1){
                        $query1 = $query1 ->  select(['id', 'name']);
                        return $query1;
                    }
                ]);
                return $query;
            },
            'finalcall' => function($query){
                $query = $query ->  select(['id', 'pilot_companies_id', 'startup_id', 'approved']) 
                -> with([
                    'pilot_companies' => function($query1){
                        $query1 = $query1 ->  select(['id', 'name']);
                        return $query1;
                    }
                ]);
                return $query;
            }
        ])
        ->first();
        // print_r(json_encode($startup));
        // die();
        $startup_poc = StartupLogin::findOrFail(session('startup')->id);
        // dd($startup);
        return view('auth.account', ["data" => $startup, "data_poc" => $startup_poc]);
    }

    public function update(Request $request) {
        $success = false;
        $message = "Something went wrong";
        $imageStatus = [];
        
        $startupCheck = Startup::where('startup_id', session('startup')->id)->first();
        if(empty($startupCheck))
        {    
            $request->validate([
                'image' => ['required', 'mimes:jpg,jpeg,jfif,png'],
                'collateral.*' => ['mimes:jpg,jpeg,jfif,png,pdf,docs'],
                'company_name' => 'required',
                'description' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'pincode' => 'required',
                'zone' => 'required',
                'address' => 'required',
                // 'founded_on' => 'required',
                'company_type' => 'required',
                // 'industry' => 'required',
                // 'type_of_services' => 'required',
                // 'specialities' => 'required',
                'company_size' => 'required',
                // 'revenue' => 'required',
                // 'website' => 'required',
                // 'facebook' => 'required',
                // 'twitter' => 'required',
                // 'linkedin' => 'required',
                // 'instagram' => 'required',
                'name' => 'required',
                'designation' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);

            $image = false;
            $collateral = [];
            $temp_collateral = [];
            if($request->file()) {
                if($request->file('image'))
                {
                    if($image = $request->file('image')->store('uploads/startup/', 'public')) $imageStatus['image'] = [true, "successfully uploaded"];
                }
                $count_file = $request->file('collateral') ?? [];
                for($i = 0; $i < count($count_file); $i++) {
                    do{
                        $extension = $request->file('collateral')[$i]->extension();
                        $uniqid = uniqid("Collateral").'.'.$extension;
                        $eval = Startup::whereRaw("FIND_IN_SET('{$uniqid}', collateral)")->get();
                    } while(count($eval) > 0);

                    if($temp_collateral[] = $request->file('collateral')[$i]->storeAs('uploads/startup/', $uniqid, 'public')) {
                        $collateral[] = $uniqid;
                        $imageStatus['collateral'][$i] = [true, "successfully uploaded"];
                    }
                }
            }
            
            if($image === false)
            {
                $message = "Unable to upload image";
                if($image !== false)Storage::disk('public')->delete($image);
                if(count($temp_collateral) > 0)Storage::disk('public')->delete($temp_collateral);
            } else
            {
                $Startup = Startup::create([
                    'startup_id' => session('startup')->id,
                    'collateral' => collect($collateral)->implode(','),
                    'company_name' => $request['company_name'],
                    'description' => $request['description'],
                    'country' => $request['country'],
                    'state' => $request['state'],
                    'city' => $request['city'],
                    'pincode' => $request['pincode'],
                    'zone' => $request['zone'],
                    'address' => $request['address'],
                    'founded_on' => $request['founded_on'],
                    'company_type' => $request['company_type'],
                    'industry' => $request['industry'],
                    'type_of_services' => collect($request['type_of_services'])->implode(','),
                    'specialities' => $request['specialities'],
                    'company_size' => $request['company_size'],
                    'revenue' => $request['revenue'],
                    'website' => $request['website'],
                    'facebook' => $request['facebook'],
                    'twitter' => $request['twitter'],
                    'linkedin' => $request['linkedin'],
                    'instagram' => $request['instagram'],
                    'designation' => $request['designation']
                ]);
                
                if($Startup)
                {
                    $startuplogin = StartupLogin::findOrFail(session('startup')->id);
                    if($startuplogin)
                    {
                        $startuplogin -> fullname = $request['name'];
                        $startuplogin -> email = $request['email'];
                        $startuplogin -> mobile = $request['phone'];
                        $startuplogin -> save();
                    }
                    $success = true;
                    $message = "Successfully uploaded";
                    Storage::disk('public')->move($image, "uploads/startup/Startup{$Startup->id}.jpg");
                } else
                {
                    if($image !== false)Storage::disk('public')->delete($image);
                    if(count($temp_collateral) > 0)Storage::disk('public')->delete($temp_collateral);
                }
            }
        } else
        {
            $request->validate([
                'image' => ['mimes:jpg,jpeg,jfif,png'],
                'collateral.*' => ['mimes:jpg,jpeg,jfif,png,pdf,docs'],
                'company_name' => 'required',
                'description' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'pincode' => 'required',
                'zone' => 'required',
                'address' => 'required',
                // 'founded_on' => 'required',
                'company_type' => 'required',
                // 'industry' => 'required',
                // 'type_of_services' => 'required',
                // 'specialities' => 'required',
                'company_size' => 'required',
                // 'revenue' => 'required',
                // 'website' => 'required',
                // 'facebook' => 'required',
                // 'twitter' => 'required',
                // 'linkedin' => 'required',
                // 'instagram' => 'required',
                'name' => 'required',
                'designation' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);
            $Startup = Startup::where('startup_id', session('startup') -> id)->first();
            if(empty($Startup))
            {
                $message = "Startup Not Found";
            } else
            {
                $image = false;
                $collateral = [];
                $temp_collateral = [];

                if($request->file()) {
                    if($request->file('image')){
                        if($image = $request->file('image')->storeAs('uploads/startup/', 'Startup'.$Startup->id.'.jpg', 'public')) $imageStatus['image'] = [true, "successfully uploaded"];
                    }
                    if($request->file('collateral'))
                    {
                        for($i = 0; $i < count($request->file('collateral')); $i++) {
                            do{
                                $extension = $request->file('collateral')[$i]->extension();
                                $uniqid = uniqid("Collateral").'.'.$extension;
                                $eval = Startup::whereRaw("FIND_IN_SET('{$uniqid}', collateral)")->get();
                            } while(count($eval) > 0);
        
                            if($temp_collateral[] = $request->file('collateral')[$i]->storeAs('uploads/startup/', $uniqid, 'public')) {
                                $collateral[] = $uniqid;
                                $imageStatus['collateral'][$i] = [true, "successfully uploaded"];
                            }
                        }
                    }
                }
                $oldCollateral = explode(",", $Startup -> collateral);
                $uploadedcollateral = $request['uploadedcollateral'];
                $reserveCollateral = [];
                if($uploadedcollateral != null && $uploadedcollateral != '' && count($uploadedcollateral) > 0) {
                    $reserveCollateral = array_intersect($oldCollateral, $uploadedcollateral);
                    $deleteCollateral = array_diff($oldCollateral, $uploadedcollateral);
                    foreach($deleteCollateral as $DC) Storage::disk('public')->delete('uploads/evaluator/'.$DC);
                }
                $Startup -> collateral = collect(array_merge($reserveCollateral, $collateral))->implode(',');
                $Startup -> company_name = $request['company_name'];
                $Startup -> description = $request['description'];
                $Startup -> country = $request['country'];
                $Startup -> state = $request['state'];
                $Startup -> city = $request['city'];
                $Startup -> pincode = $request['pincode'];
                $Startup -> zone = $request['zone'];
                $Startup -> address = $request['address'];
                $Startup -> founded_on = $request['founded_on'];
                $Startup -> company_type = $request['company_type'];
                $Startup -> industry = $request['industry'];
                $Startup -> type_of_services = collect($request['type_of_services'])->implode(',');
                $Startup -> specialities = $request['specialities'];
                $Startup -> company_size = $request['company_size'];
                $Startup -> revenue = $request['revenue'];
                $Startup -> website = $request['website'];
                $Startup -> facebook = $request['facebook'];
                $Startup -> twitter = $request['twitter'];
                $Startup -> linkedin = $request['linkedin'];
                $Startup -> instagram = $request['instagram'];
                // $Startup -> name = $request['name'];
                $Startup -> designation = $request['designation'];
                // $Startup -> email = $request['email'];
                // $Startup -> phone = $request['phone'];
                $Startup -> save();
                if($Startup)
                {
                    $startuplogin = StartupLogin::findOrFail(session('startup')->id);
                    if($startuplogin)
                    {
                        $startuplogin -> fullname = $request['name'];
                        $startuplogin -> email = $request['email'];
                        $startuplogin -> mobile = $request['phone'];
                        $startuplogin -> save();
                    }
                    $success = true;
                    $message = "Successfully uploaded";
                } else
                {
                    if(count($temp_collateral) > 0)Storage::disk('public')->delete($temp_collateral);
                }
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'Image' => $imageStatus]);
    }
    
    public function changepassword() {
        return view('auth.changepassword');
    }
    
    public function updatepassword(Request $request) {
        $success = false;
        $message = "Something went wrong!";

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'
        ]);
        if($request -> new_password !== $request -> confirm_password)
        {
            $message = "New password and Confirm password should be same!";
        }
        else
        {
            $startup = StartupLogin::findOrFail(session('startup')->id);
            if(!$startup || $startup == '' || empty($startup)) {
                $message = 'User does not exist';
            } else
            {
                try {
                    $decrypted_password = Crypt::decryptString($startup -> password);
                    if($decrypted_password === $request -> old_password) {
                        $startup -> password = Crypt::encryptString($request['new_password']);
                        $startup -> save();
                        $success = true;
                        $message = "Password updated successfully!";
                    } else $message = "Old Password is Incorrect!";
                } catch (DecryptException $e) {
                    $message = "Incorrect password";
                }
            }
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }
}
