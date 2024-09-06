<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\StoreSubTaskRequest;
use App\Http\Resources\taskResource;
use App\Models\Status;
use App\Models\Task;
use App\Models\SubTask;

class TaskController
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
    public function store(StoreTaskRequest $request)
    {
        $task = $request->all();
        if (!$request->input('description')) $task['description'] = '--';
        $task['status_id'] = $task['statusId'];
        return new taskResource(Task::create($task));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $newStatus = Status::find($request['statusId']);
        if (!$newStatus) return response()->json(['message'=>'new status not found'], 404);
        if ($task->status()->first()->board()->first()->id != $newStatus->board()->first()->id) return response()->json(['message'=>'status not valid'], 400);
        $task->status_id = $newStatus->id;
        $task->save();
        return new taskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UpdateTaskRequest $request, Task $task)
    {
        $task->delete();
        return response()->json(['message'=>'Task deleted'], 200);
    }

    public function addSubTask(StoreSubTaskRequest $request, Task $task)
    {
        $subTask = new SubTask();
        $subTask->task_id = $task->id;
        $subTask->text = $request['text'];
        $subTask->save();
        return response()->json(['message'=>'SubTask added'], 200);
    }
}
