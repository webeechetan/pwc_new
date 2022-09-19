<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Startup;
use App\Models\StartupApproval;
use App\Models\StartupLogin;
use App\Models\Admin;
use App\Models\Roles;
use App\Models\pilotCompanies;
use App\Models\pilotCompaniesMember;
use File;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\startupExport;
use App\Models\Season;

class startupController extends Controller {
    
    // Admin
    public function index(Request $request) {
        $requestType = $request->query('request');
        if ($requestType === 'table') {
            $Eval = Startup::with([
                'startup_login',
                'screening' => function ($query) {
                    $query = $query->select(['id', 'startup_id', 'approved']);
                    return $query;
                },
                'meeting1' => function ($query) {
                    $query = $query->select(['id', 'startup_id', 'approved']);
                    return $query;
                },
                'meeting2' => function ($query) {
                    $query = $query->select(['id', 'startup_id', 'approved']);
                    return $query;
                },
                'finalcall' => function ($query) {
                    $query = $query->select(['id', 'startup_id', 'approved']);
                    return $query;
                },
            ]);

            if ($request->query('from') && $request->query('to')) {
                $from = date('Y-m-d', strtotime($request->query('from')));
                $to = date('Y-m-d', strtotime($request->query('to')));

                $Eval = $Eval->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            }

            if ($request->query('registered')) $Eval = $Eval->where('is_active', '1');
            if ($request->query('approved')) $Eval = $Eval->where([['is_active', '1'], ['request', '1']]);
            if ($request->query('rejected')) $Eval = $Eval->where([['is_active', '1'], ['request', '2']]);
            if ($request->query('pending')) $Eval = $Eval->where([['is_active', '1'], ['request', '0']]);

            $Eval = $Eval->get();
            return response()->json($Eval);
        } else {

            $stratup_registered = Startup::where('is_active', '1');
            $stratup_approved = Startup::where([['is_active', '1'], ['request', '1']]);
            $stratup_rejected = Startup::where([['is_active', '1'], ['request', '2']]);
            $stratup_pending = Startup::where([['is_active', '1'], ['request', '0']]);

            $today = date("Y-m-d");
            $stratup_recent = Startup::where('is_active', '1')->whereDate('created_at', $today)->select('company_name', 'id', 'state')->get();

            if (!empty($request->get('from')) && !empty($request->get('to'))) {

                $from = date('Y-m-d', strtotime($request->get('from')));
                $to = date('Y-m-d', strtotime($request->get('to')));

                $stratup_registered = $stratup_registered->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
                $stratup_approved = $stratup_approved->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
                $stratup_rejected = $stratup_rejected->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
                $stratup_pending = $stratup_pending->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            }

            $stratup_registered = $stratup_registered->count('id');
            $stratup_approved = $stratup_approved->count('id');
            $stratup_rejected = $stratup_rejected->count('id');
            $stratup_pending = $stratup_pending->count('id');

            $today = date("Y-m-d");
            $stratup_recent = Startup::where('is_active', '1')->whereDate('created_at', $today)->select('company_name', 'id', 'state')->get();
            return view("admin.startup.list", [
                "data_registered" => $stratup_registered,
                "data_approved" => $stratup_approved,
                "data_rejected" => $stratup_rejected,
                "data_pending" => $stratup_pending,
                "data_recent" => $stratup_recent
            ]);
        }
    }

