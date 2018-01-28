<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversationUser extends Model
{
    public $table = 'conversation_user';
    protected $hidden = ['updated_at', 'deleted_at', 'created_at'];
    protected $appends = [
        'user_name', 'user_photo'
    ];

    public function getUserNameAttribute()
    {
        return $this->user_name = User::find($this->user_id)->name;
    }

    public function getUserPhotoAttribute()
    {
        $photo = User::find($this->user_id)->photo;
        if ($photo != "") {
            $photo = url($photo);
        }
        return $photo;
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function conversationAccepted()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function conversationNotAccepted()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * @author Mahmoud Samy,
     *
     * @description get user information for each conversation user .
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
