<?php

namespace App\Services;

use App\Exceptions\DomainException;
use App\Exceptions\ExpiredShareTokenException;
use App\Exceptions\InvalidShareTokenException;
use App\Models\Task;
use App\Models\TaskShareToken;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Str;

class TaskSharingService
{
    /**
     * Create a new share token for a task
     */
    public function createToken(Task $task, ?int $expiresInDays = TaskShareToken::EXPIRES_IN_DAYS): TaskShareToken
    {
        return DB::transaction(static function () use ($task, $expiresInDays) {
            $expiresAt = $expiresInDays ? now()->addDays($expiresInDays) : null;

            return TaskShareToken::factory()->forTask($task)->create([
                'token' => self::generateUniqueToken(),
                'created_by' => $task->user_id,
                'expires_at' => $expiresAt
            ]);
        });
    }

    /**
     * Get task by share token
     *
     * @throws InvalidShareTokenException
     * @throws ExpiredShareTokenException
     * @throws DomainException
     */
    public function getTaskByToken(string $token): Task
    {
        $shareToken = TaskShareToken::with('task')
            ->where('token', $token)
            ->first();

        if (!$shareToken) {
            throw new InvalidShareTokenException();
        }

        if (!$shareToken->isValid()) {
            throw new ExpiredShareTokenException();
        }

        $shareToken->markAsAccessed();

        return $shareToken->task;
    }

    /**
     * Get all active share tokens for a task
     *
     * @return Collection<int, TaskShareToken>
     */
    public function getActiveTokens(Task $task): Collection
    {
        return $task->shareTokens()
            ->valid()
            ->with('creator')
            ->latest()
            ->get();
    }

    /**
     * Revoke a specific share token
     */
    public function revokeToken(TaskShareToken $token): void
    {
        $token->delete();
    }

    /**
     * Revoke all share tokens for a task
     */
    public function revokeAllTokens(Task $task): void
    {
        $task->shareTokens()->delete();
    }

    /**
     * Generate a unique token
     */
    public static function generateUniqueToken(): string
    {
        do {
            $token = Str::uuid();
        } while (TaskShareToken::where('token', $token)->exists());

        return $token;
    }
}
