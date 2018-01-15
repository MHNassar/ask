<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public $table = 'answers';
    protected $hidden = ['created_at', 'updated_at'];

}
