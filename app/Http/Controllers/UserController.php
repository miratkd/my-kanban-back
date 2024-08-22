<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\SendFriendRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\FriendResource;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;


class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json('Method is not supported for this route',405);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $response = new UserResource(User::create($request->all()));
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(LoginRequest $request){
        $credentials = json_decode($request->getContent(), true);
        if (Auth::attempt($credentials)){
            /** @var \App\Models\MyUserModel $user **/
            $user = Auth::user();
            return response()->json([
                'message' => 'Token created',
                'type' => 'Bearer',
                'token' => $user->createToken('user-token', [], now()->addHours(6))->plainTextToken,
                'duration' => '6 hours'
            ], 201);
        }
        return response()->json(['error' => 'Wrong credentials'],403);
    }

    public function sendFriendRequest (SendFriendRequest $request) {
        $friend = User::findOrFail($request['friend']);
        Friend::create(['user_id' => $request->user()->id, 'friend_id' => $friend->id]);
        return Response()->json(['message'=>'Invite send'], 200);
    }

    public function indexFriendRequests (Request $request) {
        return FriendResource::collection($request->user()->pendingFriendsTo()->paginate(50));
    }

    public function indexFriendInvites (Request $request) {
        return FriendResource::collection($request->user()->pendingFriendsFrom()->paginate(50));
    }

    public function indexFriends (Request $request) {
        return FriendResource::collection($request->user()->friends()->paginate(50));
    }

    public function AcceptFriendRequest(string $id, Request $request) {
        $friendRequest = Friend::where('user_id', $id)->where('friend_id',$request->user()->id)->first();
        if (!$friendRequest) return response()->json(['error' => 'Sorry, there is no friend request for this user'],403);
        $friendRequest->accepted = 1;
        $friendRequest->save();
        return response()->json(['message' => 'Friend request accepted'],201);
    }
}
