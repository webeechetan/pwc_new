<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $fillable = [
        'is_active',
        'name',
        'slug',
    ];

    public function admin() {
        return $this->belongsTo(Admin::class, 'id', 'role_id');
    }

    public function permission() {
        return $this->hasMany(permission::class, 'role_id', 'id');
    }
}
