<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;
    protected $table = 'footer';
    protected $fillable = [
        'description',
        'quick_link_title',
        'copyright_title',
        'fb',
        'twitter',
        'linkedin',
        'youtube'
    ];
}
