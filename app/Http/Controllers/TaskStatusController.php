<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use Illuminate\Http\JsonResponse;

class TaskStatusController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(TaskStatus::toOptionsArray());
    }
}
