<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User; // Add this line to import the User class

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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Corresponds to private-user.{id}
Broadcast::channel('user.{id}', function (User $user, int $id) {
    Log::debug("EXECUTION INSIDE CHANNEL");
    Log::debug($user->toJson());
    Log::debug($id);
    Log::debug($user->id === $id);
    return $user->id === $id;
});
