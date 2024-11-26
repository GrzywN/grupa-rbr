<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:'.Task::MAX_TITLE_LENGTH,
            ],
            'description' => [
                'nullable',
                'string',
                'max:' . Task::MAX_DESCRIPTION_LENGTH,
            ],
            'priority' => [
                'required',
                Rule::enum(TaskPriority::class),
            ],
            'status' => [
                'required',
                Rule::enum(TaskStatus::class),
            ],
            'deadline' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ];
    }
}
