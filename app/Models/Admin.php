<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = [
        'is_active',
        'role_id',
        'fullname',
        'email',
        'password'
    ];


    public function roles() {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }
}
