<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Startup;
use App\Models\StartupApproval;
use App\Models\StartupLogin;

use App\Models\pilotCompanies;
use App\Models\pilotCompaniesMember;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class testController extends Controller
{
    // To Update Pilot companies vote
    public function index(Request $request) {
        /*
        $pilot_companies = [
            //Abilities India Pistons & Rings Ltd
            "5+1" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => '1',
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => '1',
                        'meet1' => 1,
                        'meet2' => 1
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => '1',
                        'meet1' => 1,
                        'meet2' => 1
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 1,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 1,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Anand Automotive Ltd
            "6+3" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 0,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 1,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 0,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //J.K. Fenner (India) Limited
            "7+5" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 1,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 1,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //JBM Auto Ltd
            "8+7" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 0,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 0,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Lucas TVS Limited
            "9+9" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 0,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 1,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 0,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Lumax Group
            "10+11" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 0,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 0,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 0,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 0,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 0,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 0,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 0,
                    ],
                ],
            //NRB Bearings Ltd
            "11+13" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet1' => 1,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 1,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 1,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 1,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 0,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 0,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Pricol Ltd
            "12+15" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet1' => 1,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 0,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 1,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 1,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 1,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 0,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Rockman Industries Ltd
            "13+17" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 1,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 1,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 1,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 0,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Sandhar Technologies Ltd
            "14+19" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 0,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 0,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 1,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 0,
                    ],
                ],
            //Sansera Engineering Limited
            "15+21" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 1,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 1,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 1,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 1,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Sellowrap Industries Pvt Ltd
            "16+23" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 1,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 1,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 1,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 1,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 0,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 1,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 1,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Sellowrap Industries Pvt Ltd
            "17+25" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 0,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 0,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 0,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 0,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 0,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 0,
                    ],
                ],
            
            //SSS
            "18+27" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                        
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 0,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 1,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 1,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 0,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 0,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 1,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 1,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Suprajit
            "19+29" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                        
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 1,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 0,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 0,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 0,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 0,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 1,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 1,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
            //Yazaki India Private Limited
            "20+31" => [
                    "6" => [
                        'company_name' => 'Redbot Innovations Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 0,
                        
                    ],
                    "7" => [
                        'company_name' => 'EV Motors India Pvt. Ltd.',
                        'screening' => 1,
                        'meet1' => 1,
                        'meet2' => 0,
                    ],
                    "13" => [
                        'company_name' => 'Konmos Technologies',
                        'screening' => 0,
                    ],
                    "11" => [
                        'company_name' => 'Elecnovo',
                        'screening' => 0,
                    ],
                    "15" => [
                        'company_name' => 'Log9 Materials',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "12" => [
                        'company_name' => 'EMF Innovations',
                        'screening' => 0,
                    ],
                    "14" => [
                        'company_name' => 'Lithion Power',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "9" => [
                        'company_name' => 'CellProp Pvt Ltd',
                        'screening' => 1,
                        'meet1' => 0,
                    ],
                    "8" => [
                        'company_name' => 'CamCom Technologies Private Limited',
                        'screening' => 0,
                    ],
                    "10" => [
                        'company_name' => 'Ecolibrium Energy',
                        'screening' => 0,
                    ],
                    "16" => [
                        'company_name' => 'Think7 Business Systems Private Limited',
                        'screening' => 0,
                    ],
                    "17" => [
                        'company_name' => 'Zenatix Solutions',
                        'screening' => 0,
                    ],
                    "21" => [
                        'company_name' => 'Auring',
                        'screening' => 0,
                    ],
                    "22" => [
                        'company_name' => 'Autosys Industrial Solutions Private Limited',
                        'screening' => 1,
                    ],
                    "23" => [
                        'company_name' => 'Digi2O Information Solutions Pvt. Ltd.',
                        'screening' => 1,
                    ],
                    "27" => [
                        'company_name' => 'Energyly',
                        'screening' => 0,
                    ],
                    "26" => [
                        'company_name' => 'Imaginate Technologies, Inc.',
                        'screening' => 0,
                    ],
                    "24" => [
                        'company_name' => 'Persapien Innovations',
                        'screening' => 0,
                    ],
                    "25" => [
                        'company_name' => 'Sensovision',
                        'screening' => 1,
                    ],
                ],
                
        ];
        foreach($pilot_companies as $key => $value)
        {
            $pilot_company_id = explode('+', $key);
            foreach($value as $startup_id => $detail)
            {
                $ssss = Startup::where('startup_id', $startup_id) -> select('id') -> get() -> first();
                // echo "<br>screening<br>";
                $screening = $detail['screening'] == 1 || $detail['screening'] == '1' ? 1 : 2;
                StartupApproval::create([
                    'pilot_companies_id' => $pilot_company_id[0],
                    'pilot_companies_member_id' => $pilot_company_id[1],
                    'startup_id' => $ssss -> id,
                    'approved' => $screening,
                    'stage' => 'screening'
                ]);
                if(isset($detail['meet1']))
                {
                    $meet1 = $detail['meet1'] == 1 || $detail['meet1'] == '1' ? 1 : 2;
                    StartupApproval::create([
                        'pilot_companies_id' => $pilot_company_id[0],
                        'pilot_companies_member_id' => $pilot_company_id[1],
                        'startup_id' => $ssss -> id,
                        'approved' => $meet1,
                        'stage' => 'meeting1'
                    ]);
                }
                if(isset($detail['meet2']))
                {
                    $meet2 = $detail['meet2'] == 1 || $detail['meet2'] == '1' ? 1 : 2;
                    StartupApproval::create([
                        'pilot_companies_id' => $pilot_company_id[0],
                        'pilot_companies_member_id' => $pilot_company_id[1],
                        'startup_id' => $ssss -> id,
                        'approved' => $meet2,
                        'stage' => 'meeting2'
                    ]);
                }
                // echo "<hr>";
            }
        }
    */
    }
}
