<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Case_Studies extends Model
{
    use HasFactory;
    protected $table = 'case_studies';
    protected $fillable = [
        'is_active',
        'added_by',
        'updated_by',
        'title',
        'overview',
        'description'
    ];
}
