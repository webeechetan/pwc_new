<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\eventRegister;
use File;
use DateTime;
use Illuminate\Support\Facades\Storage;
use App\Models\pilotCompaniesMember;
use App\Models\StartupLogin;
use App\Models\Startup;
use App\Events\EventMail;
// use Mail;
use Illuminate\Support\Facades\DB;
use Spatie\GoogleCalendar\Event as Events;
use Carbon\Carbon;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Mail;

class eventController extends Controller
{
    public function index(Request $request) {
        $requestType= $request->query('request');
        if( $requestType === 'table') {
            $Event = Event::all();
            return response()->json($Event);
        } else return view("admin.event.list");
    }

    public function create(Request $request) {
        if( $request->method() === 'GET') 
        {
            $responseData = $this -> getStartupandPilot();
            // echo json_encode($startup);
            // die();
            return view("admin.event.add", $responseData);
        }
        // Update Request
        $success = false;
        $message = "Something went wrong";
        $imageStatus = [];

        $request->validate([
            // 'event_image' => ['dimensions:width=370,height=238', 'mimes:jpg,jpeg,jfif,png,gif'],
            // 'event_banner_image' => ['dimensions:width=1920,height=300', 'mimes:jpg,jpeg,jfif,png,gif'],
            'title' => 'required',
            'category' => 'required',
            'type' => 'required',
            'price' => 'required',
            'event_for' => 'required',
            'event_from' => 'required',
            'event_start' => 'required',
            'event_end' => 'required',
            'short_description' => 'required',
            'description' => 'required'
        ]); 
        $extra_email_array = [];
        $extra_email = $request['extra_email'];
        $extra_email = explode(',', $extra_email);
        foreach($extra_email as $email) {
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                $extra_email_array[] = $email;
            }
        }

        $event_image = false;
        $event_banner_image = false;
        $collateral = [];
        $temp_collateral = [];
        
        
        
