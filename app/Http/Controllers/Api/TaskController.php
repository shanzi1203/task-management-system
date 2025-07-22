<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Jobs\SendTaskAssignedEmail;
use App\Services\TaskService;


class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
    $this->taskService=$taskService; 
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->listTask($request);
        return TaskResource::collection($tasks);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task =$this->taskService->createTask($request);
        return new TaskResource($task);
    }

    //Assign a task to a user
    public function assign($id, Request $request)
    {
        $task = $this->taskService->assignTask($id, $request);
        return response()->json([
            'message' => 'Task assigned successfully.',
            'task' => new TaskResource($task),
        ]);
    }

    //Mark a task as completed

    public function complete($id)
    {
        $task = $this->taskService->completeTask($id);
        
        return response()->json([
            'message' => 'Task marked as completed',
            'task' => new TaskResource($task),
        ]);
    }
}
