<?php

namespace Tests\Feature;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_user_can_create_task(): void
    {
        $user = User::factory()->example()->create();

        $response = $this
            ->actingAs($user)
            ->postJson(route('tasks.store'), [
                'title' => 'New task',
                'priority' => TaskPriority::MEDIUM,
                'status' => TaskStatus::TO_DO,
                'deadline' => now()->addDay(),
            ]);

        $response->assertCreated();
        $response->assertJsonFragment([
            'title' => 'New task',
            'priority' => TaskPriority::MEDIUM,
            'status' => TaskStatus::TO_DO,
        ]);
    }

    #[Test]
    public function test_user_can_update_task(): void
    {
        $user = User::factory()->example()->create();
        $task = Task::factory()->example()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->putJson(route('tasks.update', ['task' => $task->id]), [
                'title' => 'Updated title',
                'priority' => TaskPriority::HIGH,
                'status' => TaskStatus::DONE,
                'deadline' => now()->addDays(2),
            ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'title' => 'Updated title',
            'priority' => TaskPriority::HIGH,
            'status' => TaskStatus::DONE,
        ]);
    }

    #[Test]
    public function test_user_can_delete_task(): void
    {
        $user = User::factory()->example()->create();
        $task = Task::factory()->example()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->deleteJson(route('tasks.destroy', ['task' => $task->id]));

        $response->assertNoContent();
    }

    #[Test]
    public function test_user_cannot_delete_other_users_task(): void
    {
        $user = User::factory()->example()->create();
        $task = Task::factory()->example()->create();

        $response = $this
            ->actingAs($user)
            ->deleteJson(route('tasks.destroy', ['task' => $task->id]));

        $response->assertForbidden();
    }

    #[Test]
    public function test_user_can_view_own_tasks(): void
    {
        $user = User::factory()->example()->create();
        $task = Task::factory()->example()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->getJson(route('tasks.index'));

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'title' => $task->title,
            'priority' => $task->priority,
            'status' => $task->status,
        ]);
    }

    #[Test]
    public function test_user_cannot_view_other_users_tasks(): void
    {
        $user = User::factory()->example()->create();
        Task::factory()->example()->create();

        $response = $this
            ->actingAs($user)
            ->getJson(route('tasks.index'));

        $response->assertOk();
        $response->assertJsonCount(0);
    }

    #[Test]
    public function test_user_can_view_single_task(): void
    {
        $user = User::factory()->example()->create();
        $task = Task::factory()->example()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->getJson(route('tasks.show', ['task' => $task->id]));

        $response->assertOk();
        $response->assertJsonFragment([
            'title' => $task->title,
            'priority' => $task->priority,
            'status' => $task->status,
        ]);
    }

    #[Test]
    public function test_user_cannot_view_other_users_task(): void
    {
        $user = User::factory()->example()->create();
        $task = Task::factory()->example()->create();

        $response = $this
            ->actingAs($user)
            ->getJson(route('tasks.show', ['task' => $task->id]));

        $response->assertForbidden();
    }
}
