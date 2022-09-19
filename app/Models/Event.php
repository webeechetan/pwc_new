<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'event';
    protected $fillable = [
        'is_active',
        'title',
        'category',
        'type',
        'price',
        'event_for',
        'startup_id',
        'pilot_companies',
        'event_from',
        'event_to',
        'event_start',
        'event_end',
        'short_description',
        'description',
        'duration',
        'collateral'
    ];
}
