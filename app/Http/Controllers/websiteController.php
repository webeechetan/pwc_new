<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Case_Studies;
use App\Models\Event;
use App\Models\EventRegister;
use App\Models\HomePage;
use App\Models\KnowledgeSharing;
use App\Models\Season;
use Illuminate\Support\Facades\DB;

class websiteController extends Controller
{

    public function index() {
        $homepage = HomePage::first();
        $upcomingevent = [];
        $upcomingevent = $this->upcomingEvent()->orderBy('event_from', 'ASC');
        $upcomingevent = $upcomingevent->take(3)->get();
        $caseStudies = Case_Studies::all()->take(3);
        $KnowledgeSharing = KnowledgeSharing::all()->take(3);
        $seasons = Season::all();
        return view('home', ["data" => $homepage, "upcomingevent" => $upcomingevent, "caseStudies" => $caseStudies, "KnowledgeSharing"=>$KnowledgeSharing,'seasons'=>$seasons]);
    }

    public function caseStuides() {
        $caseStudies = Case_Studies::all();
        $recent = Case_Studies::orderBy('created_at', 'DESC')->offset(0)->limit(1)->get()->first();
        
        $event = $this->upcomingEvent()->orderBy('event_from', 'ASC')->get();
        // print_r(json_encode($event));
        // die();
        return view('case_studies/index',[
            'caseStudies' => $caseStudies, 
            'event' => $event, 
            "recent" => $recent
        ]);
    }

    public function viewCaseStuides() {
        $case = Case_Studies::findOrFail(request()->id);
        if($case)
        {
            return view('case_studies/view', ['case' => $case]);
        }
    }

    public function knowledgeSharing(){
        $KnowledgeSharing = KnowledgeSharing::all();
        $recent = KnowledgeSharing::orderBy('created_at', 'DESC')->offset(0)->limit(1)->get()->first();
        
        $event = $this->upcomingEvent()->orderBy('event_from', 'ASC')->get();
        // print_r(json_encode($event));
        // die();
        return view('knowledge_sharing.index',[
            'KnowledgeSharing' => $KnowledgeSharing, 
            'event' => $event, 
            "recent" => $recent
        ]); 
    }

    public function viewKnowledgeSharing($id){
        $KnowledgeSharing = KnowledgeSharing::find($id);
        return view('knowledge_sharing.view',compact('KnowledgeSharing'));
    }

    public function event() {
        $upcoming = $this->ongoingUpcomingEvent()
            ->orderBy('event_from', 'ASC')->get();

        $past = $this -> pastEvent()
            ->orderBy('event_from', 'DESC')->get();
        // DB::enableQueryLog();
        $recent = $this -> recentEvent()
            ->orderBy('event_from', 'ASC')->get()->first();  
        return view('event/list', ["upcoming" => $upcoming, "past" => $past, "recent" => $recent]);
    }

    public function viewEvent() {
        $event = Event::findOrFail(request()->id);
        if($event)
        {
            if((session() -> has('pilot') && $event -> event_for === 'startup') || (session() -> has('startup') && $event -> event_for === 'pilot')) return redirect() -> back();
            $upcoming = $this->upcomingEvent()->orderBy('event_from', 'ASC')->get();
            $caseStudies = Case_Studies::all();

            $type = $member_id = '';
            if(session() -> has('pilot'))
            {
                $type = 'pilot';
                $member_id = session('pilot') -> company_id;
            } else if(session() -> has('startup'))
            {
                $type = 'startup';
                $member_id = session('startup') -> id;
            }
            $eventregister = eventRegister::where([['event_id', $event -> id], ['type', $type], ['member_id', $member_id]]) -> select('id') -> get();

            return view('event/view', ["event" =>  $event, "eventregistered" => $eventregister, "upcoming" =>  $upcoming, 'caseStudies' => $caseStudies]);
        }
    }
    
    public function searchEvent(Request $request) {
        $upcoming = $this->ongoingUpcomingEvent()
            ->select('title', 'id', 'short_description', 'event_from')
            ->orderBy('event_from', 'ASC');
        $past = $this->pastEvent()
        ->select('title', 'id', 'short_description', 'event_from')
            ->orderBy('event_from', 'DESC');
        if($request['year'])
        {
            $year = $request['year'];
            if(!empty($year) && $year != '')
            {
                $upcoming =  $upcoming->where(function($query1) use ($year){
                    foreach($year as $y)
                    {
                        $query1 = $query1 -> orWhereYear('event_from', $y);
                        $query1 = $query1 -> orWhereYear('event_to', $y);
                    }
                    return $query1;
                });
                $past =  $past->where(function($query1) use ($year){
                    foreach($year as $y)
                    {
                        $query1 = $query1 -> orWhereYear('event_from', $y);
                        $query1 = $query1 -> orWhereYear('event_to', $y);
                    }
                    return $query1;
                });
            }
        }
        if($request['month'])
        {
            $month = $request['month'];
            if(!empty($month) && $month != '')
            {
                $upcoming =  $upcoming->where(function($query1) use ($month){
                    foreach($month as $m)
                    {
                        $query1 = $query1 -> orWhereMonth('event_from', $m);
                        $query1 = $query1 -> orWhereMonth('event_to', $m);
                    }
                    return $query1;
                });
                $past =  $past->where(function($query1) use ($month){
                    foreach($month as $m)
                    {
                        $query1 = $query1 -> orWhereMonth('event_from', $m);
                        $query1 = $query1 -> orWhereMonth('event_to', $m);
                    }
                    return $query1;
                });
            }
        }
        if($request['type'])
        {
            $type = $request['type'];
            if(!empty($type) && $type != '')
            {
                $upcoming =  $upcoming->where(function($query1) use ($type){
                    foreach($type as $t)
                    {
                        $query1 = $query1 -> orWhere('type', $t);
                    }
                    return $query1;
                });
                $past =  $past->where(function($query1) use ($type){
                    foreach($type as $t)
                    {
                        $query1 = $query1 -> orWhere('type', $t);
                    }
                    return $query1;
                });
            }
        }
        
        $upcoming = $upcoming -> get();
        $past = $past -> get();
        return response()->json(['success' => true, 'message' => "success", "upcoming" => $upcoming, "past" => $past]);
    }

