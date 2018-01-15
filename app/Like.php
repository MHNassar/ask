<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $table = 'likes';
    protected $hidden = ['created_at', 'updated_at', 'id', 'question_id', 'user_id'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id')
            ->with('user')->with('category');
    }

}
