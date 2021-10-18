<?php

namespace App\Http\Controllers\API;

use App\Events\UserOffline;
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

        if ($state == 'Online') {
            broadcast(new UserOnline($user, $roomId));
        }
        if ($state == 'Offline') {
            broadcast(new UserOffline($user, $roomId));
        }
    }
}
