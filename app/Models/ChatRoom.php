<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    // protected $with = ['chatuser'];

    public function messages() {
        return $this->hasMany(ChatMessage::class);
    }

    public function chatuser()
    {
        return $this->belongsToMany(User::class);
    }
}