    public function view() {
        $startup = Startup::where([['is_active', '1'], ['id', request()->id]])
            ->with([
                'startup_login',
                'screening' => function ($query) {
                    $query = $query->select(['id', 'pilot_companies_id', 'startup_id', 'approved'])
                        ->with([
                            'pilot_companies' => function ($query1) {
                                $query1 = $query1->select(['id', 'name']);
                                return $query1;
                            }
                        ]);

                    return $query;
                },
                'meeting1' => function ($query) {
                    $query = $query->select(['id', 'pilot_companies_id', 'startup_id', 'approved'])
                        ->with([
                            'pilot_companies' => function ($query1) {
                                $query1 = $query1->select(['id', 'name']);
                                return $query1;
                            }
                        ]);
                    return $query;
                },
                'meeting2' => function ($query) {
                    $query = $query->select(['id', 'pilot_companies_id', 'startup_id', 'approved'])
                        ->with([
                            'pilot_companies' => function ($query1) {
                                $query1 = $query1->select(['id', 'name']);
                                return $query1;
                            }
                        ]);
                    return $query;
                },
                'finalcall' => function ($query) {
                    $query = $query->select(['id', 'pilot_companies_id', 'startup_id', 'approved'])
                        ->with([
                            'pilot_companies' => function ($query1) {
                                $query1 = $query1->select(['id', 'name']);
                                return $query1;
                            }
                        ]);
                    return $query;
                }
            ])->get()->first();
        // echo json_encode($startup);
        // die();
        return view('admin.startup.view', ["data" => $startup]);
    }

