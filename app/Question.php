<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $table = 'questions';
    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
