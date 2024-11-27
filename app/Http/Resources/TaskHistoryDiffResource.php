<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Task */
class TaskHistoryDiffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[\Override]
    public function toArray(Request $request): array
    {
        return [
            'title' => $this['title'] ?? null,
            'description' => $this['description'] ?? null,
            'priority' => $this['priority'] ?? null,
            'status' => $this['status'] ?? null,
            'deadline' => $this['deadline'] ?? null,
        ];
    }
}
