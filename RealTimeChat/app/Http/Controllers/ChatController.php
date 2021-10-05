<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        return Inertia::render( /* 뷰 파일 이름*/'Chat/container');
    }



    public function rooms()
    {
        // 채팅방 리스트 리턴
        return ChatRoom::all();
    }

    public function messages($roomId)
    {
        // 특정 채팅방의 메시지 리스트 리턴
        $msgs = ChatMessage::where('chat_room_id', $roomId)->with('user')->latest()->get();
        // lazy loading -> 접근할때 데이터를 가져옴 VS eager loading

        // lazy loading
        // $msgs[0]->user->name;

        return $msgs;
    }

    public function newMessage(Request $request, $roomId)
    {
        $request->validate(['message' => 'required']);

        // 새로운 메시지 저장
        $message = ChatMessage::create([
            'chat_room_id' => $roomId,
            'user_id' => Auth::user()->id, // auth() ->helper 함수
            'message' => $request->message,
        ]);

        return $message;
    }
}
