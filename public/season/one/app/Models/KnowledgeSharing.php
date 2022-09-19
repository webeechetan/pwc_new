<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeSharing extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'added_by',
        'updated_by',
        'title',
        'overview',
        'description',
        'overview_image',
        'banner_image',
        'files'
    ];
}
