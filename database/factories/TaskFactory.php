<?php

namespace Database\Factories;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
        ];
    }

    public function example(): static
    {
        return $this->state(fn (): array => [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement(TaskPriority::values()),
            'status' => fake()->randomElement(TaskStatus::values()),
            'deadline' => fake()->date(),
        ]);
    }

    public function forUser(User $user): static
    {
        return $this->state(fn (): array => [
            'user_id' => $user->id,
        ]);
    }
}
