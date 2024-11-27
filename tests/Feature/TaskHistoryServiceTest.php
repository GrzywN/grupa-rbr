<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Services\TaskHistoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskHistoryServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_get_task_history(): void
    {
        $task = Task::factory()->create();

        $taskHistoryService = app()->make(TaskHistoryService::class);
        $taskHistoryCollection = $taskHistoryService->getTaskHistory($task);

        $this->assertCount(1, $taskHistoryCollection);
        $this->assertEquals($task->history->first()->id, $taskHistoryCollection->first()->id);
    }
}
