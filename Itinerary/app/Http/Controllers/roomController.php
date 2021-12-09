<?php

namespace App\Http\Controllers;

use App\Events\AddSchedule;
use App\Events\CheckUser;
use App\Events\DeleteSchedule;
use App\Events\UpdateCost;
use App\Events\UpdateRoom;
use App\Models\Chat;
use App\Models\Cost;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function index()
    {
        $roomList = User::find(auth()->user()->id)->rooms()->get();
        $chatImage = Chat::where('image', '!=', 'null')->with('room')->get();

        return Inertia::render('Container', ['roomList' => $roomList, 'chatImage' => $chatImage]);
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

        $cost = new Cost();
        $cost->room_id = $room->id;
        $cost->save();

        return response()->json(['room' => $room]);
    }

    public function update(Request $request, $roomId)
    {
        $room = Room::find($roomId);

        if (!Gate::allows('update-request', $room)) {
            return response()->json(['message' => 'you are not owner'], 400);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'owner' => 'required',
            'period' => 'required',
        ]);

        if ($validator->fails()) {
            return Inertia::render('Container', ['error' => $validator->errors()]);
        }

        $room->title = $request->title;
        $room->owner = $request->owner;
        $room->start_period = $request->period[0];
        $room->end_period = $request->period[1];
        $room->save();

        broadcast(new UpdateRoom($room, $roomId));

        return response()->json($room);
    }

    public function show($roomId)
    {

        $room = Room::where('id', $roomId)->with('cost')->get();

        return Inertia::render('ChatRoomContainer', ['room' => $room]);
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
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        // 이미 가입되어있는 사용자 한번더 하면 없어짐 어칼지 생각할것
        // 수정필요

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $isExist = DB::table('rooms')->where('password', $request->password)->first();

        if ($isExist) {
            auth()->user()->rooms()->toggle($isExist->id);
            // return response()->json(['room' => $isExist], 200);
            $message = true;
            return Redirect::route('room.index', $message);
        } else {
            $message = false;
            return Redirect::route('room.index', $message);
            // return response()->json(['message' => 'error'], 400);
        }
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

        broadcast(new AddSchedule($schedule, $schedule->room_id));

        return response()->json(['message' => 'complete']);
    }


    public function getSchedule($roomId)
    {
        $schedules = Room::find($roomId)->schedules();
        return response()->json($schedules);
    }

    public function completeSchedule($roomId, $scheduleId)
    {
        // $validator = Validator::make($request->all(), [
        //     'iscomplete' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors());
        // }

        $schedule = Schedule::find($scheduleId);
        $schedule->iscomplete = true;
        $schedule->save();

        return response()->json($schedule);
    }

    public function userBan($roomId, $userId)
    {

        $user = User::find($userId);

        $user->rooms()->toggle($roomId);

        broadcast(new CheckUser($userId, $roomId));

        $room = Room::find($roomId);
        if ($room) {
            $room->password = $this->rand_color();
            $room->save();
        }

        // password 바꾸기 위함
        broadcast(new UpdateRoom($room, $room->id));

        return response()->json(['message' => 'complete...']);
    }

    public function deleteSchedule($roomId, $scheduleId)
    {
        $schedule = Schedule::find($scheduleId);
        // dd($schedule);
        $schedule->delete();

        broadcast(new DeleteSchedule($roomId, $scheduleId));

        return response()->json(['message' => 'complete']);
    }


    public function updateCost(Request $request, $roomId)
    {
        $room = Room::find($roomId);

        if (!Gate::allows('update-request', $room)) {
            return response()->json(['message' => 'you are not owner'], 400);
        }

        $validator = Validator::make($request->all(), [
            'room_cost' => 'required',
            'food_cost' => 'required',
            'other_cost' => 'required',
            'tran_cost' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $cost = Cost::where('room_id', $roomId)->first();
        $cost->food_cost = (int)$request->food_cost;
        $cost->room_cost = (int)$request->room_cost;
        $cost->tran_cost = (int)$request->tran_cost;
        $cost->other_cost = (int)$request->other_cost;
        $cost->room_id = $roomId;

        $sum = $cost->food_cost + $cost->room_cost + $cost->tran_cost + $cost->other_cost;
        $cost->sum_cost = $sum;
        $cost->save();

        broadcast(new UpdateCost($cost, $roomId));

        return response()->json($cost);
    }

    public function getRoom($roomId)
    {
        $room = Room::find($roomId);

        return response()->json($room);
    }

    public function checkUser($roomId, $userId)
    {
        if (Auth::user()->id == $userId) {
            // return Redirect::route('room.index');r
            return Redirect::route('room.index');
        } else {
            // return response()->json(['message' => 'complete']);
            return Redirect::route('room.show', $roomId);
        }
    }
}