        if($request->file()) {
            if($request->file('event_image'))
            {
                if($event_image = $request->file('event_image')->store('uploads/event/', 'public'))$imageStatus['event_image'] = [true, "successfully uploaded"];
            }
            if($request->file('event_banner_image'))
            {
                if($event_banner_image = $request->file('event_banner_image')->store('uploads/event/', 'public'))$imageStatus['event_banner_image'] = [true, "successfully uploaded"];
            }
            $count_file = $request->file('collateral') ?? [];
            for($i = 0; $i < count($count_file); $i++) {
                do{
                    $extension = $request->file('collateral')[$i]->extension();
                    $uniqid = uniqid("Collateral").'.'.$extension;
                    $eval = Event::whereRaw("FIND_IN_SET('{$uniqid}', collateral)")->get();
                } while(count($eval) > 0);

                if($temp_collateral[] = $request->file('collateral')[$i]->storeAs('uploads/event/', $uniqid, 'public')) {
                    $collateral[] = $uniqid;
                    $imageStatus['collateral'][$i] = [true, "successfully uploaded"];
                }
            }
        }
        // if($event_image === false)
        // {
        //     $message = "Unable to upload image";
        //     if($event_image !== false)Storage::disk('public')->delete($event_image);
        //     if($event_banner_image !== false)Storage::disk('public')->delete($event_banner_image);
        //     if(count($temp_collateral) > 0)Storage::disk('public')->delete($temp_collateral);
        // } else
        if(1)
        {

            if($request['event_to'] === '' && $request['event_to'] === null) $event_to = $request['event_from'];
            else if($request['event_to'] < $request['event_from']) $event_to = $request['event_from'];
            else $event_to = $request['event_to'];

            $duration = $this->getDuration($request['event_from'], $event_to);
            
            // Email and Event For
            $event_for = $request['event_for'];
            $pilot_companies_id = [];
            $pilot_companies_email = [];
            $startup_id = [];
            $startup_email = [];
            if($event_for === 'startup' || $event_for === 'both')
            {
                if($request['startup_id'] && count($request['startup_id']) > 0)
                {
                    $startup_id_temp = StartupLogin::where('is_active', '1')
                    ->whereIn('id', $request['startup_id']);
                    
                } else $startup_id_temp = StartupLogin::where('is_active', '2');

                $startup_id_temp = $startup_id_temp->select('id', 'email');

                $startup_id = $startup_id_temp -> pluck('id')->toArray();
                $startup_email = $startup_id_temp -> pluck('email')->toArray();
            }

            if($event_for === 'pilot' || $event_for === 'both')
            {
                if($request['pilot_companies_id'] && count($request['pilot_companies_id']) > 0)
                {
                    $pilot_companies_id_temp = pilotCompaniesMember::where('is_active', '1')
                    ->whereIn('id', $request['pilot_companies_id']);
                    
                } else $pilot_companies_id_temp = pilotCompaniesMember::where('is_active', '2');

                $pilot_companies_id_temp = $pilot_companies_id_temp->select('id', 'email');
                
                $pilot_companies_id = $pilot_companies_id_temp -> pluck('id')->toArray();
                $pilot_companies_email = $pilot_companies_id_temp -> pluck('email')->toArray();
            }
            
            $pilot_companies_id = trim(implode(',',$pilot_companies_id), '');
            $startup_id = trim(implode(',',$startup_id), '');
            // echo new Carbon($request['event_from'].' '.$request['event_start']);
            // echo new Carbon($request['event_to'].' '.$request['event_end']);
            // die();
            // $dddd = $request['event_from'].' '.$request['event_start'];
            // $test = new Carbon($dddd);
            // print_r($test['date']);
            // die();
            // DB::enableQueryLog();
            $Event = Event::create([
                'collateral' => collect($collateral)->implode(','),
                'title' => $request['title'],
                'category' => $request['category'],
                'type' => $request['type'],
                'price' => $request['price'],
                'event_for' => $request['event_for'],
                'pilot_companies' => $pilot_companies_id,
                'startup_id' => $startup_id,
                'event_from' => date('Y-m-d', strtotime($request['event_from'])),
                'event_to' => date('Y-m-d', strtotime($event_to)),
                'event_start' => $request['event_start'],
                'event_end' => $request['event_end'],
                'short_description' => $request['short_description'],
                'description' => $request['description'],
                'duration' => $duration
            ]);
            // dd(DB::getQueryLog());
            // die();
            if($Event)
            {
                $success = true;
                $message = "Successfully uploaded";
                if($event_image !== false) Storage::disk('public')->move("{$event_image}", "uploads/event/Event{$Event->id}.jpg");
                if($event_banner_image !== false)
                {
                    Storage::disk('public')->move("{$event_banner_image}", "uploads/event/EventBanner{$Event->id}.jpg");
                }
                if($request['mailstatus'] && $request['mailstatus'] === 'true')
                {
                    $bulkEmail = array_unique(array_merge($startup_email,$pilot_companies_email,$extra_email_array));
                    $bulkEmail[] = "chetan.singh@webeesocial.com";
                    // dd($bulkEmail);
                    if(!empty($bulkEmail))
                    {
                        
                        $event_from_date = date('d M Y', strtotime($request['event_from']));
                        $event_to_date = date('d M Y', strtotime($event_to));
                        // $email['to_emails'] = $bulkEmail;
                        $sub = "Invitation: ".$request['title']." | {$event_from_date} - {$event_to_date} | {$request['category']}";
                        // $email['body'] = $request['description'];
                        $event = new Events;
                        $event->name = $request['title'];
                        $event->description = $request['description'];
                        $event->startDateTime = new Carbon($request['event_from'].' '.$request['event_start']);
                        $event->endDateTime = new Carbon($request['event_to'].' '.$request['event_end']);
                        $event->addAttendee(['email' => 'chetan.singh@webeesocial.com']);
                        // $event->addAttendee(['email' => 'anurag.joshi@webeesocial.com']);
                        // $event->addAttendee(['email' => 'vikram.saigal@acma.in']);
                        $files = [];
                        foreach($temp_collateral as $f){
                            $files[] = asset('storage/'.$f);
                        }
                        foreach($bulkEmail as $e){
                            $event->addAttendee(['email'=>$e]);
                            dispatch(new SendEmailJob($e,$sub,$request['description'],$files));
                        }
                        $event->save(null,['sendUpdates' => 'all']);
                    }
                }
            } else
            {
                if($event_image !== false)Storage::disk('public')->delete($event_image);
                if($event_banner_image !== false)Storage::disk('public')->delete($event_banner_image);
            }
        }
        return response()->json(['success' => $success, 'message' => $message, 'Image' => $imageStatus]);
    }

    public function update(Request $request) {

        $Event = Event::findOrFail(request() -> id);
        if(!$Event) return redirect() -> back();
        
        $responseData = array_merge(["data" => $Event], $this -> getStartupandPilot());
        if( $request->method() === 'GET') return view("admin.event.edit", $responseData);

        /* | Update Request | */
        $success = false;
        $message = "Something went wrong";
        $imageStatus = [];

        $request->validate([
            'event_image' => ['dimensions:width=370,height=238', 'mimes:jpg,jpeg,jfif,png'],
            'event_banner_image' => ['dimensions:width=1920,height=300', 'mimes:jpg,jpeg,jfif,png'],
            'title' => 'required',
            'category' => 'required',
            'type' => 'required',
            'price' => 'required',
            'event_for' => 'required',
            'event_from' => 'required',
            'event_to' => 'required',
            'event_start' => 'required',
            'event_end' => 'required',
            'short_description' => 'required',
            'description' => 'required'
        ]);
        $event_image = false;
        $event_banner_image = false;
        $collateral = [];
        $temp_collateral = [];
        if($request->file()) {
            if($request->file('event_image')) {
                if($event_image = $request->file('event_image')->storeAs('uploads/event/', 'Event'.request() -> id.'.jpg', 'public'))$imageStatus['event_image'] = [true, "successfully uploaded"];
            }
            if($request->file('event_banner_image')) {
                if($event_banner_image = $request->file('event_banner_image')->storeAs('uploads/event/', 'EventBanner'.request() -> id.'.jpg', 'public'))$imageStatus['event_banner_image'] = [true, "successfully uploaded"];
            }
            if($request->file('collateral'))
            {
                for($i = 0; $i < count($request->file('collateral')); $i++) {
                    do{
                        $extension = $request->file('collateral')[$i]->extension();
                        $uniqid = uniqid("Collateral").'.'.$extension;
                        $eval = Event::whereRaw("FIND_IN_SET('{$uniqid}', collateral)")->get();
                    } while(count($eval) > 0);

                    if($temp_collateral[] = $request->file('collateral')[$i]->storeAs('uploads/event/', $uniqid, 'public')) {
                        $collateral[] = $uniqid;
                        $imageStatus['collateral'][$i] = [true, "successfully uploaded"];
                    }
                }
            }
        }
        $oldCollateral = explode(",", $Event -> collateral);
        $uploadedcollateral = $request['uploadedcollateral'];
        $reserveCollateral = [];
        if($uploadedcollateral != null && $uploadedcollateral != '' && count($uploadedcollateral) > 0) {
            $reserveCollateral = array_intersect($oldCollateral, $uploadedcollateral);
            $deleteCollateral = array_diff($oldCollateral, $uploadedcollateral);
            foreach($deleteCollateral as $DC) Storage::disk('public')->delete('uploads/evaluator/'.$DC);
        }

        
            if($request['event_to'] === '' && $request['event_to'] === null) $event_to = $request['event_from'];
            else if($request['event_to'] < $request['event_from']) $event_to = $request['event_from'];
            else $event_to = $request['event_to'];
            
            $duration = $this->getDuration($request['event_from'], $event_to);

            // Email and Event For
            $event_for = $request['event_for'];
            $pilot_companies_id = [];
            $pilot_companies_email = [];
            $startup_id = [];
            $startup_email = [];
            $old_startup_email = [];
            $old_pilot_companies_email = [];
            if($event_for === 'startup' || $event_for === 'both')
            {
                if($request['startup_id'] && count($request['startup_id']) > 0)
                {
                    $startup_id_temp = StartupLogin::where('is_active', '1')
                    ->whereIn('id', $request['startup_id']);
                    
                } else $startup_id_temp = StartupLogin::where('is_active', '1');

                $startup_id_temp = $startup_id_temp->select('id', 'email');

                $startup_id = $startup_id_temp -> pluck('id')->toArray();
                $startup_email = $startup_id_temp -> pluck('email')->toArray();
                
                $old_startup_email_temp = $Event-> startup_id !== '' && $Event-> startup_id !== null ? explode(',', $Event-> startup_id) : [];
                $old_startup_email = StartupLogin::where('is_active', '1')
                ->whereIn('id', $old_startup_email_temp)
                ->pluck('email')->toArray();
            }

            if($event_for === 'pilot' || $event_for === 'both')
            {
                if($request['pilot_companies_id'] && count($request['pilot_companies_id']) > 0)
                {
                    $pilot_companies_id_temp = pilotCompaniesMember::where('is_active', '1')
                    ->whereIn('id', $request['pilot_companies_id']);
                    
                } else $pilot_companies_id_temp = pilotCompaniesMember::where('is_active', '1');

                $pilot_companies_id_temp = $pilot_companies_id_temp->select('id', 'email');
                
                $pilot_companies_id = $pilot_companies_id_temp -> pluck('id')->toArray();
                $pilot_companies_email = $pilot_companies_id_temp -> pluck('email')->toArray();

                $old_pilot_companies_email_temp = $Event-> pilot_companies !== '' && $Event-> pilot_companies !== null ? explode(',', $Event-> pilot_companies) : [];
                $old_pilot_companies_email = pilotCompaniesMember::where('is_active', '1')
                ->whereIn('id', $old_pilot_companies_email_temp)
                ->pluck('email')->toArray();
            }
            
            $pilot_companies_id = trim(implode(',',$pilot_companies_id), '');
            $startup_id = trim(implode(',',$startup_id), '');

            $Event -> collateral = collect(array_merge($reserveCollateral, $collateral))->implode(',');
            $Event -> title = $request['title'];
            $Event -> category = $request['category'];
            $Event -> type = $request['type'];
            $Event -> price = $request['price'];
            $Event -> event_for = $request['event_for'];
            $Event -> pilot_companies = $pilot_companies_id;
            $Event -> startup_id = $startup_id;
            $Event -> event_from =  date('Y-m-d', strtotime($request['event_from']));
            $Event -> event_to = date('Y-m-d', strtotime($event_to));
            $Event -> event_start = $request['event_start'];
            $Event -> event_end = $request['event_end'];
            $Event -> short_description = $request['short_description'];
            $Event -> description = $request['description'];
            $Event -> duration = $duration;
            $Event -> save();
            if($Event)
            {
                

                // print_r($bulkEmail);
                // die();
                if($request['mailstatus'] && $request['mailstatus'] == 'true')
                {
                    // if(!empty($bulkEmail))
                    // {
                        $old_bulk_email = array_unique(array_merge($old_pilot_companies_email,$old_startup_email));
                        $bulkEmail_temp = array_unique(array_merge($startup_email,$pilot_companies_email));

                        $removeduser_bulkEmail = array_udiff($old_bulk_email, $bulkEmail_temp, function($a,$b)
                        {
                            if($a===$b) return 0;
                            return ($a>$b)?1:-1;
                        });
                        $existinguser_bulkEmail = array_filter($bulkEmail_temp,function ($var) use($old_bulk_email){
                          if(in_array($var, $old_bulk_email)) return 1;
                        });
                        // print_r(json_encode($existinguser_bulkEmail));
                        $newuser_bulkEmail = array_diff($bulkEmail_temp, $old_bulk_email);
                        
                        $event_from_date = date('d M Y', strtotime($request['event_from']));
                        $event_to_date = date('d M Y', strtotime($event_to));
                        if(count($removeduser_bulkEmail) > 0)
                        {
                            $email['to_emails'] = $removeduser_bulkEmail;
                            $email['subject'] = "Updated Invitation: Removed From Event | ".$request['title']." | {$event_from_date} - {$event_to_date} | {$request['category']}";
                            $email['body'] = "Unfortunately you have been removed the event which were scheduled for {$Event->event_from} - {$Event->event_to}";
                            $EventMail = $this -> sendEventMail($email);
                        }
                        if(count($existinguser_bulkEmail) > 0 && $request['mailchanges'] == 'true')
                        {
                            $email['to_emails'] = $existinguser_bulkEmail;
                            $email['subject'] = "Updated Invitation: ".$request['title']." | {$event_from_date} - {$event_to_date} | {$request['category']}";
                            $email['body'] = $request['description'];
                            $EventMail = $this -> sendEventMail($email);
                        }
                        if(count($newuser_bulkEmail) > 0)
                        {
                            $sub = "Invitation: ".$request['title']." | {$event_from_date} - {$event_to_date} | {$request['category']}";
                            // $email['to_emails'] = $newuser_bulkEmail;
                            // $email['subject'] = "Invitation: ".$request['title']." | {$event_from_date} - {$event_to_date} | {$request['category']}";
                            // $email['body'] = $request['description'];
                            // $EventMail = $this -> sendEventMail($email);
                            $event = new Events;
                            $event->name = $request['title'];
                            $event->description = $request['description'];
                            $event->startDateTime = new Carbon($request['event_from'].' '.$request['event_start']);
                            $event->endDateTime = new Carbon($request['event_to'].' '.$request['event_end']);
                            $files = [];
                            foreach($temp_collateral as $f){
                                $files[] = asset('storage/'.$f);
                            }
                            foreach($newuser_bulkEmail as $e){
                                $event->addAttendee(['email'=>$e]);
                                dispatch(new SendEmailJob($e,$sub,$request['description'],$files));
                            }
                            $event->save(null,['sendUpdates' => 'all']);
                        }
                    // }
                }

                $success = true;
                $message = "Successfully updated";
                // Storage::disk('local')->move("{$event_image}", "uploads/event/Event{$Event->id}.jpg");
                // Storage::disk('local')->move,event_banner_image}", "uploads/event/EventBanner{$Event->id}.jpg");
            }
        return response()->json(['success' => $success, 'message' => $message, 'Image' => $imageStatus, 'updated' => $Event]);
    }

    public function delete() {
        $success = false;
        $message = "Something went wrong";

        $Event = Event::findOrFail(request() -> id);
        if($Event)
        {
            $Event -> delete();
            if($Event)
            {
                $success = true;
                $message = "Successfully deleted";
                Storage::disk('public')->delete('uploads/event/Event'.request() -> id. '.jpg');
                Storage::disk('public')->delete('uploads/event/EventBanner'.request() -> id. '.jpg');
            }
        }
        
        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function getPilotCompany(Request $request) {
        $success = false;
        $message = "Something went wrong!";
        
        $search = $request->query('search');//where('email',"LIKE%{$search}%")
        $pilotCompany = pilotCompaniesMember::select('id', 'email', 'name', 'designation')
        ->get();
        
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $pilotCompany
        ]);
    }

    public function eventRegister() {
        $success = false;
        $message = "Something went wrong!";

        $type = '';
        $member_id = '';
        if(session() -> has('pilot'))
        {
            $type = 'pilot';
            $member_id = session('pilot') -> company_id;
        } else if(session() -> has('startup'))
        {
            $type = 'startup';
            $member_id = $startup -> id;
        }
        if($type === '' || $member_id === '') $message = "You are not logged In";
        else 
        {
            $Event = Event::findOrFail(request() -> id);
            if($Event)
            {
                $eventRegister = eventRegister::where([['event_id', $Event -> id], ['type', $type], ['member_id', $member_id]]) -> select('id') -> get();
                // echo ;
                if(count($eventRegister) === 0)
                {
                    $c_eventRegister = eventRegister::create([
                        'event_id' => request() -> id,
                        'type' => $type,
                        'member_id' => $member_id
                    ]);
                    if($c_eventRegister)
                    {
                        $success = true;
                        $message = "Registered";
                    } else $message = "Something went wrong! Pls try again later";
                }
            }
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }

    /*
    |Other Stuff
    ------------ */
    public function getDuration($start, $end) {
        $start = new DateTime($start);
        $end = new DateTime($end);
        if($start == $end)return '1 Day';
        $diff = $end->diff($start); 
        
        if($diff -> format('%y') != 0)return $diff -> format('%y') . ' Year';
        if($diff -> format('%d') != 0)return $diff -> format('%d') + 1 . ' Day';
        return '-';
    }

    public function sendEventMail($data) {
        $sendMail = Mail::send('emailer.eventmail', $data, function($message) use ($data) {
            $message->from('acma@acma.in');
            $message->to($data['to_emails']);
            $message->subject($data['subject']);
        });
        return $sendMail;
    }
    
    //  public function sendEventMail($data) {
    //     $sendMail = Mail::send('emailer.eventmail', $data, function($message) use ($data) {
    //         $message->from('acma@acma.in');
    //         $message->to($data['to_emails']);
    //         $message->subject($data['subject']);
    //     });
    //     return $sendMail;
    // }
    
    private function getStartupandPilot() {
        $pilotCompany = pilotCompaniesMember::where('is_active', 1)
        ->select('id', 'email', 'name', 'designation')
        ->orderBy("id", "desc")
        ->get();
        $startup = Startup::where([['is_active', 1], ['request', 1]])
        ->select('id', 'startup_id', 'company_name')
        ->with([
            'startup_login' => function($query){
                return $query->select('id', 'email');
            }
        ])
        ->orderBy("id", "desc")
        ->get();
        return [
            'data_pilot'=> $pilotCompany, 
            'data_startup'=> $startup
        ];
    }

    public function validate_old_data(Request $request) {
        /*
        $success = 0;
        $message = "Something went wrong!";

        $Event = Event::findOrFail(request() -> id);
        if(!$Event)
        {
            $message = "something went wrong! pls try again"
        } else
        {
            $Event -> event_end = $request['event_end'];
            if
            (
                trim($request['title'], "") !== trim($Event -> title, '') ||
                trim($request['category'], "") !== trim($Event -> category, '') ||
                trim($request['category'], "") !== trim($Event -> category, '') ||
                trim($request['category'], "") !== trim($Event -> category, '') ||
                trim($request['category'], "") !== trim($Event -> category, '') ||
                trim($request['category'], "") !== trim($Event -> category, '') ||
                trim($request['category'], "") !== trim($Event -> category, '') ||
            )
            {

            }
        }

        return response()->json(['success' => $success, 'message' => $message]);
        */
    }
}