    public function create(Request $request) {
        if ($request->method() === 'GET') return view("admin.startup.add");
        // Update Request
        $success = false;
        $message = "Something went wrong";
        $imageStatus = [];

        $request->validate([
            'image' => ['required', 'dimensions:ratio=3/3', 'mimes:jpg,jpeg,jfif,png'],
            'collateral.*' => ['mimes:jpg,jpeg,jfif,png,pdf,docs'],
            'company_name' => 'required',
            'description' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'zone' => 'required',
            'address' => 'required',
            'founded_on' => 'required',
            'company_type' => 'required',
            'industry' => 'required',
            'type_of_services' => 'required',
            'specialities' => 'required',
            'company_size' => 'required',
            'revenue' => 'required',
            'certified' => 'required',
            'title' => 'required',
            'website' => 'required',
            'facebook' => 'required',
            'twitter' => 'required',
            'linkedin' => 'required',
            'instagram' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $image = false;
        $collateral = [];
        $temp_collateral = [];
        if ($request->file()) {
            if ($image = $request->file('image')->store('uploads/startup/', 'public')) $imageStatus['image'] = [true, "successfully uploaded"];
            for ($i = 0; $i < count($request->file('collateral')); $i++) {
                do {
                    $extension = $request->file('collateral')[$i]->extension();
                    $uniqid = uniqid("Collateral") . '.' . $extension;
                    $eval = Startup::whereRaw("FIND_IN_SET('{$uniqid}', collateral)")->get();
                } while (count($eval) > 0);

                if ($temp_collateral[] = $request->file('collateral')[$i]->storeAs('uploads/startup/', $uniqid, 'public')) {
                    $collateral[] = $uniqid;
                    $imageStatus['collateral'][$i] = [true, "successfully uploaded"];
                }
            }
        }

        if ($image === false) {
            $message = "Unable to upload image";
            if ($image !== false) Storage::disk('public')->delete($image);
            if (count($temp_collateral) > 0) Storage::disk('public')->delete($temp_collateral);
        } else {
            $Startup = Startup::create([
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
                'certified' => $request['certified'],
                'title' => $request['title'],
                'website' => $request['website'],
                'facebook' => $request['facebook'],
                'twitter' => $request['twitter'],
                'linkedin' => $request['linkedin'],
                'instagram' => $request['instagram'],
                'name' => $request['name'],
                'designation' => $request['designation'],
                'email' => $request['email'],
                'phone' => $request['phone'],
            ]);

            if ($Startup) {
                $success = true;
                $message = "Successfully uploaded";
                Storage::disk('public')->move($image, "uploads/startup/Startup{$Evaluator->id}.jpg");
            } else {
                if ($image !== false) Storage::disk('public')->delete($image);
                if (count($temp_collateral) > 0) Storage::disk('public')->delete($temp_collateral);
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'Image' => $imageStatus]);
    }

    public function update(Request $request) {
        $Startup = Startup::findOrFail(request()->id);
        if (!$Startup) return redirect()->back();
        $Startup_login = StartupLogin::find($Startup->startup_id);
        if ($request->method() === 'GET') return view("admin.startup.edit", ["data" => $Startup, "data_login" => $Startup_login]);
        // Update Request
        $success = false;
        $message = "Something went wrong";
        $imageStatus = [];

        $request->validate([
            'image' => ['dimensions:ratio=3/3', 'mimes:jpg,jpeg,jfif,png'],
            // 'collateral.*' => ['mimes:jpg,jpeg,jfif,png,pdf,docs'],
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
            // 'company_size' => 'required',
            // 'revenue' => 'required',
            // 'certified' => 'required',
            // 'title' => 'required',
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
        if ($request->file()) {
            if ($request->file('image')) {
                if ($image = $request->file('image')->storeAs('uploads/startup/', 'Startup' . $Startup->id . '.jpg', 'public')) $imageStatus['image'] = [true, "successfully uploaded"];
            }
            if ($request->file('collateral')) {
                for ($i = 0; $i < count($request->file('collateral')); $i++) {
                    do {
                        $extension = $request->file('collateral')[$i]->extension();
                        $uniqid = uniqid("Collateral") . '.' . $extension;
                        $eval = Startup::whereRaw("FIND_IN_SET('{$uniqid}', collateral)")->get();
                    } while (count($eval) > 0);

                    if ($temp_collateral[] = $request->file('collateral')[$i]->storeAs('uploads/startup/', $uniqid, 'public')) {
                        $collateral[] = $uniqid;
                        $imageStatus['collateral'][$i] = [true, "successfully uploaded"];
                    }
                }
            }
        }
        $oldCollateral = explode(",", $Startup->collateral);
        $uploadedcollateral = $request['uploadedcollateral'];
        $reserveCollateral = [];
        if ($uploadedcollateral != null && $uploadedcollateral != '' && count($uploadedcollateral) > 0) {
            $reserveCollateral = array_intersect($oldCollateral, $uploadedcollateral);
            $deleteCollateral = array_diff($oldCollateral, $uploadedcollateral);
            foreach ($deleteCollateral as $DC) Storage::disk('public')->delete('uploads/evaluator/' . $DC);
        }
        $Startup->collateral = collect(array_merge($reserveCollateral, $collateral))->implode(',');
        $Startup->company_name = $request['company_name'];
        $Startup->description = $request['description'];
        $Startup->country = $request['country'];
        $Startup->state = $request['state'];
        $Startup->city = $request['city'];
        $Startup->pincode = $request['pincode'];
        $Startup->zone = $request['zone'];
        $Startup->address = $request['address'];
        $Startup->founded_on = $request['founded_on'];
        $Startup->company_type = $request['company_type'];
        $Startup->industry = $request['industry'];
        // $Startup -> type_of_services = collect($request['type_of_services'])->implode(',');
        $Startup->specialities = $request['specialities'];
        $Startup->company_size = $request['company_size'];
        $Startup->revenue = $request['revenue'];
        // $Startup -> certified = $request['certified'];
        // $Startup -> title = $request['title'];
        $Startup->website = $request['website'];
        $Startup->facebook = $request['facebook'];
        $Startup->twitter = $request['twitter'];
        $Startup->linkedin = $request['linkedin'];
        $Startup->instagram = $request['instagram'];
        // $Startup -> name = $request['name'];
        $Startup->designation = $request['designation'];
        // $Startup -> email = $request['email'];
        // $Startup -> phone = $request['phone'];
        $Startup->save();
        if ($Startup) {
            $startuplogin = StartupLogin::findOrFail($Startup->startup_id);
            if ($startuplogin) {
                // $startuplogin -> fullname = $request['name'];
                // $startuplogin -> email = $request['email'];
                // $startuplogin -> mobile = $request['phone'];
                $startuplogin::where('id', $Startup->startup_id)->update(["fullname" => $request['name'], "email" => $request['email'], "mobile" => $request['phone']]);
            }
            $success = true;
            $message = "Successfully uploaded";
        } else {
            if (count($temp_collateral) > 0) Storage::disk('public')->delete($temp_collateral);
        }
        return response()->json(['success' => $success, 'message' => $message, 'Image' => $imageStatus]);
    }

    public function certified(Request $request) {
        $success = false;
        $message = "Something went wrong";

        $Eval = Evaluator::findOrFail(request()->id);
        $certified = false;
        if ($Eval) {
            $certified = $request->query('certified');
            if ($certified) {
                $certified = in_array($certified, ['yes', 'no']) ? $certified : 'no';
                $Eval->certified = $certified;
                $Eval->save();
                if ($Eval) {
                    $success = true;
                    $message = "Successfully Updated";
                }
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'certified' => $certified]);
    }

    public function active(Request $request) {
        $success = false;
        $message = "Something went wrong";

        $Eval = Startup::findOrFail(request()->id);
        $active = false;
        if ($Eval) {
            $active = $request->query('active');
            $active = in_array((int)$active, [1, 0]) ? (int)$active : 0;

            $Eval->is_active = $active;
            $Eval->save();
            if ($Eval) {
                $success = true;
                $message = "Successfully Updated";
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'active' => $active,]);
    }

    public function approval(Request $request) {
        $success = false;
        $message = "Something went wrong";

        $Startup = Startup::findOrFail(request()->id);
        if ($Startup) {
            $approved = $request->query('approved');
            $approved = in_array((int)$approved, [1, 2]) ? (int)$approved : 0;
            if ($approved !== 0) {
                $Startup->request = $approved;
                $Startup->save();
                $success = true;
                $message = "Successfully updated";
            } else $message = "Either you can accept or reject!";
        }

        return response()->json(['success' => $success, 'message' => $message, 'approved' => $approved]);
    }

    public function giveApproval(Request $request) {
        $success = false;
        $message = "Something went wrong";
        $approved = 0;

        $pilot = pilotCompaniesMember::findOrFail(session('pilot')->id);
        if ($pilot) {
            $Startup = $startup = Startup::where([['is_active', '1'], ['request', '1']])->where('id', request()->id)->select('id', 'request');
            $Startup = $this->commonStartupFilter($Startup)->get()->first();

            if ($Startup) {
                $stage = $request->get('stage');
                $voteStatus = false;
                if ($stage === 'screening') {
                    if (count($Startup->screening) === 0) $voteStatus = true;
                    else $message = "You are not allowed to vote more than once!";
                } else if ($stage === 'meeting1') {
                    if (count($Startup->meeting1) === 0) $voteStatus = true; //Startup -> screening_count > 3 &&
                    elseif (count($Startup->meeting1) === 0) $message = "You are not allowed to vote as you have rejected the startup in screening";
                    // if($Startup -> screening_count <= 3) $message = "Startup is not eligible for first meeting";
                    else $message = "You are not allowed to vote more than once!";
                } else if ($stage === 'meeting2') {
                    if (count($Startup->meeting2) === 0 && $Startup->meeting1[0]->approved === 1) $voteStatus = true; //$Startup -> meeting1_count > 3 &&
                    elseif (count($Startup->meeting1) === 0 && $Startup->meeting1[0]->approved === 0) $message = "You are not allowed to vote as you have rejected the startup in 1st Meeting";
                    // if($Startup -> meeting1_count <= 3) $message = "Startup is not eligible for second meeting";
                    else $message = "You are not allowed to vote more than once!";
                } 
                // else if ($stage === 'finalcall') {
                //     if (count($Startup->finalcall) === 0 && $Startup->meeting2[0]->approved === 1) $voteStatus = true; //$Startup -> meeting2_count > 3 &&
                //     elseif (count($Startup->meeting1) === 0 && $Startup->meeting2[0]->approved === 0) $message = "You are not allowed to vote as you have rejected the startup in 2nd Meeting";
                //     // if($Startup -> meeting2_count <= 3) $message = "Startup is not eligible for final meeting discussion";
                //     else $message = "You are not allowed to vote more than once!";
                // }
                else if ($stage === 'finalcall') {
                    if (count($Startup->finalcall) === 0) $voteStatus = true; //$Startup -> meeting2_count > 3 &&
                    elseif (count($Startup->meeting1) === 0) $message = "You are not allowed to vote as you have rejected the startup in 2nd Meeting";
                    // if($Startup -> meeting2_count <= 3) $message = "Startup is not eligible for final meeting discussion";
                    else $message = "You are not allowed to vote more than once!";
                }
                // return count($startupapproval);
                if ($voteStatus && $voteStatus === true) {
                    $approved = $request->get('approved');
                    $approved = in_array((int)$approved, [1, 2]) ? (int)$approved : 2;
                    $createstartupapproval = StartupApproval::create([
                        'pilot_companies_id' => session('pilot')->company_id,
                        'pilot_companies_member_id' => session('pilot')->id,
                        'startup_id' => $Startup->id,
                        'approved' => $approved,
                        'stage' => $stage
                    ]);
                    if ($createstartupapproval) {
                        $success = true;
                        $message = "Request Updated";
                    }
                }
            } else $message = "Startup does not exist!";
        }
        return response()->json(['success' => $success, 'message' => $message, 'approved' => $approved]);
    }

    public function delete() {
        $success = false;
        $message = "Something went wrong";

        $caseStudies = Startup::findOrFail(request()->id);
        if ($caseStudies) {
            $caseStudies->delete();
            if ($caseStudies) {
                $success = true;
                $message = "Successfully deleted";
                Storage::disk('public')->delete('uploads/evaluator/OverviewImage' . request()->id . '.jpg');
                Storage::disk('public')->delete('uploads/evaluator/BannerImage' . request()->id . '.jpg');
            }
        }

        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function downloadExcel() {
        $id = request()->id ? request()->id : 0;
        return Excel::download(new startupExport($id, true), 'startup.csv');
    }

    public function downloadSelected(Request $request) {
        $id = $request['startup'];
        $id = explode(',', $id);
        if ($id != null && $id != '') {
            return Excel::download(new startupExport($id, false), 'startup.csv');
        } else {
            return redirect()->back();
        }
    }


    //Website
    public function startupList(Request $request) {
        $data = $this->startuplistFilter($request);
        return view('startup.list', $data);
    }

  

    public function startupView($id) {
        $startup = Startup::where([['is_active', '1'], ['id', $id], ['request', '1']])->with('startup_login')->first();
        // dd($startup->startup_login->fullname);
        // print_r(json_encode($startup));
        // return;
        return view('startup.view', ["data" => $startup]);
    }

    private function commonStartupFilter($startup) {
        return $startup->with([
            "screening" => function ($query) {
                $query = $query->where('pilot_companies_id', session('pilot')->company_id)
                    ->select(['id', 'pilot_companies_id', 'startup_id', 'approved']);
                return $query;
            },
            "meeting1" => function ($query) {
                $query = $query->where('pilot_companies_id', session('pilot')->company_id)
                    ->select(['id', 'pilot_companies_id', 'startup_id', 'approved']);
                return $query;
            },
            "meeting2" => function ($query) {
                $query = $query->where('pilot_companies_id', session('pilot')->company_id)
                    ->select(['id', 'pilot_companies_id', 'startup_id', 'approved']);
                return $query;
            },
            "finalcall" => function ($query) {
                $query = $query->where('pilot_companies_id', session('pilot')->company_id)
                    ->select(['id', 'pilot_companies_id', 'startup_id', 'approved']);
                return $query;
            }
        ])
            ->withCount([
                'screening' => function ($query) {
                    $query->where('approved', 1);
                },
                'meeting1' => function ($query) {
                    $query->where('approved', 1);
                },
                'meeting2' => function ($query) {
                    $query->where('approved', 1);
                },
                'finalcall' => function ($query) {
                    $query->where('approved', 1);
                }
            ]);
    }

    public function searchStartup(Request $request) {
        // DB::enableQueryLog();s
        $startup = $startup = Startup::where([['is_active', '1'], ['request', '1']])
            ->select('company_name', 'id', 'startup_id', 'industry', 'address', 'website', 'twitter', 'instagram', 'linkedin', 'facebook', 'request')
            ->with('startup_login');
        $startup = $this->commonStartupFilter($startup);
        // dd(DB::getQueryLog()); 
        // print_r(json_encode($startup));
        // die();
        if ($request['zone']) {

            $zone = $request['zone'];
            if (!empty($zone) && $zone != '') {
                $startup =  $startup->where(function ($query1) use ($zone) {
                    foreach ($zone as $z) {
                        $query1 = $query1->orWhere('zone', $z);
                    }
                    return $query1;
                });
            }
        }
        if ($request['country']) {
            $country = $request['country'];
            if (!empty($country) && $country != '') {
                $startup =  $startup->where(function ($query1) use ($country) {
                    foreach ($country as $c) {
                        $query1 = $query1->orWhere('country', $c);
                    }
                    return $query1;
                });
            }
        }
        if ($request['state']) {
            $state = $request['state'];
            if (!empty($state) && $state != '') {
                $startup =  $startup->where(function ($query1) use ($state) {
                    foreach ($state as $s) {
                        $query1 = $query1->orWhere('state', $s);
                    }
                    return $query1;
                });
            }
        }
        if ($request['city']) {
            $city = $request['city'];
            if (!empty($city) && $city != '') {
                $startup =  $startup->where(function ($query1) use ($city) {
                    foreach ($city as $c) {
                        $query1 = $query1->orWhere('city', $c);
                    }
                    return $query1;
                });
            }
        }

        if ($request->query('from') && $request->query('to')) {
            $from = date('Y-m-d', strtotime($request->query('from')));
            $to = date('Y-m-d', strtotime($request->query('to')));

            $startup = $startup->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
        }

        /* |Screening| */
        if ($request->query('s_pending')) {
            $startup = $startup
                ->whereHas(
                    'screening',
                    function ($query) {
                        return $query->where([['pilot_companies_id', '=', session('pilot')->company_id]]);
                    },
                    '=',
                    0
                );
        }
        if ($request->query('s_interested')) {
            $startup = $startup
                ->whereHas(

                    'screening',
                    function ($query) {
                        return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 1]]);
                    }
                );
        }
        if ($request->query('s_notinterested')) {
            // die();
            $startup = $startup
                ->whereHas(
                    'screening',
                    function ($query) {
                        return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 2]]);
                    }
                );
        }

