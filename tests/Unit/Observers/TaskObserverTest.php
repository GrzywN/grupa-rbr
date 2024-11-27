<?php

namespace Tests\Unit\Observers;

use App\Enums\TaskHistoryEvent;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Tests\TestCase;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Observers\TaskObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class TaskObserverTest extends TestCase
{
    use RefreshDatabase;

    private TaskObserver $observer;
    private Task $task;

    #[Test]
    public function it_creates_history_record_when_task_is_created(): void
    {
        $this->assertDatabaseCount('task_histories', 0);

        $task = Task::factory()->create();

        $this->assertDatabaseCount('task_histories', 1);
        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'title' => $task->title,
            'description' => $task->description,
            'priority' => $task->priority,
            'status' => $task->status,
            'deadline' => $task->deadline->toDatabaseDate(),
            'event' => TaskHistoryEvent::CREATED,
            'diff' => null,
        ]);
    }

    #[Test]
    public function it_creates_history_record_when_task_is_updated(): void
    {
        $this->assertDatabaseCount('task_histories', 0);

        $task = Task::factory()->create();

        $this->assertDatabaseCount('task_histories', 1);

        $fields = [
            'title' => 'Updated title',
            'description' => 'Updated description',
            'priority' => TaskPriority::HIGH,
            'status' => TaskStatus::IN_PROGRESS,
            'deadline' => now()->addDays(3),
        ];
        $task->update($fields);

        $this->assertDatabaseCount('task_histories', 2);

        $taskHistory = TaskHistory::whereEvent(TaskHistoryEvent::UPDATED)->first();

        $this->assertEquals($task->id, $taskHistory->task_id);
        $this->assertEquals($task->user_id, $taskHistory->user_id);
        $this->assertEquals($fields['title'], $taskHistory->title);
        $this->assertEquals($fields['description'], $taskHistory->description);
        $this->assertEquals($fields['priority'], $taskHistory->priority);
        $this->assertEquals($fields['status'], $taskHistory->status);
        $this->assertEquals($fields['deadline']->toDatabaseDate(), $taskHistory->deadline->toDatabaseDate());
        $this->assertEquals(TaskHistoryEvent::UPDATED, $taskHistory->event);

        $expectedDiff = json_decode(json_encode($fields), true);
        $actualDiff = json_decode(json_encode($taskHistory->diff), true);
        $this->assertEquals($expectedDiff, $actualDiff, '');
    }

    #[Test]
    public function it_creates_history_record_when_task_is_deleted(): void
    {
        $this->assertDatabaseCount('task_histories', 0);

        $task = Task::factory()->create();

        $this->assertDatabaseCount('task_histories', 1);

        $task->delete();

        $this->assertDatabaseCount('task_histories', 2);

        $taskHistory = TaskHistory::whereEvent(TaskHistoryEvent::DELETED)->first();

        $this->assertEquals($task->id, $taskHistory->task_id);
        $this->assertEquals($task->user_id, $taskHistory->user_id);
        $this->assertEquals($task->title, $taskHistory->title);
        $this->assertEquals($task->description, $taskHistory->description);
        $this->assertEquals($task->priority, $taskHistory->priority);
        $this->assertEquals($task->status, $taskHistory->status);
        $this->assertEquals($task->deadline->toDatabaseDate(), $taskHistory->deadline->toDatabaseDate());
        $this->assertEquals(TaskHistoryEvent::DELETED, $taskHistory->event);
        $this->assertNotNull($taskHistory->diff['deleted_at']);
    }

    #[Test]
    public function it_has_diff_dates_in_iso8601_format(): void
    {
        $this->assertDatabaseCount('task_histories', 0);

        $task = Task::factory()->create();
        $task->update(['deadline' => now()->addDays(3)]);

        $this->assertDatabaseCount('task_histories', 2);

        $taskHistory = TaskHistory::whereEvent(TaskHistoryEvent::UPDATED)->first();
        $this->assertIsIso8601($taskHistory->diff['deadline']);
    }
}
