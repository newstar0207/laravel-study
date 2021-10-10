<?php

namespace App\Http\Controllers\API;

use App\Events\RoomCreated;
use App\Models\ChatRoom;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatRoomController extends BaseController
{
    public function index()
    {
        return ChatRoom::all();
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $room = new ChatRoom;
        $room->title = $request->title;
        $room->owner = Auth::user()->name;
        $room->save();
        $success['room'] = $room;


        // 이벤트를 같은 채널의 다른 사용자에게 브로드캐스트
        // broadcast(new RoomCreated($room))->toOthers();

        return $this->sendResponse($success, 'created new ChatRoom');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'owner' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $room = ChatRoom::find($id);
        $room->title = $request->title;
        $room->owner = $request->owner;
        $room->save();
        $success['room'] = $room;

        return $this->sendResponse($success, 'updated new ChatRoom');
    }

    public function destroy($id)
    {
        $room = ChatRoom::find($id);
        $room->delete();

        return $this->sendResponse(null, 'created new ChatRoom');
    }

    // public function show($id)
    // {
    //     $chat = ChatRoom::find($id)->chats();

    //     return $this->sendResponse($chat, 'room chat');
    // }
}
