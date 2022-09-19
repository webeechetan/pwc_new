<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pilotCompaniesMember extends Model
{
    use HasFactory;
    protected $table = 'pilot_companies_member';
    protected $fillable = [
        'pilot_companies_id',
        'name',
        'designation',
        'email',
        'password'
    ];

    public function pilot_companies() {
        return $this->belongsTo(pilotCompanies::class, 'pilot_companies_id', 'id');
    }
}
