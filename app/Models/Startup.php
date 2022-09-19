<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\SeasonScope;

class Startup extends Model
{
    use HasFactory;
    protected $table = 'startup';
    protected $fillable = [
        'is_active',
        'startup_id',
        'added_by',
        'updated_by',
        'request',
        'collateral',
        'company_name',
        'description',
        'country',
        'state',
        'city',
        'pincode',
        'zone',
        'address',
        'founded_on',
        'company_type',
        'industry',
        'type_of_services',
        'specialities',
        'company_size',
        'revenue',
        'certified',
        'title',
        'website',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'name',
        'designation',
        'email',
        'phone',
        'season_id'
    ];

    public function startup_approval() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id');
    } 

    public function screening() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id') -> where('stage', 'screening');
    }

    public function meeting1() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id') -> where('stage', 'meeting1');
    }

    public function meeting2() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id') -> where('stage', 'meeting2');
    }

    public function finalcall() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id') -> where('stage', 'finalcall');
    }

    public function startup_login() {
        return $this->hasOne(StartupLogin::class, 'id', 'startup_id')->withoutGlobalScope(SeasonScope::class);
    }

    public function screeningApproved() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id')->where('approved', '1')->where('stage','screening');
    }

    public function meeting1Approved() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id')->where('approved', '1')->where('stage','meeting1');
    }

    public function meeting2Approved() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id')->where('approved', '1')->where('stage','meeting2');
    }

    public function screeningRejected() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id')->where('approved', '2')->where('stage','screening');
    }
    public function meeting1Rejected() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id')->where('approved', '2')->where('stage','meeting1');
    }
    public function meeting2Rejected() {
        return $this->hasMany(StartupApproval::class, 'startup_id', 'id')->where('approved', '2')->where('stage','meeting2');
    }
}
