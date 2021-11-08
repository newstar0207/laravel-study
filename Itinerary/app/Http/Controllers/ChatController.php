<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index($roomId)
    {
        $chatList = Room::find($roomId)->chats();
        return Inertia::render('ChatRoom', ['chats' => $chatList]);
    }

    public function store(Request $request, $roomId)
    {
        $validator = Validator::make($request->all(), [
            'chat' => 'required',
        ]);

        if ($validator->fails()) {
            return Inertia::render('ChatRoom', ['error' => $validator->errors()]);
        }

        $chat = new Chat;
        $chat->chat = $request->chat;
        $chat->user_id = Auth::user()->id;
        $chat->room_id = $roomId;
        if ($chat->image) {
            $chat->image = $request->image;
        }
        $chat->save();

        return Redirect::route('chat.index');
    }

    public function destroy($chatId)
    {
        $chat = Chat::find($chatId);
        $chat->delete();

        return Redirect::route('chat.index');
    }
}
