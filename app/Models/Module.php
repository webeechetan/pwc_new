<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $table = 'module';

    // public function action() {
    //     // return $this->hasMany(permission::class, 'module_id', 'id');
    //     return Action::whereIn('id', $this->layer_ids);
    // }

    public function permissions() {
        return $this->hasMany(permission::class, 'module_id', 'id');
    }
}
