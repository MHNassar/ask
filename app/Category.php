<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categories';
    protected $hidden = ['created_at', 'updated_at'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'category_id', 'id');

    }
}
