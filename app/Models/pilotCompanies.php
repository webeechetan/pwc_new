<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Startup;
use App\Models\StartupApproval;
use App\Models\pilotCompaniesMember;

class pilotCompanies extends Model
{
    use HasFactory;
    protected $table = 'pilot_companies';
    protected $fillable = [
        'name',
        'added_by',
        'updated_by',
    ];

    public function approvedCompany(){
        return $this->hasMany(StartupApproval::class,'pilot_companies_id', 'id')->orderBy('pilot_companies_id');
    }

    public function members(){
        return $this->hasMany(pilotCompaniesMember::class,'pilot_companies_id','id');
    }

}
