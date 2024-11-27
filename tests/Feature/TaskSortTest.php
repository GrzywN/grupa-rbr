<?php

namespace Tests\Feature;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskSortTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_sort_tasks_by_title_ascending(): void
    {
        $user = User::factory()->example()->create();

        Task::factory()->example()->forUser($user)->create(['title' => 'Task Q']);
        Task::factory()->example()->forUser($user)->create(['title' => 'Task A']);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'sort' => [
                'title:asc',
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonPath('0.title', 'Task A');
        $response->assertJsonPath('1.title', 'Task Q');
    }

    #[Test]
    public function it_can_sort_tasks_by_title_descending(): void
    {
        $user = User::factory()->example()->create();

        Task::factory()->example()->forUser($user)->create(['title' => 'Task A']);
        Task::factory()->example()->forUser($user)->create(['title' => 'Task Q']);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'sort' => [
                'title:desc',
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonPath('0.title', 'Task Q');
        $response->assertJsonPath('1.title', 'Task A');
    }

    #[Test]
    public function it_can_sort_tasks_by_status_ascending(): void
    {
        $user = User::factory()->example()->create();

        Task::factory()->example()->forUser($user)->create(['status' => TaskStatus::DONE]);
        Task::factory()->example()->forUser($user)->create(['status' => TaskStatus::TO_DO]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'sort' => [
                'status:asc',
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonPath('0.status', TaskStatus::TO_DO->value);
        $response->assertJsonPath('1.status', TaskStatus::DONE->value);
    }

    #[Test]
    public function it_can_sort_tasks_by_status_descending(): void
    {
        $user = User::factory()->example()->create();

        Task::factory()->example()->forUser($user)->create(['status' => TaskStatus::TO_DO]);
        Task::factory()->example()->forUser($user)->create(['status' => TaskStatus::DONE]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'sort' => [
                'status:desc',
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonPath('0.status', TaskStatus::DONE->value);
        $response->assertJsonPath('1.status', TaskStatus::TO_DO->value);
    }

    #[Test]
    public function it_can_sort_tasks_by_priority_ascending(): void
    {
        $user = User::factory()->example()->create();

        Task::factory()->example()->forUser($user)->create(['priority' => TaskPriority::HIGH]);
        Task::factory()->example()->forUser($user)->create(['priority' => TaskPriority::LOW]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'sort' => [
                'priority:asc',
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonPath('0.priority', TaskPriority::LOW->value);
        $response->assertJsonPath('1.priority', TaskPriority::HIGH->value);
    }

    #[Test]
    public function it_can_sort_tasks_by_priority_descending(): void
    {
        $user = User::factory()->example()->create();

        Task::factory()->example()->forUser($user)->create(['priority' => TaskPriority::LOW]);
        Task::factory()->example()->forUser($user)->create(['priority' => TaskPriority::HIGH]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'sort' => [
                'priority:desc',
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonPath('0.priority', TaskPriority::HIGH->value);
        $response->assertJsonPath('1.priority', TaskPriority::LOW->value);
    }

    #[Test]
    public function it_can_sort_tasks_by_deadline_ascending(): void
    {
        $user = User::factory()->example()->create();
        $deadline = now()->addDay()->startOfDay();

        Task::factory()->example()->forUser($user)->create(['deadline' => $deadline]);
        Task::factory()->example()->forUser($user)->create(['deadline' => now()->addDays(2)]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'sort' => [
                'deadline:asc',
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonPath('0.deadline', $deadline->format('Y-m-d\TH:i:sO'));
        $response->assertJsonPath('1.deadline', now()->addDays(2)->startOfDay()->format('Y-m-d\TH:i:sO'));
    }

    #[Test]
    public function it_can_sort_tasks_by_deadline_descending(): void
    {
        $user = User::factory()->example()->create();
        $deadline = now()->addDay()->startOfDay();

        Task::factory()->example()->forUser($user)->create(['deadline' => now()->addDays(2)]);
        Task::factory()->example()->forUser($user)->create(['deadline' => $deadline]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'sort' => [
                'deadline:desc',
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonPath('0.deadline', now()->addDays(2)->startOfDay()->format('Y-m-d\TH:i:sO'));
        $response->assertJsonPath('1.deadline', $deadline->format('Y-m-d\TH:i:sO'));
    }
}
