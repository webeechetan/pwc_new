<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Models\Season;

class SeasonScope implements Scope
{
    public $current_active_season;

    public function __construct(){
        $this->current_active_season = Season::where('is_active','1')->first();
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('season_id','=', $this->current_active_season->id);
    }
}