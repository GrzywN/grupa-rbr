<?php

namespace App\Jobs;

use App\Models\Task;
use App\Notifications\TaskDueNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Notification;

class SendTaskDueNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Task $task)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::send($this->task->user, new TaskDueNotification($this->task));
    }
}
