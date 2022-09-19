<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegister extends Model
{
    use HasFactory;
    protected $table = 'event_register';
    protected $fillable = [
        'event_id',
        'type',
        'member_id',
    ];
}
