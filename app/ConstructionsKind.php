<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstructionsKind extends Model
{
    public $table = 'constructions';
    protected $hidden = ['created_at', 'updated_at'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'construction_id', 'id');

    }
}
