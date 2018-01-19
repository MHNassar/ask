<?php

namespace App\Models;

use App\Category;
use App\Like;
use App\Question;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'biography', 'photo', 'type', 'category_id'
    ];

    protected $appends = ['questions_count'];

    protected $primaryKey = 'id';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token', 'created_at', 'updated_at', 'category_id', 'type'
    ];

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id', 'id');
    }

    public function questionsWithOutAnswer()
    {
        return $this->hasMany(Question::class, 'user_id', 'id')
            ->with('category')->with('answer')->whereDoesntHave("answer");
    }

    public function questionsWithAnswer()
    {
        return $this->hasMany(Question::class, 'user_id', 'id')
            ->with('category')->with('answer')->wherehas('answer');
    }



    public function getQuestionsCountAttribute()
    {
        return Question::where('user_id', $this->id)->count();
    }


    protected function getArrayableItems(array $values)
    {
        if ($this->category_id) {
            array_push($this->appends, 'category');
        }
        return parent::getArrayableItems($values);

    }


    public function getCategoryAttribute()
    {
        $category = Category::find($this->category_id);
        if ($category) {
            return $category->name;
        } else {
            return null;
        }
    }


}
