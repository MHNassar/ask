<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Twitte
 * @package App\Models
 * @version January 17, 2018, 12:40 pm UTC
 *
 * @property string body
 */
class Twitte extends Model
{

    public $table = 'twittes';
    


    public $fillable = [
        'body'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'body' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
