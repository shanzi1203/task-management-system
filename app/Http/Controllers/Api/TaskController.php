<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $tasks = $query->with('assignee')->latest()->get();

        return TaskResource::collection($tasks);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task = Task::create([
        ...$request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,completed,expired',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]),
        'status' => $request->input('status', 'pending'),
    ]);

        return new TaskResource($task);
    }
   
    //Assign a task to a user
    public function assign($id, Request $request)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task = Task::findOrFail($id);
        $task->assigned_to = $request->assigned_to;
        $task->save();

        return response()->json([
            'message' => 'Task assigned successfully.',
            'task' => new TaskResource($task),
        ]);
    }

    //Mark a task as completed

    public function complete($id)
    {
        $task = Task::findOrFail($id);
        $task->status = 'completed';
        $task->save();
        return response()->json([
            'message' => 'Task marked as completed',
            'task' => new TaskResource($task),
        ]);
    }
}
