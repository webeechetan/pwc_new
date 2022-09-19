<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pilotCompaniesMember;
use App\Models\pilotCompanies;
use App\Models\StartupApproval;
use App\Models\Startup;

class pilotAuthController extends startupAuthController
{
    public function index() {
        return view("auth.pilot_companies");
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
   
        $pilot = pilotCompaniesMember::where([['email', '=', $request -> email], ['password', '=', $request -> password]]) ->with(['pilot_companies'=> function ($query) {
            return $query -> select('id', 'name');
        }]) -> first();

        // dd($pilot);
        if(!$pilot || $pilot == '' || empty($pilot)) {
            $message = 'User does not exist';
        } else
        {
            if(session() -> has('startup')) {
                session() -> pull('startup');
            }
            $request -> session() -> put('pilot', (object)[
                "id" => $pilot -> id,
                "name" => $pilot -> name,
                "email" => $pilot -> email,
                "company" => $pilot -> pilot_companies -> name,
                "company_id" => $pilot -> pilot_companies -> id,
            ]);
            
            $success = true;
            $message = "Successfully logged In";
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }
    
    /*
    | Signout
    -------------------- */
    public function signout() {  
        if(session() -> has('pilot')) {
            session() -> pull('pilot');   
        }
        return redirect(env('APP_URL').'/');
    }
    
    /*
    | Update New Password
    -------------------- */
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
            $pilot = pilotCompaniesMember::findOrFail(session('pilot')->id);
            if(!$pilot || $pilot == '' || empty($pilot)) {
                $message = 'User does not exist';
            } else
            {
                try {
                    $decrypted_password = $pilot -> password;
                    if($decrypted_password === $request -> old_password) {
                        $pilot -> password = $request['new_password'];
                        $pilot -> save();
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

    public function viewPilots(Request $request){
        $requestType= $request->query('request');

        // $t = pilotCompanies::all();

        // foreach ($t as $d){
        //     echo $d->name;
        //     echo "<br>";
        //     foreach ($d->approvedCompany as $member){
        //         echo $member->stage."<br>";
        //     }
        //     echo "<hr>";
        // }
        // die;

        if( $requestType === 'table') {
           return response()->json(pilotCompanies::with('members','approvedCompany')->get());
        }else{
            return view('admin.pilot.list',["pilots"=>pilotCompanies::all()]);
        }
    }

    public function viewPilot(Request $request){
        
        $data = pilotCompanies::where('id',$request->id)->with('members','approvedCompany')->first();
        $approvedData = []; 
        $temp = "";
        $tempArray = [];
        
        
        $screening = StartupApproval::where('pilot_companies_id',$data->id)->where('stage','screening')->orderBy('startup_id','ASC')->get();
        $meeting1 = StartupApproval::where('pilot_companies_id',$data->id)->where('stage','meeting1')->orderBy('startup_id','ASC')->get();
        $meeting2 = StartupApproval::where('pilot_companies_id',$data->id)->where('stage','meeting2')->orderBy('startup_id','ASC')->get();


        return view('admin.pilot.view',compact('data','screening','meeting1','meeting2'));
    }
}
