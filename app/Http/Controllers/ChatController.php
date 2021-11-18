<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function rooms() {
        $rooms = ChatRoom::all();
        return Inertia::render('Chats/MyChatList', ['rooms' => $rooms]);
    }

    public function room($roomId) {
        return Inertia::render('Chats/ShowChat', ['roomId' => $roomId]);
    }

    public function messages($roomId) {
        $messages = ChatMessage::where('chat_room_id', $roomId)->with('user')->get();
        // return Inertia::render('Chats/ShowChat', ['messages' => $messages, 'roomId' => $roomId]);
        return $messages;
    }

    public function newMessage(Request $request, $roomId) {
        $newMessage = new ChatMessage;
        $newMessage->user_id = Auth::id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();

        // return Redirect::route('chat.room', ['roomId' => $roomId]);
        return $newMessage;
    }
}
