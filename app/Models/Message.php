<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'body', 'user_id', 'type'
    ];
    protected $hidden = ['conversation_id', 'deleted_at', 'user_id'
        , 'conversation_id', 'updated_at'];
    protected $appends=[];

    /**
     * @author Mahmoud Samy,
     *
     * @description get all users with relationship with message .
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @author Mahmoud Samy,
     *
     * @description get message created_at with specific format.
     */

//    public function getMessageCreatedAtAttribute(){
//        if ($this->created_at != null){
//            return $this->created_at->format('Y-M-d H:i:s');
//        }
//    }

}
