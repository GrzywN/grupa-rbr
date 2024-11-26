<?php

namespace App\Http\Controllers;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Helpers\Assert;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    ) {
    }

    public function index(): ResourceCollection
    {
        $loggedInUser = Auth::user();
        Assert::that($loggedInUser !== null, 'User is not authenticated');
        /** @var User $loggedInUser */

        $tasks = $this->taskService->getTasks($loggedInUser);

        return TaskResource::collection($tasks);
    }

    public function show(Task $task): TaskResource
    {
        Gate::authorize('view', $task);

        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        $loggedInUser = Auth::user();
        Assert::that($loggedInUser !== null, 'User is not authenticated');
        /** @var User $loggedInUser */

        /**
         * @var array{
         *     title: non-empty-string,
         *     description?: string,
         *     priority: TaskPriority,
         *     status: TaskStatus,
         *     deadline: Carbon,
         * } $validated
         */
        $validated = $request->validated();

        $task = $this->taskService->createTask(
            $loggedInUser,
            $validated
        );

        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        Gate::authorize('update', $task);

        /**
         * @phpstan-var array{
         *     title: non-empty-string,
         *     description?: string,
         *     priority: TaskPriority,
         *     status: TaskStatus,
         *     deadline: Carbon,
         * } $validated
         */
        $validated = $request->validated();

        $updatedTask = $this->taskService->updateTask(
            $validated,
            $task
        );

        return new TaskResource($updatedTask);
    }

    public function destroy(Task $task): JsonResponse
    {
        Gate::authorize('delete', $task);

        $this->taskService->deleteTask($task);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
