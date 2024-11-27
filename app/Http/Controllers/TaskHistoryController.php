<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskHistoryResource;
use App\Models\Task;
use App\Services\TaskHistoryService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;

class TaskHistoryController extends Controller
{
    public function __construct(
        private readonly TaskHistoryService $taskHistoryService
    ) {
    }

    /**
     * Get task history.
     */
    public function index(Task $task): ResourceCollection
    {
        Gate::authorize('view', $task);

        $history = $this->taskHistoryService->getTaskHistory($task);

        return TaskHistoryResource::collection($history);
    }
}
