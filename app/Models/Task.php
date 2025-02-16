<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use App\Casts\TaskDescription;
use App\Casts\TaskTitle;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Observers\TaskObserver;
use Carbon\Carbon;
use Database\Factories\TaskFactory;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Eloquent;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static TaskFactory factory($count = null, $state = [])
 * @method static Builder<static>|Task newModelQuery()
 * @method static Builder<static>|Task newQuery()
 * @method static Builder<static>|Task onlyTrashed()
 * @method static Builder<static>|Task query()
 * @method static Builder<static>|Task whereCompletedAt($value)
 * @method static Builder<static>|Task whereCreatedAt($value)
 * @method static Builder<static>|Task whereDeadline($value)
 * @method static Builder<static>|Task whereDeletedAt($value)
 * @method static Builder<static>|Task whereDescription($value)
 * @method static Builder<static>|Task whereId($value)
 * @method static Builder<static>|Task wherePriority($value)
 * @method static Builder<static>|Task whereStatus($value)
 * @method static Builder<static>|Task whereTitle($value)
 * @method static Builder<static>|Task whereUpdatedAt($value)
 * @method static Builder<static>|Task whereUserId($value)
 * @method static Builder<static>|Task withTrashed()
 * @method static Builder<static>|Task withoutTrashed()
 * @property string|null $completed_at
 * @property-read Collection<int, TaskHistory> $history
 * @property-read int|null $history_count
 * @property-read Collection<int, TaskShareToken> $shareTokens
 * @property-read int|null $share_tokens_count
 * @method static Builder<static>|Task filter(?array $params = null)
 * @method static Builder<static>|Task filterBy(array|string $filters)
 * @method static Builder<static>|Task filterFields(array|string $fields)
 * @method static Builder<static>|Task renamedFilterFields(array $renamedFilterFields)
 * @method static Builder<static>|Task restrictedFilters(array|string $restrictedFilters)
 * @method static Builder<static>|Task sort(?array $params = null)
 * @method static Builder<static>|Task sortFields(array|string $fields)
 * @mixin Eloquent
 */
#[ObservedBy(TaskObserver::class)]
class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use Sortable;
    use Filterable;

    /** @var array<int, string> $cascadeDeletes */
    protected array $cascadeDeletes = ['shareTokens'];

    /** @var array<int, string> $dates */
    protected array $dates = ['deleted_at'];

    /** @var array<int, string> $filterFields */
    protected $filterFields = [
        'priority',
        'status',
        'deadline',
    ];

    /** @var array<int, string> $sortFields */
    protected $sortFields = [
        'title',
        'priority',
        'status',
        'deadline',
    ];

    public const MAX_TITLE_LENGTH = 255;

    public const MAX_DESCRIPTION_LENGTH = 4000;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'status',
        'deadline',
    ];

    #[\Override]
    protected function casts(): array
    {
        return [
            'title' => TaskTitle::class,
            'description' => TaskDescription::class,
            'status' => TaskStatus::class,
            'priority' => TaskPriority::class,
            'deadline' => 'date',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<TaskHistory, $this>
     */
    public function history(): HasMany
    {
        return $this->hasMany(TaskHistory::class);
    }

    /**
     * @return HasMany<TaskShareToken, $this>
     */
    public function shareTokens(): HasMany
    {
        return $this->hasMany(TaskShareToken::class);
    }
}
