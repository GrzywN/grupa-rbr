<?php

namespace App\Http\Controllers;

use App\Enums\TaskPriority;
use Illuminate\Http\JsonResponse;

class TaskPriorityController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(TaskPriority::toOptionsArray());
    }
}
