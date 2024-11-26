<?php

namespace App\Exceptions;

use App\Models\Task;

class TaskDescriptionTooLongException extends DomainException
{
    public function __construct(string $value)
    {
        parent::__construct("Task description '{$value}' exceeds maximum length of " . Task::MAX_DESCRIPTION_LENGTH . " characters");
    }
}
