<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Support\Collection;

class TaskHistoryService
{
    /**
     * Get task history.
     *
     * @return Collection<int, TaskHistory>
     */
    public function getTaskHistory(Task $latestTask): Collection
    {
        return TaskHistory::where('task_id', $latestTask->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
