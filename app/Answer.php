<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public $table = 'answers';
    protected $hidden = ['created_at', 'updated_at'];

    public function answersUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
