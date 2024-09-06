<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubTaskController;

Route::apiResource('/users', UserController::class);
Route::post('/login', [UserController::class, 'login']);

Route::group([ 'middleware' => 'auth:sanctum' ], function(){
    Route::group(['prefix' => '/friends'], function() {
        Route::post('/send-request', [UserController::class, 'sendFriendRequest']);
        Route::get('/pending-requests', [UserController::class, 'indexFriendRequests']);
        Route::get('/friends-requests', [UserController::class, 'indexFriendInvites']);
        Route::put('/accept-friend-request/{id}', [UserController::class, 'AcceptFriendRequest']);
        Route::get('/', [UserController::class, 'indexFriends']);
    });

    Route::apiResource('/board', BoardController::class);

    Route::put('/boards/{board}/invite-to-board',[BoardController::class, 'inviteUser']);
    Route::put('/boards/{board}/add-status',[BoardController::class, 'addStatus']);
    Route::get('/boards/im-in', [BoardController::class, 'boardsImIn']);
    Route::get('/members',[BoardController::class, 'indexBoardInvites']);
    Route::put('/members/{member}',[BoardController::class, 'acceptBoardInvite']);
    Route::put('/boards/{board}/remove/members/{member}',[BoardController::class, 'removeUser']);

    Route::apiResource('/statuses', StatusController::class);
    Route::apiResource('/tasks', TaskController::class);
    Route::put('/tasks/{task}/add-sub-task', [TaskController::class, 'addSubTask']);
    Route::apiResource('/sub-tasks',SubTaskController::class);
});





