<?php

namespace App\Http\Controllers\API;

use App\Events\NewChat;
use App\Events\RoomCreated;
use App\Models\Chat;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends BaseController
{
    public function index($id)
    {
        $chats = ChatRoom::find((int)$id)->chats;
        return $this->sendResponse($chats, 'all Chats');
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'chat' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validator at chat', $validator->errors());
        }

        $chat = new Chat;
        $chat->chat = $request->chat;
        $chat->user_id = Auth::user()->id;
        $chat->chat_room_id = $id;
        $chat->save();

        $user = Auth::user();

        broadcast(new NewChat($chat, $id, $user))->toOthers();

        return $this->sendResponse($chat, 'created new Chat...');
    }
}
