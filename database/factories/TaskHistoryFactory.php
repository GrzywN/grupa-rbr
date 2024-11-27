<?php

namespace Database\Factories;

use App\Enums\TaskHistoryEvent;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskHistory>
 */
class TaskHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[\Override]
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => '',
            'description' => '',
            'priority' => TaskPriority::MEDIUM,
            'status' => TaskStatus::TO_DO,
            'deadline' => now()->addDay(),
            'task_id' => Task::factory(),
            'event' => TaskHistoryEvent::CREATED,
            'diff' => null,
        ];
    }

    public function created(Task $task): static
    {
        return $this->state(fn (): array => [
            'user_id' => $task->user_id,
            'title' => $task->title,
            'description' => $task->description,
            'priority' => $task->priority,
            'status' => $task->status,
            'deadline' => $task->deadline,
            'task_id' => $task->id,
            'event' => TaskHistoryEvent::CREATED,
            'diff' => null,
        ]);
    }

    public function updated(Task $task, array $diff): static
    {
        return $this->state(fn (): array => [
            'user_id' => $task->user_id,
            'title' => $task->title,
            'description' => $task->description,
            'priority' => $task->priority,
            'status' => $task->status,
            'deadline' => $task->deadline,
            'task_id' => $task->id,
            'event' => TaskHistoryEvent::UPDATED,
            'diff' => $diff,
        ]);
    }

    public function deleted(Task $task, array $diff): static
    {
        return $this->state(fn (): array => [
            'user_id' => $task->user_id,
            'title' => $task->title,
            'description' => $task->description,
            'priority' => $task->priority,
            'status' => $task->status,
            'deadline' => $task->deadline,
            'task_id' => $task->id,
            'event' => TaskHistoryEvent::DELETED,
            'diff' => $diff,
        ]);
    }
}
