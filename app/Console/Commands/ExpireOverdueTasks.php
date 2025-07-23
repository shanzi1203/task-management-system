<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Task;


class ExpireOverdueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-overdue-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark all pending tasks with a past due date as expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Task::where('status', 'pending')
            ->whereDate('due_date', '<', Carbon::today())
            ->update(['status' => 'expired']);

        $this->info("{$count} task(s) marked as expired.");
    }
}
