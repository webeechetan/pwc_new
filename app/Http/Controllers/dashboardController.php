<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Startup;
use App\Models\pilotCompanies;
use App\Models\Event;
use App\Models\Contact;
use App\Models\StartupApproval;

class dashboardController extends Controller
{
    public function index()
    {
        $test = [];
        $table = "<table id='dataTable' border='1px' style='text-align:center' class='table'>";
        $table .= "<thead>";
        $table .= "<tr>";
        $table .= "<th style='background-color:#a3d4ff; color:#ffffff;'>Working Committee Member Company</th>";
        $table .= "<th style='background-color:#a3d4ff; color:#ffffff;'>Company Representatives</th>";
        $startups = Startup::where('is_active','1')->orderByRaw('cast(id as unsigned) ASC')->get();
        foreach ($startups as $startup) {
            $table .= "<th colspan='3' style='background-color:#ff8c8a; color:#ffffff;'>" . $startup->company_name . "</th>";
        }
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<td></td>";
        $table .= "<td></td>";
        for ($i = 0; $i < count($startups); $i++) {
            $table .= "<td>Screening Result</td>";
            $table .= "<td>Interested after 1st physical meeting</td>";
            // $table .= "<td>2nd Meeting Result</td>";
            $table .= "<td>Final Result</td>";
        }
        $table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody>";
        $pilots = pilotCompanies::all();
        foreach ($pilots as $pilot) {
            
            $table .= "<tr>";
            $table .= "<td>" . $pilot->name . "</td>";
            $name = "";
            foreach ($pilot->members as $member) {
                $name .= $member->name . "<br>";
            }
            $table .= "<td>" . $name . "</td>";
            foreach ($startups as $startup) {
                $data = ["screening" => false, "meeting1" => false, "meeting2" => false];
                $final = StartupApproval::where('pilot_companies_id', $pilot->id)->where('startup_id', $startup->id)->get();
                foreach ($final as $f) {
                    if ($f->stage == 'screening') {
                        if ($f->approved == '1') {
                            $data['screening'] = 'Y';
                        } else if($f->approved == '2') {
                            $data['screening'] = 'N';
                        }
                    }
                    if ($f->stage == 'meeting1') {
                        if ($f->approved == '1') {
                            $data['meeting1'] = 'Y';
                        } else if($f->approved=='2') {
                            $data['meeting1'] = 'N';
                        }
                    }
                    // if ($f->stage == 'meeting2') {
                    //     if ($f->approved == 1) {
                    //         $data['meeting2'] = 'Y';
                    //     } else if($f->approved == '2') {
                    //         $data['meeting2'] = 'N';
                    //     }
                    // }
                }
                if ($data['screening']) {
                    $table .= "<td>" . $data['screening'] . "</td>";
                } else {
                    $table .= "<td style='background-color:#f0951f; color:#ffffff;'>" . $data['screening'] . "</td>";
                }
                if ($data['meeting1']) {
                    $table .= "<td>" . $data['meeting1'] . "</td>";
                } else {
                    $table .= "<td style='background-color:#f0951f; color:#ffffff;'>" . $data['meeting1'] . "</td>";
                }
                // if ($data['meeting2']) {
                //     $table .= "<td>" . $data['meeting2'] . "</td>";
                // } else {
                //     $table .= "<td style='background-color:#f0951f; color:#ffffff;'>" . $data['meeting2'] . "</td>";
                // }
                $table .= "<td></td>";
            }
            $table .= "</tr>";
        }

        $yesCount = [];
        $noCount = [];
        $table .= "<tr>";
        $table .= "<td>Total Yes</td>";
        $table .= "<td></td>";
        foreach ($startups as $startup) {
            // $table .= "<td colspan='4'>".$startup->company_name."</td>";
            array_push($yesCount, count($startup->screeningApproved));
            array_push($yesCount, count($startup->meeting1Approved));
            array_push($yesCount, count($startup->meeting2Approved));
            array_push($noCount, count($startup->screeningRejected));
            array_push($noCount, count($startup->meeting1Rejected));
            array_push($noCount, count($startup->meeting2Rejected));

        }

        $j=0;
        for($i = 0; $i < count($yesCount); $i++) {
            $table.= "<td>".$yesCount[$i]."</td>";
            if($j==2){
                $table .= "<td></td>";
                $j=-1;
            }
            $j++;
        }
        $table .= "</tr>";

        $table .= "<tr>";
        $table .= "<td >Total No</td>";
        $table .= "<td ></td>";
        $j=0;
        for($i = 0; $i < count($noCount); $i++) {
            $table.= "<td>".$noCount[$i]."</td>";
            if($j==2){
                $table .= "<td></td>";
                $j=-1;
            }
            $j++;
        }
        $table .= "</tr>";
        $table .= "</tbody>";

        $table .= "</table>";
        
        $tableForExport = str_replace("id='dataTable'","id='exportTable'",$table); 

        $startup = Startup::all()->count();
        $pilotCompanies = pilotCompanies::all()->count();
        $event = Event::all()->count();
        $queries = Contact::all()->count();

        return view("admin.dashboard", [
            "data_startup" => $startup,
            "data_pilot" => $pilotCompanies,
            "data_event" => $event,
            "data_query" => $queries,
            "table" => $table,
            "tableForExport" => $tableForExport
        ]);
    }
}
