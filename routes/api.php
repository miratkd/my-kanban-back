<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::apiResource('/users', UserController::class);
Route::post('/login', [UserController::class, 'login']);

Route::group([ 'middleware' => 'auth:sanctum', 'prefix' => '/friends'], function(){
    Route::post('/send-request', [UserController::class, 'sendFriendRequest']);
    Route::get('/pending-requests', [UserController::class, 'indexFriendRequests']);
    Route::get('/friends-requests', [UserController::class, 'indexFriendInvites']);
    Route::put('/accept-friend-request/{id}', [UserController::class, 'AcceptFriendRequest']);
    Route::get('/', [UserController::class, 'indexFriends']);
});



