<?php

namespace App\Http\Resources;

use App\Models\TaskHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin TaskHistory */
class TaskHistoryResource extends JsonResource
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
            'id' => (int) $this->id,
            'title' => (string) $this->title,
            'description' => (string) $this->description,
            'priority' => (string) $this->priority->value,
            'status' => (string) $this->status->value,
            'deadline' => (string) $this->deadline,
            'event' => (string) $this->event->value,
            'diff' => TaskHistoryDiffResource::make($this->diff),
            'created_at' => (string) $this->created_at,
        ];
    }
}
