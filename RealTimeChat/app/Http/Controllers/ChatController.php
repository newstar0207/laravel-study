<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function rooms()
    {
        // 채팅방 리스트 리턴
    }

    public function messages($roomId)
    {
        // 특정 채팅방의 메시지 리스트 리턴
    }

    public function newMessage(Request $request, $roomId)
    {
        // 새로운 메시지 저장
    }
}
