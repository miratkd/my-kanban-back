<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Requests\StatusOwnerRequest;
use App\Http\Resources\FullBoardResource;
use App\Models\Status;

class StatusController
{

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        if ($request['position'] < 0) return response()->JSON(['message'=>'You can not set a negative index'],422);
        if ($request['position'] == $status->position) return response()->JSON(['message'=>'Please choose a diferent position'],422);
        $statuses = $status->board()->first()->statuses()->get();
        if ($request['position'] > count($statuses) - 1) return response()->JSON(['message'=>'Index out of array'],422);
        foreach ($statuses as $listStatus) {
            if ($listStatus->id != $status->id ){
                if ($listStatus->position >= $request['position'] && $listStatus->position < $status->position){
                   $listStatus->position++;
                    $listStatus->save();
                }
                else if ($listStatus->position <= $request['position'] && $listStatus->position > $status->position){
                   $listStatus->position--;
                    $listStatus->save();
                }
                
            } else {
                $listStatus->position = $request['position'];
                $listStatus->save();
            }
        }
        return new FullBoardResource($status->board()->first());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusOwnerRequest $request, Status $status)
    {
        $status->delete();
        return response()->json(['message' => 'status deleted'], 200);

    }
}
