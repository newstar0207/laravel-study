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

    public function rand_color()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        // 1. 테이블을 하나 더 만들어 기록함! -> 검색해서 들어감 -> 암호입력 -> 암호맞으면 디비에 저장 -> 다음에 프린트 all 해서 씀 -> 굳
        // 2. 프린트 할때 만든 테이블 리스트를 프린트함!

        // 0. hex code로 검색(room_color, string) -> 결과에 맞는 방 나옴 -> 클릭해서 입장
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $room_color = $this->rand_color();

        $room = new ChatRoom;
        $room->title = $request->title;
        $room->owner = Auth::user()->name;
        $room->room_color = $room_color;
        $room->save();
        $success['room'] = $room;

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

    public function show($id)
    {
        // hex code로 검색(room_color, string) -> 결과에 맞는 방 나옴 -> return 해주고 프런트에서 입장
    }
}
