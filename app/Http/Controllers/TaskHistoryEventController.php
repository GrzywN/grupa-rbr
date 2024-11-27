<?php

namespace App\Http\Controllers;

use App\Enums\TaskHistoryEvent;
use Illuminate\Http\JsonResponse;

class TaskHistoryEventController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(TaskHistoryEvent::toOptionsArray());
    }
}
