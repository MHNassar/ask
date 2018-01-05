<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $table = 'likes';
    protected $hidden = ['created_at', 'updated_at'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
