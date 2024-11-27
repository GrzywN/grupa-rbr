<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\TaskShareTokenFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $task_id
 * @property string $token
 * @property int $created_by
 * @property Carbon|null $expires_at
 * @property Carbon|null $last_accessed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $creator
 * @property-read Task $task
 * @method static TaskShareTokenFactory factory($count = null, $state = [])
 * @method static Builder<static>|TaskShareToken newModelQuery()
 * @method static Builder<static>|TaskShareToken newQuery()
 * @method static Builder<static>|TaskShareToken onlyTrashed()
 * @method static Builder<static>|TaskShareToken query()
 * @method static Builder<static>|TaskShareToken valid()
 * @method static Builder<static>|TaskShareToken whereCreatedAt($value)
 * @method static Builder<static>|TaskShareToken whereCreatedBy($value)
 * @method static Builder<static>|TaskShareToken whereDeletedAt($value)
 * @method static Builder<static>|TaskShareToken whereExpiresAt($value)
 * @method static Builder<static>|TaskShareToken whereId($value)
 * @method static Builder<static>|TaskShareToken whereLastAccessedAt($value)
 * @method static Builder<static>|TaskShareToken whereTaskId($value)
 * @method static Builder<static>|TaskShareToken whereToken($value)
 * @method static Builder<static>|TaskShareToken whereUpdatedAt($value)
 * @method static Builder<static>|TaskShareToken withTrashed()
 * @method static Builder<static>|TaskShareToken withoutTrashed()
 * @mixin Eloquent
 */
class TaskShareToken extends Model
{
    /** @use HasFactory<TaskShareTokenFactory> */
    use HasFactory;
    use SoftDeletes;

    public const int EXPIRES_IN_DAYS = 7;

    protected $fillable = [
        'task_id',
        'token',
        'created_by',
        'expires_at',
        'last_accessed_at'
    ];

    #[\Override]
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'last_accessed_at' => 'datetime'
        ];
    }

    /**
     * @return BelongsTo<Task, $this>
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @param Builder<TaskShareToken> $query
     * @return Builder<TaskShareToken>
     */
    public function scopeValid(Builder $query): Builder
    {
        return $query->where(static function ($query): void {
            $query->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        })->whereNull('deleted_at');
    }

    public function isValid(): bool
    {
        return !$this->trashed() &&
            (!$this->expires_at || $this->expires_at->isFuture());
    }

    public function markAsAccessed(): void
    {
        $this->update(['last_accessed_at' => now()]);
    }
}
