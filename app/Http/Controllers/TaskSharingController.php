<?php

namespace App\Http\Controllers;

use App\Exceptions\ExpiredShareTokenException;
use App\Exceptions\InvalidShareTokenException;
use App\Http\Resources\TaskShareResource;
use App\Models\Task;
use App\Models\TaskShareToken;
use App\Services\TaskSharingService;
use Gate;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Illuminate\Http\Response;

class TaskSharingController extends Controller
{
    public function __construct(
        private readonly TaskSharingService $sharingService
    ) {
    }

    /**
     * Get active share tokens for task
     */
    public function index(Task $task): JsonResponse
    {
        Gate::authorize('viewShares', $task);

        $tokens = $this->sharingService->getActiveTokens($task);

        return response()->json(
            TaskShareResource::collection($tokens)
        );
    }

    /**
     * Get shared task
     */
    public function show(string $token): InertiaResponse
    {
        try {
            $task = $this->sharingService->getTaskByToken($token);

            return Inertia::render('external/task/show', [
                'task' => $task,
            ]);
        } catch (InvalidShareTokenException) {
            return Inertia::render('external/task/invalid-token');
        } catch (ExpiredShareTokenException) {
            return Inertia::render('external/task/expired-token');
        }
    }

    /**
     * Create a new share token
     */
    public function store(Task $task): TaskShareResource
    {
        Gate::authorize('share', $task);

        $token = $this->sharingService->createToken($task);

        return new TaskShareResource($token);
    }

    /**
     * Revoke share token
     */
    public function destroy(Task $task, TaskShareToken $token): JsonResponse
    {
        Gate::authorize('revokeShare', $task);

        $this->sharingService->revokeToken($token);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
