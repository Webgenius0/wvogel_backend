<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('chat.{id}', function ($user, $id) {
    // return (int) $user->id === (int) $id;
    return true;
});

Broadcast::channel('group.{groupId}', function ($user, $groupId) {
    return true; // Allow all users (you can add authorization)
});
