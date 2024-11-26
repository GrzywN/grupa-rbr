<?php

namespace App\Exceptions;

class TaskNotFoundAfterUpdate extends DomainException
{
    public function __construct()
    {
        parent::__construct('Task not found after update');
    }
}
