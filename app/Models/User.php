<?php

namespace App\Models;

use App\Like;
use App\Question;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Queue\SerializesModels;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token', 'created_at', 'updated_at'
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
}
