<?php

namespace Tests\Feature;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Exceptions\TaskDescriptionTooLongException;
use App\Exceptions\TaskTitleTooLongException;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_get_user_tasks(): void
    {
        $user = User::factory()->example()->create();
        $task = Task::factory()->example()->forUser($user)->create();
        $service = app()->make(TaskService::class);

        $tasks = $service->getTasks($user);

        $this->assertCount(1, $tasks);
        $this->assertEquals($task->id, $tasks->first()->id);
    }

    #[Test]
    public function it_can_create_task(): void
    {
        $user = User::factory()->example()->create();
        $data = [
            'user_id' => $user->id,
            'title' => str_repeat('a', Task::MAX_TITLE_LENGTH),
            'description' => 'Task description',
            'priority' => TaskPriority::HIGH,
            'status' => TaskStatus::TO_DO,
            'deadline' => now()->addDay()->format('Y-m-d'),
        ];
        $service = app()->make(TaskService::class);

        $this->assertDatabaseMissing('tasks', $data);

        $task = $service->createTask($user, $data);

        $this->assertDatabaseHas('tasks', $data);
        $this->assertEquals($user->id, $task->user_id);
        $this->assertEquals($data['title'], $task->title);
        $this->assertEquals($data['description'], $task->description);
        $this->assertEquals($data['priority'], $task->priority);
        $this->assertEquals($data['status'], $task->status);
        $this->assertEquals($data['deadline'], $task->deadline->format('Y-m-d'));
    }

    #[Test]
    public function it_cannot_create_task_when_title_is_too_long(): void
    {
        $user = User::factory()->example()->create();
        $data = [
            'title' => str_repeat('b', Task::MAX_TITLE_LENGTH + 1),
            'description' => 'Task description',
            'priority' => TaskPriority::MEDIUM,
            'status' => TaskStatus::TO_DO,
            'deadline' => now()->addDay()->format('Y-m-d'),
        ];
        $service = app()->make(TaskService::class);

        $this->assertDatabaseMissing('tasks', $data);

        $this->expectException(TaskTitleTooLongException::class);
        $service->createTask($user, $data);

        $this->assertDatabaseMissing('tasks', $data);
    }

    #[Test]
    public function it_cannot_create_task_when_description_is_too_long(): void
    {
        $user = User::factory()->example()->create();
        $data = [
            'title' => str_repeat('b', Task::MAX_TITLE_LENGTH),
            'description' => str_repeat('b', Task::MAX_DESCRIPTION_LENGTH + 1),
            'priority' => TaskPriority::MEDIUM,
            'status' => TaskStatus::TO_DO,
            'deadline' => now()->addDay()->format('Y-m-d'),
        ];
        $service = app()->make(TaskService::class);

        $this->assertDatabaseMissing('tasks', $data);

        $this->expectException(TaskDescriptionTooLongException::class);
        $service->createTask($user, $data);

        $this->assertDatabaseMissing('tasks', $data);
    }

    #[Test]
    public function it_can_update_task_by_creation(): void
    {
        $task = Task::factory()->example()->create();
        $service = app()->make(TaskService::class);
        $data = [
            'user_id' => $task->user_id,
            'title' => 'New title',
            'description' => 'New description',
            'priority' => TaskPriority::LOW,
            'status' => TaskStatus::DONE,
            'deadline' => now()->addWeek()->format('Y-m-d'),
        ];

        $updatedTask = $service->updateTask($data, $task);

        $this->assertEquals($task->id, $updatedTask->id);
        $this->assertEquals($data['user_id'], $updatedTask->user_id);
        $this->assertEquals($data['title'], $updatedTask->title);
        $this->assertEquals($data['description'], $updatedTask->description);
        $this->assertEquals($data['priority'], $updatedTask->priority);
        $this->assertEquals($data['status'], $updatedTask->status);
        $this->assertEquals($data['deadline'], $updatedTask->deadline->format('Y-m-d'));
    }

    #[Test]
    public function it_can_delete_task(): void
    {
        $task = Task::factory()->example()->create();
        $service = app()->make(TaskService::class);

        $service->deleteTask($task);

        $this->assertSoftDeleted($task->fresh());
    }
}
