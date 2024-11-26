<?php

namespace App\Casts;

use App\Exceptions\TaskDescriptionTooLongException;
use App\Models\Task;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Log;

/**
 * @template-implements CastsAttributes<string, string>
 */
class TaskDescription implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Task $model
     * @param  string  $value
     * @param  array<string, mixed>  $attributes
     */
    #[\Override]
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Task $model
     * @param  string  $value
     * @param  array<string, mixed>  $attributes
     */
    #[\Override]
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (strlen((string) $value) > Task::MAX_DESCRIPTION_LENGTH) {
            Log::critical('Task: Description is too long.', [
                'task_id' => $model->id,
                'old_title' => $model->getOriginal('title'),
                'new_title' => $value
            ]);
            throw new TaskDescriptionTooLongException($value);
        }

        return $value;
    }
}
