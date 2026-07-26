<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['category', 'user'])
            ->orderBy('priority','desc')
            ->orderBy('created_at','desc')
            ->get();

        return TaskResource::collection($tasks);
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['category','user']);

        return new TaskResource($task);
    }




}
