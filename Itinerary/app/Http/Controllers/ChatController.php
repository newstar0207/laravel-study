<?php

namespace App\Http\Controllers;

use App\Events\DeleteChat;
use App\Events\NewChat;
use App\Models\Chat;
use App\Models\Room;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index($roomId)
    {
        // $chatList = Room::find($roomId)->chats();
        // $chatList = Room::find($roomId)->chats;
        $chatList = Chat::where('room_id', $roomId)->latest()->get();
        // dd($chatList);
        return Inertia::render('ChatRoom', ['chatList' => $chatList]);
    }

    public function store(Request $request, $roomId)
    {
        // dd($request->hasFile('image'));

        $validator = Validator::make($request->all(), [
            'chat' => 'required_if:$request->image,==,false',
            'image' => 'required_if:$request->chat,==,false',
        ]);

        if ($validator->fails()) {
            return Inertia::render('ChatRoom', ['error' => $validator->errors()]);
        }
        $chat = new Chat;
        $chat->chat = $request?->chat;
        $chat->user_id = Auth::user()->id;
        $chat->room_id = $roomId;
        if ($request->hasFile('image')) {
            $newImageName = time() . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('/storage/images'), $newImageName);
            $url = asset('storage/images/' . $newImageName);
            $chat->image = $url;
        }
        $chat->save();

        broadcast(new NewChat($chat, $chat->room_id))->toOthers();

        return response()->json($chat, 201);
    }

    public function destroy($chatId)
    {
        $chat = Chat::find($chatId);
        $roomId = $chat->room_id;
        if ($chat->image) {
            $deleteImage = substr($chat->image, 37);
            Storage::delete('public/images/' . $deleteImage);
        }
        broadcast(new DeleteChat($chat, $chat->room_id))->toOthers();

        $chat->delete();

        return response()->json(201);
    }
}
