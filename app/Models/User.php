<?php

namespace App\Models;

use App\Answer;
use App\Category;
use App\Like;
use App\Question;
use App\UserDevices;
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
        'name', 'email', 'password', 'phone', 'biography', 'photo', 'type', 'years_count', 'study'
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

    public static $rules = [];

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'user_id', 'id');
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
        if ($this->type == 0) {
            return Question::where('user_id', $this->id)->count();
        } else {
            return Question::where('category_id', $this->category_id)->count();

        }
    }


    protected function getArrayableItems(array $values)
    {

        if ($this->type == 0) {
            array_push($this->hidden, 'years_count', 'study');

        }
        return parent::getArrayableItems($values);

    }


    public function device()
    {
        return $this->hasOne(UserDevices::class, 'user_id', 'id');
    }

    public function conversationsNotApproved()
    {
        if ($this->type = 0) {
            return $this->belongsToMany(Conversation::class)->where('approved', 0)
                ->orderBy('created_at', 'DESC');
        } else {
            $userCategoriesIds = $this->categories()->pluck('category_id');
            dd($userCategoriesIds);
            return $this->belongsToMany(Conversation::class)->where('approved', 0)
                ->whereIn('category_id', $userCategoriesIds)
                ->orderBy('created_at', 'DESC');
        }


    }

    public function conversationsApproved()
    {
        return $this->belongsToMany(Conversation::class)->where('approved', 1)
            ->orderBy('created_at', 'DESC');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_categories');
    }

}
