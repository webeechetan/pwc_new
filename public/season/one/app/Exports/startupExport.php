<?php

namespace App\Exports;

use App\Models\Startup;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class startupExport implements FromQuery, WithHeadings
{
    // use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public $single;
    public function __construct($id,$single)
    {
        $this->id = $id;
        $this->single = $single;
    }

    public function query()
    {
        if($this->single){
                $id = $this->id;
                $startup = DB::table('startup')->select(['company_name', 'description', 'country', 'state', 'city', 'pincode', 
                 'zone', 'address', 'founded_on', 'company_type', 'industry', 'type_of_services', 'specialities', 'company_size', 
                 'revenue', 'website', 'facebook', 'twitter', 'linkedin', 'instagram', 'designation', 'fullname', 'email', 'mobile'])
                 ->leftJoin('startup_login', 'startup.startup_id', 'startup_login.id')
                 ->where('startup.id',$id)
                 ->orderBy('startup.id', 'DESC');
                 return $startup;
            }else{
                $id = $this->id;
                $startup = DB::table('startup')->select(['company_name', 'description', 'country', 'state', 'city', 'pincode', 
                 'zone', 'address', 'founded_on', 'company_type', 'industry', 'type_of_services', 'specialities', 'company_size', 
                 'revenue', 'website', 'facebook', 'twitter', 'linkedin', 'instagram', 'designation', 'fullname', 'email', 'mobile'])
                 ->leftJoin('startup_login', 'startup.startup_id', 'startup_login.id');
                 foreach($id as $i){
                     $startup->orWhere('startup.id',$i);
                 }
                 $startup->orderBy('startup.id', 'DESC');
                 return $startup;
            }
    }

    public function headings(): array
    {
        return ['company_name', 'description', 'country', 'state', 'city', 'pincode', 'zone', 'address', 'founded_on', 'company_type', 'industry', 'type_of_services', 'specialities', 'company_size', 'revenue', 'website', 'facebook', 'twitter', 'linkedin', 'instagram', 'designation', 'fullname', 'email', 'mobile',];
    }
}
