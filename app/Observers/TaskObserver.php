<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\TaskHistory;
use Carbon\Carbon;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        TaskHistory::factory()->created($task)->create();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $changes = $task->getChanges();
        if (isset($changes['deadline'])) {
            $changes['deadline'] = Carbon::parse($changes['deadline'])->toIso8601String();
        }

        TaskHistory::factory()->updated($task, $changes)->create();
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        TaskHistory::factory()->deleted(
            $task,
            ['deleted_at' => Carbon::parse($task->deleted_at)->toIso8601String()],
        )->create();
    }
}
