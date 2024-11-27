<?php

namespace App\Http\Resources;

use App\Models\TaskShareToken;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TaskShareToken
 */
class TaskShareResource extends JsonResource
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
            'task_id' => (int) $this->task_id,
            'token' => (string) $this->token,
            'created_by' => (int) $this->created_by,
            'expires_at' => $this->expires_at ? (string) $this->expires_at : null,
            'last_accessed_at' => $this->last_accessed_at ? (string) $this->last_accessed_at : null,
            'created_at' => (string) $this->created_at,
        ];
    }
}
