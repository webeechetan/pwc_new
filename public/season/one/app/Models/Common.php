<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Common extends Model
{
    use HasFactory;
    protected $table = 'common';
    protected $fillable = [
        'type',
        'content1',
        'content2',
        'content3',
        'content4',
        'description1',
        'description2',
    ];
}
