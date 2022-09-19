<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Startup;
use App\Scopes\SeasonScope;

class StartupApproval extends Model
{
    use HasFactory;
    protected $table = 'startup_approval';
    protected $fillable = [
        'pilot_companies_id',
        'pilot_companies_member_id',
        'startup_id',
        'approved',
        'stage'
    ];

    public function pilot_companies() {
        return $this->belongsTo(pilotCompanies::class, 'pilot_companies_id', 'id');
    }

    public function companyName(){
        return $this->belongsTo(Startup::class, 'startup_id','id')->withoutGlobalScope(SeasonScope::class);
    }
}
