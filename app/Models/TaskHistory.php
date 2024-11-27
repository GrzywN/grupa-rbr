<?php

namespace App\Models;

use App\Casts\TaskDescription;
use App\Casts\TaskTitle;
use App\Enums\TaskHistoryEvent;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Carbon\Carbon;
use Database\Factories\TaskHistoryFactory;
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
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property TaskPriority $priority
 * @property TaskStatus $status
 * @property Carbon $deadline
 * @property int $task_id
 * @property TaskHistoryEvent $event
 * @property array $diff
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Task $task
 * @method static TaskHistoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|TaskHistory newModelQuery()
 * @method static Builder<static>|TaskHistory newQuery()
 * @method static Builder<static>|TaskHistory onlyTrashed()
 * @method static Builder<static>|TaskHistory query()
 * @method static Builder<static>|TaskHistory whereCreatedAt($value)
 * @method static Builder<static>|TaskHistory whereDeadline($value)
 * @method static Builder<static>|TaskHistory whereDeletedAt($value)
 * @method static Builder<static>|TaskHistory whereDescription($value)
 * @method static Builder<static>|TaskHistory whereDiff($value)
 * @method static Builder<static>|TaskHistory whereEvent($value)
 * @method static Builder<static>|TaskHistory whereId($value)
 * @method static Builder<static>|TaskHistory wherePriority($value)
 * @method static Builder<static>|TaskHistory whereStatus($value)
 * @method static Builder<static>|TaskHistory whereTaskId($value)
 * @method static Builder<static>|TaskHistory whereTitle($value)
 * @method static Builder<static>|TaskHistory whereUpdatedAt($value)
 * @method static Builder<static>|TaskHistory whereUserId($value)
 * @method static Builder<static>|TaskHistory withTrashed()
 * @method static Builder<static>|TaskHistory withoutTrashed()
 * @mixin Eloquent
 */
class TaskHistory extends Model
{
    /** @use HasFactory<TaskHistoryFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'task_id',
        'user_id',
        'title',
        'description',
        'priority',
        'status',
        'deadline',
        'event',
        'diff',
    ];

    #[\Override]
    protected function casts(): array
    {
        return [
            'title' => TaskTitle::class,
            'description' => TaskDescription::class,
            'status' => TaskStatus::class,
            'priority' => TaskPriority::class,
            'deadline' => 'datetime:c',
            'event' => TaskHistoryEvent::class,
            'diff' => 'json',
        ];
    }

    /**
     * @return BelongsTo<Task, $this>
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
