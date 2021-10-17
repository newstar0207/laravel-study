<?php

namespace App\Http\Controllers\API;

use App\Events\UserOnline;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserStateController extends Controller
{
    public function __invoke($id, $state, $roomId) // 단일 동작 컨트롤러
    {
        $user = User::find($id);
        $user->state = $state;
        $user->save();



        broadcast(new User . $state($user, $roomId));
    }
}
