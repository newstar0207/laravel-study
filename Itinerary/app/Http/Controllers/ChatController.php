<?php

namespace App\Http\Controllers;

use App\Events\DeleteChat;
use App\Events\NewChat;
use App\Models\Chat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;


class ChatController extends Controller
{
    public function index($roomId, $skip)
    {
        $chatListCount = Chat::where('room_id', $roomId)->count();
        if ($chatListCount <= $skip) {
            return response()->json(['message' => 'no more Chat...']);
        }

        $chatList = Chat::where('room_id', $roomId)->with('user')->orderBy('created_at', 'desc')->skip($skip)->take(13)->get();

        return response()->json($chatList);
    }

    public function store(Request $request, $roomId)
    {
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
            Image::make(public_path('/storage/images') . '/' . $newImageName)->fit(700, 700)->save();
            $url = asset('storage/images/' . $newImageName);
            $chat->image = $url;
        }
        $chat->save();


        $chat = Chat::where('id', $chat->id)->with('user')->first();
        broadcast(new NewChat($chat, $roomId));

        return response()->json($chat, 201);
    }

    public function destroy($chatId)
    {
        $chat = Chat::find($chatId);
        if ($chat->image) {
            $deleteImage = substr($chat->image, 37);
            Storage::delete('public/images/' . $deleteImage);
        }
        broadcast(new DeleteChat($chat, $chat->room_id))->toOthers();
        $chat->delete();

        return response()->json(201);
    }

    public function updateImageDesc(Request $request, $chatId)
    {
        // TODO : 권한

        $chat = Chat::find($chatId);
        if ($chat) {
            $chat->desc = $request->desc;
            $chat->save();
        }

        return Redirect::route('room.index');
    }
}
