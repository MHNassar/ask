<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $table = 'questions';
    protected $hidden = ['updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function answer()
    {
        return $this->hasOne(Answer::class, 'question_id', 'id')->with('answersUser');
    }


}
