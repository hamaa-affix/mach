<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{    
    //chatRoom,chatMessagesそれぞれ１対多の関係を示す。
     public function chatRoomUsers()
    {
        return $this->hasMany('App\ChatRoomUser');
    }

    public function chatMessages()
    {
        return $this->hasMany('App\ChatMessage');
    }
}
