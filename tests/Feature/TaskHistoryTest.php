<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskHistoryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_user_can_view_task_history(): void
    {
        $user = User::factory()->example()->create();
        $task = Task::factory()->example()->forUser($user)->create();
        $task->update(['title' => 'Updated title']);

        $response = $this
            ->actingAs($user)
            ->getJson(route('task-history.index', ['task' => $task->id]));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'description',
                'priority',
                'status',
                'deadline',
                'event',
                'diff' => [
                    'title',
                    'description',
                    'priority',
                    'status',
                    'deadline',
                ],
                'created_at',
            ],
        ]);
        $response->assertJsonFragment([
            'title' => 'Updated title',
            'event' => 'updated',
            'diff' => [
                'title' => 'Updated title',
                'description' => null,
                'priority' => null,
                'status' => null,
                'deadline' => null,
            ],
        ]);
    }

    #[Test]
    public function test_user_cannot_view_history_of_other_users_tasks(): void
    {
        $user = User::factory()->example()->create();
        $task = Task::factory()->example()->create();

        $response = $this
            ->actingAs($user)
            ->getJson(route('task-history.index', ['task' => $task->id]));

        $response->assertForbidden();
    }
}
