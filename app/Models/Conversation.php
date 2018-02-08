<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    public $table="conversations";
    protected $hidden = ['pivot', 'updated_at', 'deleted_at'];
    protected $appends=['last_message_body', 'last_message_date'];
    protected $dates = ['created_at','deleted_at'];


    /**
     * @author Mahmoud Samy,
     *
     * @description get conversation users .
     */
    public function users(){
        return $this->hasMany(ConversationUser::class, 'conversation_id', 'id');
    }


    /**
     * @author Mahmoud Samy,
     *
     * @description get conversation users directly from Users table.
     */

    public function usersFilter(){
        return $this->belongsToMany(User::class,'conversation_user');
    }

    /**
     * @author Mahmoud Samy,
     *
     * @description get conversation created_at with specific format.
     */

//    public function getConversationCreatedAtAttribute(){
//        return $this->created_at->format('Y-M-d H:i:s');
//    }

    /**
     * @author Mahmoud Samy,
     *
     * @description get conversation last message body .
     */
    public function getLastMessageBodyAttribute(){
        $lastMessageBody = Message::where('conversation_id',$this->id)->get()->last();
        if ($lastMessageBody){
            return $lastMessageBody->body;
        }else{
            return "";
        }
    }

    /**
     * @author Mahmoud Samy,
     *
     * @description get conversation last message date .
     */
    public function getLastMessageDateAttribute(){
        $lastMessageDate = Message::where('conversation_id',$this->id)->get()->last();
        if ($lastMessageDate){
            return $lastMessageDate->created_at->toDateTimeString();
        }else{
            return "";
        }
    }



    /**
     * @author Mahmoud Samy,
     *
     * @description get conversation messages .
     */

    public function messages(){
        return $this->hasMany(Message::class, 'conversation_id', 'id')->orderBy('created_at','DESC');
    }

    public function lastMessages(){
        return $this->hasMany(Message::class, 'conversation_id', 'id')->orderBy('created_at','DESC');
    }

}
