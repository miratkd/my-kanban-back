<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubTaskRequest;
use App\Http\Requests\UpdateSubTaskRequest;
use App\Http\Requests\UpdateSubTaskCheckRequest;
use App\Models\SubTask;

class SubTaskController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreSubTaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SubTask $subTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubTask $subTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubTaskCheckRequest $request, SubTask $subTask)
    {
        $subTask->isCheck = $request['check'];
        $subTask->save();
        return response()->json(['message'=>'subTask updated'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubTask $subTask, UpdateSubTaskRequest $request)
    {
        $subTask->delete();
        return response()->json(['message'=>'subTask deleted'],200);
    }
}
