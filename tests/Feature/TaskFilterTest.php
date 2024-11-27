<?php

namespace Tests\Feature;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskFilterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_filter_tasks_by_status(): void
    {
        $user = User::factory()->example()->create();

        Task::factory()->example()->forUser($user)->create(['status' => TaskStatus::TO_DO]);
        Task::factory()->example()->forUser($user)->create(['status' => TaskStatus::DONE]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'filters' => [
                'status' => [
                    '$eq' => TaskStatus::TO_DO->value,
                ],
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['status' => TaskStatus::TO_DO->value]);
    }

    #[Test]
    public function it_can_filter_tasks_by_priority(): void
    {
        $user = User::factory()->example()->create();

        Task::factory()->example()->forUser($user)->create(['priority' => TaskPriority::HIGH]);
        Task::factory()->example()->forUser($user)->create(['priority' => TaskPriority::LOW]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'filters' => [
                'priority' => [
                    '$eq' => TaskPriority::HIGH->value,
                ],
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['priority' => TaskPriority::HIGH->value]);
    }

    #[Test]
    public function it_can_filter_tasks_by_deadline(): void
    {
        $user = User::factory()->example()->create();
        $deadline = now()->addDay()->startOfDay();

        Task::factory()->example()->forUser($user)->create(['deadline' => $deadline]);
        Task::factory()->example()->forUser($user)->create(['deadline' => now()->addDays(2)]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'filters' => [
                'deadline' => [
                    '$eq' => now()->addDay()->toDatabaseDate(),
                ],
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'deadline' => $deadline->format('Y-m-d\TH:i:sO'),
        ]);
    }

    #[Test]
    public function it_can_filter_multiple_fields_at_once(): void
    {
        $user = User::factory()->example()->create();
        $deadline = now()->addDay()->startOfDay();

        Task::factory()->example()->forUser($user)->create([
            'status' => TaskStatus::TO_DO,
            'priority' => TaskPriority::HIGH,
            'deadline' => $deadline,
        ]);
        Task::factory()->example()->forUser($user)->create([
            'status' => TaskStatus::DONE,
            'priority' => TaskPriority::LOW,
            'deadline' => now()->addDays(2),
        ]);

        $response = $this->actingAs($user)->getJson(route('tasks.index', [
            'filters' => [
                'status' => [
                    '$eq' => TaskStatus::TO_DO->value,
                ],
                'priority' => [
                    '$eq' => TaskPriority::HIGH->value,
                ],
                'deadline' => [
                    '$eq' => now()->addDay()->toDatabaseDate(),
                ],
            ],
        ]));

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'status' => TaskStatus::TO_DO->value,
            'priority' => TaskPriority::HIGH->value,
            'deadline' => $deadline->format('Y-m-d\TH:i:sO'),
        ]);
    }
}
