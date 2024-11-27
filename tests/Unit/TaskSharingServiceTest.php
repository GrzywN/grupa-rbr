<?php

namespace Tests\Unit;

use App\Exceptions\ExpiredShareTokenException;
use App\Exceptions\InvalidShareTokenException;
use App\Models\Task;
use App\Models\TaskShareToken;
use App\Services\TaskSharingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskSharingServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_share_token_for_a_task(): void
    {
        $task = Task::factory()->create();
        $service = app()->make(TaskSharingService::class);

        $token = $service->createToken($task);

        $this->assertNotNull($token);
        $this->assertEquals($task->id, $token->task_id);
        $this->assertNotNull($token->token);
        $this->assertEquals($task->user_id, $token->created_by);
    }

    #[Test]
    public function it_gets_a_task_by_share_token(): void
    {
        $task = Task::factory()->create();
        $token = TaskShareToken::factory()->example()->forTask($task)->create();
        $service = app()->make(TaskSharingService::class);

        $result = $service->getTaskByToken($token->token);

        $this->assertEquals($task->id, $result->id);
    }

    #[Test]
    public function it_throws_an_exception_when_token_is_not_found(): void
    {
        $service = app()->make(TaskSharingService::class);

        $this->expectException(InvalidShareTokenException::class);
        $service->getTaskByToken('invalid-token');
    }

    #[Test]
    public function it_throws_an_exception_when_token_is_expired(): void
    {
        $token = TaskShareToken::factory()->example()->expired()->create();
        $service = app()->make(TaskSharingService::class);

        $this->expectException(ExpiredShareTokenException::class);
        $service->getTaskByToken($token->token);
    }

    #[Test]
    public function it_gets_all_active_share_tokens_for_a_task(): void
    {
        $task = Task::factory()->create();
        $tokens = TaskShareToken::factory()->example()->forTask($task)->count(3)->create();
        $service = app()->make(TaskSharingService::class);

        $result = $service->getActiveTokens($task);

        $this->assertCount(3, $result);
        $this->assertEquals($tokens[0]->id, $result[0]->id);
        $this->assertEquals($tokens[1]->id, $result[1]->id);
        $this->assertEquals($tokens[2]->id, $result[2]->id);
    }

    #[Test]
    public function it_revokes_a_specific_share_token(): void
    {
        $token = TaskShareToken::factory()->example()->create();
        $service = app()->make(TaskSharingService::class);

        $service->revokeToken($token);

        $this->assertNull(TaskShareToken::find($token->id));
    }

    #[Test]
    public function it_revokes_all_share_tokens_for_a_task(): void
    {
        $task = Task::factory()->example()->create();
        TaskShareToken::factory()->example()->forTask($task)->count(3)->create();
        $service = app()->make(TaskSharingService::class);

        $service->revokeAllTokens($task);

        $this->assertCount(0, TaskShareToken::where('task_id', $task->id)->get());
    }

    #[Test]
    public function it_generates_a_unique_token(): void
    {
        $token = TaskSharingService::generateUniqueToken();

        $this->assertIsUuid($token);
    }
}
