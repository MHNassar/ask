<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class User
 * @package App\Models
 * @version January 15, 2018, 2:32 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Answer
 * @property \Illuminate\Database\Eloquent\Collection Like
 * @property \Illuminate\Database\Eloquent\Collection Question
 * @property string name
 * @property string email
 * @property string password
 * @property string phone
 * @property string biography
 * @property string photo
 * @property string remember_token
 * @property string token
 */
class User extends Model
{

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'biography',
        'photo',
        'remember_token',
        'token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'phone' => 'string',
        'biography' => 'string',
        'photo' => 'string',
        'remember_token' => 'string',
        'token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function answers()
    {
        return $this->hasMany(\App\Models\Answer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }
}
