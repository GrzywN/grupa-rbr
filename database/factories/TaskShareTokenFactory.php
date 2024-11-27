<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskShareToken>
 */
class TaskShareTokenFactory extends Factory
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
            'task_id' => Task::factory(),
            'token' => '',
            'created_by' => User::factory(),
            'expires_at' => now()->addDays(7),
            'last_accessed_at' => null,
        ];
    }

    public function example(): Factory
    {
        return $this->state(fn (): array => [
            'task_id' => Task::factory()->create(),
            'token' => fake()->uuid(),
            'created_by' => User::factory()->create(),
            'expires_at' => now()->addDays(7),
            'last_accessed_at' => fake()->optional()->dateTime(),
        ]);
    }

    public function expired(): Factory
    {
        return $this->state([
            'expires_at' => now()->subDay(),
        ]);
    }

    public function forTask(Task $task): Factory
    {
        return $this->state([
            'task_id' => $task,
        ]);
    }

    public function forUser(User $user): Factory
    {
        return $this->state([
            'created_by' => $user,
        ]);
    }
}
