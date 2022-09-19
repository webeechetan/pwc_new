<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permission';
    protected $fillable = [
        'is_active',
        'role_id',
        'module_id',
        'action_id'
    ];

    public function modules() {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function actions() {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }
}
