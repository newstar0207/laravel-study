<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat-room.{roomId}', function ($user, $roomId) {
    // if ($user->canJoinRooms($roomId)) {
    // return ['id' => $user->id, 'name' => $user->name, 'roomId' => $roomId];
    // }
    // return ['id' => $user->id, 'roomId' => $roomId];
    if (Auth::check()) {
        return ['id' => $user->id, 'name' => $user->name, 'roomId' => $roomId, 'profile_photo_path' => $user->profile_photo_path];
    }
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
