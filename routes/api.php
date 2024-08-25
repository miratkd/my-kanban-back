<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardController;

Route::apiResource('/users', UserController::class);
Route::post('/login', [UserController::class, 'login']);

Route::group([ 'middleware' => 'auth:sanctum', 'prefix' => '/friends'], function(){
    Route::post('/send-request', [UserController::class, 'sendFriendRequest']);
    Route::get('/pending-requests', [UserController::class, 'indexFriendRequests']);
    Route::get('/friends-requests', [UserController::class, 'indexFriendInvites']);
    Route::put('/accept-friend-request/{id}', [UserController::class, 'AcceptFriendRequest']);
    Route::get('/', [UserController::class, 'indexFriends']);
});


Route::apiResource('/board', BoardController::class)->middleware(['auth:sanctum']);
Route::put('/boards/{board}/invite-to-board',[BoardController::class, 'inviteUser'])->middleware(['auth:sanctum']);
Route::get('/members',[BoardController::class, 'indexBoardInvites'])->middleware(['auth:sanctum']);
Route::put('/members/{member}',[BoardController::class, 'acceptBoardInvite'])->middleware(['auth:sanctum']);
