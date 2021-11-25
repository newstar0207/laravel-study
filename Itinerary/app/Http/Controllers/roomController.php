<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Room;
use App\Models\Schedule;
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

        $room = Room::find($id);
        $room->title = $request->title;
        $room->owner = $request->owner;
        $room->start_period = $request->period[0];
        $room->end_period = $request->period[1];
        $room->save();

        return response()->json($room);
    }

    public function show($roomId)
    {
        // $chat = Room::find($id)->chats();
        // 수정 필요!!
        $room = Room::find($roomId);
        // $chatList = Chat::where('room_id', $roomId)->paginate(5)->get();
        return Inertia::render('ChatRoom', ['room' => $room]);
        // return Inertia::render('ChatRoom', ['room' => $room]);
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        $roomList = User::find(Auth::user()->id)->rooms()->get();

        if ($room->owner != Auth::user()->id) {
            return Inertia::render('Container', ['roomList' => $roomList, 'error' => 'your not owner...']);
        }

        $room->delete();
        return Inertia::render('Container', ['roomList' => $roomList]);
    }

    public function find(Request $request)
    {
        $isExist = DB::table('rooms')->where('password', $request->searchRoomPassword)->first();
        auth()->user()->rooms()->toggle($isExist->id);
        $roomList = User::find(Auth::user()->id)->rooms()->get();
        return Redirect::route('room.index');
    }

    public function addSchedule(Request $request, $roomId)
    {
        $validator = Validator::make($request->all(), [
            'schedule' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $schedule = new Schedule();
        $schedule->schedule = $request->schedule;
        $schedule->date = $request->date;
        $schedule->room_id = $roomId;
        $schedule->save();
    }


    public function getSchedule($roomId)
    {
        $schedules = Room::find($roomId)->schedules();
        return response()->json($schedules);
    }

    public function completeSchedule(Request $request, $scheduleId)
    {
        $validator = Validator::make($request->all(), [
            'iscomplete' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $schedule = Schedule::find($scheduleId);
        $schedule->iscomplete = true;
        $schedule->save();
    }

    public function userBan(Room $room, User $user)
    {
        $user->rooms()->toggle($room->id);
        $userList = $room->users();

        $room->password = $this->rand_color();
        $room->save();

        if (Auth::user()->id == $user->id) {
            return route('room.index');
        }
        return response()->json($userList);
    }
}
