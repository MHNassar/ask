<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingKind extends Model
{
    public $table = 'buildings';
    protected $hidden = ['created_at', 'updated_at'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'building_id', 'id');

    }
}
