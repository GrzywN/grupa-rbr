<?php

namespace App\Services;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Exceptions\DomainException;
use App\Exceptions\TaskDescriptionTooLongException;
use App\Exceptions\TaskNotFoundAfterUpdate;
use App\Exceptions\TaskTitleTooLongException;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Throwable;

class TaskService
{
    /**
     * Get all todos for user
     *
     * @return Collection<int, Task>
     */
    public function getTasks(User $user): Collection
    {
        return $user->tasks()->get();
    }

    /**
     * Create new todo for user and return it
     *
     * @param array{
     *     title: non-empty-string,
     *     description?: string,
     *     priority: TaskPriority,
     *     status: TaskStatus,
     *     deadline: Carbon,
     * } $fields
     *
     * @throws TaskTitleTooLongException
     * @throws TaskDescriptionTooLongException
     * @throws DomainException
     * @throws Throwable
     */
    public function createTask(User $user, array $fields): Task
    {
        return Task::factory()->forUser($user)->create($fields);
    }

    /**
     * Update todo and return
     *
     * @param array{
     *     title: non-empty-string,
     *     description?: string,
     *     priority: TaskPriority,
     *     status: TaskStatus,
     *     deadline: Carbon,
     * } $data
     *
     * @throws TaskTitleTooLongException
     * @throws TaskDescriptionTooLongException
     * @throws DomainException
     * @throws Throwable
     */
    public function updateTask(array $data, Task $task): Task
    {
        $task->update($data);

        $updatedTask = $task->fresh();
        if ($updatedTask === null) {
            throw new TaskNotFoundAfterUpdate();
        }

        return $updatedTask;
    }

    /**
     * Delete todo
     */
    public function deleteTask(Task $task): void
    {
        $task->delete();
    }
}