    public function auth() {
        return view('auth/index');
    }

    private function upcomingEvent() {
        return Event::where('event_from', '>', date('Y-m-d'))
        ->where(function($query){
            $q = $query;
            if(session()->has('pilot'))
            {
                $q = $q -> where(function($query1){
                    $query1 = $query1 -> orWhere('event_for', '=','pilot');
                    $query1 = $query1 -> orWhere('event_for', '=','both');
                    return $query1;
                });
                $q = $q -> whereRaw("FIND_IN_SET(".session('pilot')->id.", pilot_companies)");
            } else if(session()->has('startup'))
            {
                $q = $q -> where(function($query1){
                    $query1 = $query1 -> orWhere('event_for', '=','startup');
                    $query1 = $query1 -> orWhere('event_for', '=','both');
                    return $query1;
                });
                $q = $q -> whereRaw("FIND_IN_SET(".session('startup')->id.", startup_id)");
            } else
            {
                $q = $q -> orWhere('event_for', 'public');
            }
            return $q;
        });;
    }

    private function ongoingUpcomingEvent() {
            $event = Event::where([[function($query1){
                $query1 = $query1->where([['event_from', '<=', date('Y-m-d')], ['event_to', '>=', date('Y-m-d')]]);
                $query1 = $query1->orWhere('event_from', '>', date('Y-m-d'));
                return $query1;
            }]])
            ->where(function($query){
                $q = $query;
                if(session()->has('pilot'))
                {
                    $q = $q -> where(function($query1){
                        $query1 = $query1 -> orWhere('event_for', '=','pilot');
                        $query1 = $query1 -> orWhere('event_for', '=','both');
                        return $query1;
                    });
                    $q = $q -> whereRaw("FIND_IN_SET(".session('pilot')->id.", pilot_companies)");
                } else if(session()->has('startup'))
                {
                    $q = $q -> where(function($query1){
                        $query1 = $query1 -> orWhere('event_for', '=','startup');
                        $query1 = $query1 -> orWhere('event_for', '=','both');
                        return $query1;
                    });
                    $q = $q -> whereRaw("FIND_IN_SET(".session('startup')->id.", startup_id)");
                } else
                {
                    $q = $q -> orWhere('event_for', 'public');
                }
                return $q;
            });
            // $event = $event -> whereOr();
            return $event;
    }

    private function pastEvent() {
        return Event::where('event_to', '<', date('Y-m-d'))
                ->where(function($query){
                    $q = $query;
                    if(session()->has('pilot'))
                    {
                        $q = $q -> where(function($query1){
                            $query1 = $query1 -> orWhere('event_for', '=','pilot');
                            $query1 = $query1 -> orWhere('event_for', '=','both');
                            return $query1;
                        });
                        $q = $q -> whereRaw("FIND_IN_SET(".session('pilot')->id.", pilot_companies)");
                    } else if(session()->has('startup'))
                    {
                        $q = $q -> where(function($query1){
                            $query1 = $query1 -> orWhere('event_for', '=','startup');
                            $query1 = $query1 -> orWhere('event_for', '=','both');
                            return $query1;
                        });
                        $q = $q -> whereRaw("FIND_IN_SET(".session('startup')->id.", startup_id)");
                    } else
                    {
                        $q = $q -> orWhere('event_for', 'public');
                    }
                    return $q;
                });
    }

    private function recentEvent() {
        return Event::where([['event_from', '<=', date('Y-m-d')], ['event_to', '>=', date('Y-m-d')]])
                ->where(function($query){
                    $q = $query;
                    if(session()->has('pilot'))
                    {
                        $q = $q -> where(function($query1){
                            $query1 = $query1 -> orWhere('event_for', '=','pilot');
                            $query1 = $query1 -> orWhere('event_for', '=','both');
                            return $query1;
                        });
                        $q = $q -> whereRaw("FIND_IN_SET(".session('pilot')->id.", pilot_companies)");
                    } else if(session()->has('startup'))
                    {
                        $q = $q -> where(function($query1){
                            $query1 = $query1 -> orWhere('event_for', '=','startup');
                            $query1 = $query1 -> orWhere('event_for', '=','both');
                            return $query1;
                        });
                        $q = $q -> whereRaw("FIND_IN_SET(".session('startup')->id.", startup_id)");
                    } else
                    {
                        $q = $q -> orWhere('event_for', 'public');
                    }
                    return $q;
                });
    }
}