        /* |Meeting 1| */
        if ($request->query('m1_pending')) {
            $startup = $startup
                ->whereHas(
                    'meeting1',
                    function ($query) {
                        return $query->where('pilot_companies_id', '=', session('pilot')->company_id);
                    },
                    '=',
                    0
                )
                ->whereHas(
                    'screening',
                    function ($query) {
                        return $query->where([['pilot_companies_id', '=', session('pilot')->company_id], ['approved', '=', 1]]);
                    },
                    '=',
                    1
                )
                ->withCount('screening');
            // ->having('screening_count', '>', 3);
        }
        if ($request->query('m1_interested')) {
            $startup = $startup
                ->whereHas(
                    'meeting1',
                    function ($query) {
                        return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 1]]);
                    }
                );
        }
        if ($request->query('m1_notinterested')) {
            $startup = $startup
                ->whereHas(
                    'meeting1',
                    function ($query) {
                        return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 2]]);
                    }
                );
        }

        /* |Meeting 2| */
        if ($request->query('m2_pending')) {
            $startup = $startup
                ->whereHas(
                    'meeting2',
                    function ($query) {
                        return $query->where('pilot_companies_id', '=', session('pilot')->company_id);
                    },
                    '=',
                    0
                )
                ->whereHas(
                    'meeting1',
                    function ($query) {
                        return $query->where([['pilot_companies_id', '=', session('pilot')->company_id], ['approved', '=', 1]]);
                    },
                    '=',
                    1
                )
                ->withCount('meeting1');
            // ->having('meeting1_count', '>', 3);
        }
        if ($request->query('m2_interested')) {
            $startup = $startup
                ->whereHas(
                    'meeting2',
                    function ($query) {
                        return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 1]]);
                    }
                );
        }
        if ($request->query('m2_notinterested')) {
            $startup = $startup
                ->whereHas(
                    'meeting2',
                    function ($query) {
                        return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 2]]);
                    }
                );
        }

        /* |Final Call 2| */
        if ($request->query('final_pending')) {
            $startup = $startup
                ->whereHas(
                    'finalcall',
                    function ($query) {
                        return $query->where('pilot_companies_id', '=', session('pilot')->company_id);
                    },
                    '=',
                    0
                )
                ->whereHas(
                    'meeting2',
                    function ($query) {
                        return $query->where([['pilot_companies_id', '=', session('pilot')->company_id], ['approved', '=', 1]]);
                    },
                    '=',
                    1
                )
                ->withCount('meeting2');
            // ->having('meeting2_count', '>', 3);
        }
        if ($request->query('final_interested')) {
            $startup = $startup
                ->whereHas(
                    'finalcall',
                    function ($query) {
                        return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 1]]);
                    }
                );
        }
        if ($request->query('final_notinterested')) {
            $startup = $startup
                ->whereHas(
                    'finalcall',
                    function ($query) {
                        return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 2]]);
                    }
                );
        }

        if ($request->query('registered')) $startup = $startup->where('is_active', '1');
        if ($request->query('approved')) $startup = $startup->where([['is_active', '1'], ['request', '1']]);
        if ($request->query('rejected')) $startup = $startup->where([['is_active', '1'], ['request', '2']]);
        if ($request->query('pending')) $startup = $startup->where([['is_active', '1'], ['request', '0']]);
        $startup_id = $startup->pluck('id');
        $startup = $startup->orderBy("id", "desc")->get();

        $startupfilter = $this->startuplistFilter($request);
        return response()->json(['success' => true, 'message' => "success", "data" => $startup, "excelId" => $startup_id, "filter" => $startupfilter]);
    }

    public function startuplistFilter($request) {
        // dd($request);
        /* |Screening| */
        $screening_pending = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'screening',
                function ($query) {
                    return $query->where([['pilot_companies_id', '=', session('pilot')->company_id]]);
                },
                '=',
                0
            );

        $screening_interest = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'screening',
                function ($query) {
                    return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 1]]);
                }
            );

        $screening_notinterest = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'screening',
                function ($query) {
                    return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 2]]);
                }
            );

        /* |Meeting 1| */
        $meeting1_pending = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'meeting1',
                function ($query) {
                    return $query->where('pilot_companies_id', '=', session('pilot')->company_id);
                },
                '=',
                0
            )
            ->whereHas(
                'screening',
                function ($query) {
                    return $query->where([['pilot_companies_id', '=', session('pilot')->company_id], ['approved', '=', 1]]);
                },
                '=',
                1
            );
        // ->withCount(['screening' => function($query) {
        //     $query -> where('approved', 1);
        // }]);
        // ->having('screening_count', '>', 3);

        $meeting1_interest = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'meeting1',
                function ($query) {
                    return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 1]]);
                }
            );

        $meeting1_notinterest = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'meeting1',
                function ($query) {
                    return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 2]]);
                }
            );

        /* |Meeting 2| */
        $meeting2_pending = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'meeting2',
                function ($query) {
                    return $query->where('pilot_companies_id', '=', session('pilot')->company_id);
                },
                '=',
                0
            )
            ->whereHas(
                'meeting1',
                function ($query) {
                    return $query->where([['pilot_companies_id', '=', session('pilot')->company_id], ['approved', '=', 1]]);
                },
                '=',
                1
            );
        // ->withCount(['meeting1' => function($query) {
        //     $query -> where('approved', 1);
        // }]);
        // ->having('meeting1_count', '>', 3);

        $meeting2_interest = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'meeting2',
                function ($query) {
                    return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 1]]);
                }
            );

        $meeting2_notinterest = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'meeting2',
                function ($query) {
                    return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 2]]);
                }
            );

        /* |Final Call| */
        $finalcall_pending = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'finalcall',
                function ($query) {
                    return $query->where('pilot_companies_id', '=', session('pilot')->company_id);
                },
                '=',
                0
            )
            ->whereHas(
                'meeting2',
                function ($query) {
                    return $query->where([['pilot_companies_id', '=', session('pilot')->company_id], ['approved', '=', 1]]);
                },
                '=',
                1
            );
        // ->withCount(['meeting2' => function($query) {
        //     $query -> where('approved', 1);
        // }]);
        // ->having('meeting2_count', '>', 3);

        $finalcall_interest = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'finalcall',
                function ($query) {
                    return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 1]]);
                }
            );

        $finalcall_notinterest = Startup::where([['is_active', '1'], ['request', '1']])->select('id', 'company_name')
            ->whereHas(
                'finalcall',
                function ($query) {
                    return $query->where([['pilot_companies_id', session('pilot')->company_id], ['approved', 2]]);
                }
            );

        $today = date("Y-m-d");
        $stratup_recent = Startup::where([['is_active', '1'], ['request', '1']])->whereDate('created_at', $today)->select('company_name', 'id', 'state')->get();

        if (!empty($request->get('from')) && !empty($request->get('to'))) {

            $from = date('Y-m-d', strtotime($request->get('from')));
            $to = date('Y-m-d', strtotime($request->get('to')));

            $screening_pending = $screening_pending->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            $screening_interest = $screening_interest->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            $screening_notinterest = $screening_notinterest->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));


            $meeting1_pending = $meeting1_pending->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            $meeting1_interest = $meeting1_interest->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            $meeting1_notinterest = $meeting1_notinterest->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));


            $meeting2_pending = $meeting2_pending->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            $meeting2_interest = $meeting2_interest->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            $meeting2_notinterest = $meeting2_notinterest->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));


            $finalcall_pending = $finalcall_pending->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            $finalcall_interest = $finalcall_interest->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
            $finalcall_notinterest = $finalcall_notinterest->whereBetween(DB::raw('DATE(created_at)'), array($from, $to));
        }

        $screening_pending = $screening_pending->count('id');
        $screening_interest = $screening_interest->count('id');
        $screening_notinterest = $screening_notinterest->count('id');

        $meeting1_pending = $meeting1_pending->count('id');
        $meeting1_interest = $meeting1_interest->count('id');
        $meeting1_notinterest = $meeting1_notinterest->count('id');

        $meeting2_pending = $meeting2_pending->count('id');
        $meeting2_interest = $meeting2_interest->count('id');
        $meeting2_notinterest = $meeting2_notinterest->count('id');

        $finalcall_pending = $finalcall_pending->count('id');
        $finalcall_interest = $finalcall_interest->count('id');
        $finalcall_notinterest = $finalcall_notinterest->count('id');

        return [
            "s_pending" => $screening_pending,
            "s_interested" => $screening_interest,
            "s_notinterested" => $screening_notinterest,
            "m1_pending" => $meeting1_pending,
            "m1_interested" => $meeting1_interest,
            "m1_notinterested" => $meeting1_notinterest,
            "m2_pending" => $meeting2_pending,
            "m2_interested" => $meeting2_interest,
            "m2_notinterested" => $meeting2_notinterest,
            "final_pending" => $finalcall_pending,
            "final_interested" => $finalcall_interest,
            "final_notinterested" => $finalcall_notinterest,
            "data_recent" => $stratup_recent,
        ];
    }
}
