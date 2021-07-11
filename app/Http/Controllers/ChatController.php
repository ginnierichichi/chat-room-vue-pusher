<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use http\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function rooms(Request $request)
    {
        return ChatRoom::all();
    }

    public function messages(Request $request, $roomId)
    {
        return ChatMessage::where('chat_room_id', $roomId)->with('user')->orderBy('created_at', 'desc')->get();
    }

    public function newMessage(Request $request, $roomId)
    {
        $newMessage = new ChatMessage();

        $newMessage->user_id = auth()->id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;

        $newMessage->save();

        broadcast(new NewChatMessage( $newMessage))->toOthers();

        return $newMessage;
    }
}
