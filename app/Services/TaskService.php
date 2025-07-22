<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendTaskAssignedEmail;



class TaskService
{
    public function listTask(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        return $query->with('assignee')->latest()->get();
    }
    public function createTask(Request $request)
    {
        return Task::create([
        ...$request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,completed,expired',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]),
        'status' => $request->input('status', 'pending'),
    ]);
    }
    public function assignTask($id, Request $request)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task = Task::findOrFail($id);
        $task->assigned_to = $request->assigned_to;
        $task->save();

        SendTaskAssignedEmail::dispatch($task);
        return $task;
    }
    public function completeTask($id)
    {
        $task = Task::findOrFail($id);
        $task->status = 'completed';
        $task->save();
        return $task;
    }
}