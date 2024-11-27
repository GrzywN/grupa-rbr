<?php

namespace App\Policies;

use App\Models\TaskHistory;
use App\Models\User;

class TaskHistoryPolicy
{
    public function view(User $user, TaskHistory $taskHistory): bool
    {
        return $user->id === $taskHistory->user_id;
    }
}
