<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function index()
    {
        $roomList = User::find(auth()->user()->id)->rooms()->get();
        return Inertia::render('Container', ['roomList' => $roomList]);
    }

    public function rand_color()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'period' => 'required',
        ]);

        if ($validator->fails()) {
            // return $this->sendError('Error validation', $validator->errors());
            return Inertia::render('Container', ['error' => $validator->errors()]);
        }


        $room_color = $this->rand_color();

        // dd($request->period);

        $room = new Room();
        $room->title = $request->title;
        $room->owner = Auth::user()->name;
        $room->password = $room_color;
        // $room->period - $request->period;
        $room->start_period = $request->period[0];
        $room->end_period = $request->period[1];
        $room->save();

        auth()->user()->rooms()->toggle($room->id);

        $roomList = auth()->user()->rooms();
        // dd($roomList);
        return Redirect::route('room.index');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'owner' => 'required',
            'period' => 'required',
        ]);

        if ($validator->fails()) {
            return Inertia::render('Container', ['error' => $validator->errors()]);
        }

        // $isUser = DB::table('users')->where('name', $request->owner);
        // if (!$isUser) {
        //     return Inertia::render('Container', ['error' => 'user nono']);
        // }

        $room = Room::find($id);
        $room->title = $request->title;
        $room->owner = $request->owner;
        $room->start_period = $request->period[0];
        $room->end_period = $request->period[1];
        $room->save();

        // $roomList = User::find(Auth::user()->id)->rooms();
        // dd($roomList);

        return Redirect::route('room.show', ['roomId' => $room->id]);
    }

    public function show($id)
    {
        // $chat = Room::find($id)->chats();
        // 수정 필요!!
        $room = Room::find($id);
        return Inertia::render('ChatRoom', ['room' => $room]);
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        $room->delete();
        $roomList = User::find(Auth::user()->id)->rooms()->get();
        return Inertia::render('Container', ['roomList' => $roomList]);
    }

    public function find(Request $request)
    {
        $isExist = DB::table('rooms')->where('password', $request->searchRoomPassword)->first();
        auth()->user()->rooms()->toggle($isExist->id);
        $roomList = User::find(Auth::user()->id)->rooms()->get();
        return Redirect::route('room.index');
    }
}
