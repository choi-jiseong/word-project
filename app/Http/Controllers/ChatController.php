<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class ChatController extends Controller
{
    public function rooms() {
        $rooms = auth()->user()->chatroom;
        $users = [];
        // dd($rooms[0]->pivot);
        dd(DB::table('chat_room_user')->select('user_id')->where('chat_room_id', $rooms[0]->pivot->chat_room_id)->get());
        // for($i = 0; $i < $rooms->count(); $i++) {
        //     $user = User::
        // }
        // dd(auth()->user()->chatroom);
        return Inertia::render('Chats/MyChatList', ['rooms' => $rooms]);
    }

    public function createRoom(Request $request) {
        // dd($request->chatUserId);
        // $chatUser = $request->chatUser;
        // dd(auth()->user());
        $chatUserId = $request->chatUserId;
        $chatUser = User::find($chatUserId);
        // dd($chatUser);
        $chatrooms = DB::table('chat_room_user')->select('chat_room_id')->whereIn('user_id', [auth()->user()->id, $chatUserId])->get();
        // dd($chatrooms->count());
        // dd($chatrooms);
        $roomId = $chatrooms[0]->chat_room_id;
        for ($i = 1; $i < $chatrooms->count(); $i++) {
            // dd($roomId  ==$chatrooms[$i]->chat_room_id);
            if ($roomId == $chatrooms[$i]->chat_room_id){
                $roomId = $chatrooms[$i]->chat_room_id;
                // return Inertia::render('Chats/ShowChat', ['roomId' => $roomId]);
                // dd(1);
                return Redirect::route('chat.room', [(int)$roomId]);
            }
            $roomId = $chatrooms[$i]->chat_room_id;
        }
        $room = new ChatRoom();
        $room -> save();

        auth()->user()->chatroom()->attach($room->id);
        $chatUser->chatroom()->attach($room->id);
        // dd(1);
        // return Inertia::render('Chats/ShowChat', ['roomId' => $room->id]);
        return Redirect::route('chat.room', [$room->id]);
        // return 2;

    }

    public function room($roomId) {

        $row = DB::table('chat_room_user')->where('user_id', auth()->user()->id)->where('chat_room_id', $roomId)->first();
        if(!$row) {
            auth()->user()->chatroom()->attach($roomId);
        }
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

        broadcast(new NewChatMessage($newMessage))->toOthers();

        // return Redirect::route('chat.room', ['roomId' => $roomId]);
        return $newMessage;
    }
}
