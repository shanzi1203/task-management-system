<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedMail;


class SendTaskAssignedEmail implements ShouldQueue
{
    use Queueable, Dispatchable,InteractsWithQueue,SerializesModels;

    public $task;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
    $this->task=$task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->task->assignee;
        if ($user) {
            Mail::to($user->email)->send(new TaskAssignedMail($this->task));
        }
    }
}
