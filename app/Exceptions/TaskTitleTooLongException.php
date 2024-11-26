<?php

namespace App\Exceptions;

use App\Models\Task;

class TaskTitleTooLongException extends DomainException
{
    public function __construct(string $value)
    {
        parent::__construct("Task title '{$value}' exceeds maximum length of " . Task::MAX_TITLE_LENGTH . " characters");
    }
}
