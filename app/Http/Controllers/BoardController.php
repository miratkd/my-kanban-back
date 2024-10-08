<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Http\Requests\ShowBoardRequest;
use App\Http\Requests\BorderOwnerRequest;
use App\Http\Requests\InviteToBoardRequest;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\RemoveMemberRequest;
use App\Models\Board;
use App\Models\Member;
use App\Models\User;
use App\Models\Status;
use App\Http\Resources\BoardResource;
use App\Http\Resources\FullBoardResource;
use App\Http\Resources\BoardInviteResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BoardController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return BoardResource::collection(Board::where('user_id', $request->user()->id)->paginate(50));
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
    public function store(StoreBoardRequest $request)
    {
        $board = new Board();
        $board->title = $request['title'];
        $board->description = $request['description'];
        $board->user_id = $request->user()->id;
        $board->save();
        $board->initStatuses();
        return new FullBoardResource($board);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board, ShowBoardRequest $request)
    {
        return new FullBoardResource($board);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request, Board $board)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board, BorderOwnerRequest $request)
    {
        $board->delete();
        return response()->json(['message' => 'Board deleted'], 200);
    }

    public function inviteUser(InviteToBoardRequest $request, Board $board) {
        $memberInvite = new Member();
        $memberInvite->board_id = $board->id;
        $isfriend = $request->user()->friends()->where('email',$request['user'])->first();
        if ($isfriend) {
            $memberInvite->user_id = $isfriend->id;
            $memberInvite->accepted = true;
            $memberInvite->save();
            return response()->json(['message' => 'User added to the board'], 200);
        } else {
            $memberInvite->user_id = User::where('email',$request['user'])->first()->id;
            $memberInvite->save();
            return response()->json(['message' => 'Invite send'], 200);
        }   
    }

    public function indexBoardInvites (Request $request) {
        return BoardInviteResource::collection(Member::where('user_id', $request->user()->id)->where('accepted', false)->paginate(50));
    }

    public function acceptBoardInvite(Member $member, Request $request) {
        if ($request->user()->id != $member->user_id) return response()->json(['message' => 'You can not accept this invite'], 403);
        $member->accepted = true;
        $member->save();
        return response()->json(['message' => 'Invite accepted'], 200);
    }

    public function removeUser(RemoveMemberRequest $request, Board $board, Member $member) {
        $member->delete();
        return response()->json(['message' => 'Member remove from the board'], 200);
    }

    public function addStatus(Board $board, StoreStatusRequest $request) {
        $newStatus = new Status();
        $newStatus->title = $request['title'];
        $newStatus->color = $request['color'];
        $newStatus->position = $board->statuses()->count();
        $newStatus->board_id = $board->id;
        $newStatus->save();
        return new FullBoardResource($board);
    }

    public function boardsImIn (Request $request){
        $list = Board::whereHas('members', function (Builder $query) use ($request) {
            $query->where('user_id', $request->user()->id)->where('accepted', true);
        })->paginate(50);
        return BoardResource::collection($list);
    }
}
