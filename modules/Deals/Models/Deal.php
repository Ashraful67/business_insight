<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Models;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastableModelEventOccurred;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Modules\Activities\Concerns\HasActivities;
use Modules\Billable\Concerns\HasProducts;
use Modules\Core\Casts\ISO8601Date;
use Modules\Core\Changelog\LogsModelChanges;
use Modules\Core\Concerns\HasCreator;
use Modules\Core\Concerns\HasUuid;
use Modules\Core\Concerns\Prunable;
use Modules\Core\Contracts\Presentable;
use Modules\Core\Facades\ChangeLogger;
use Modules\Core\Media\HasMedia;
use Modules\Core\Models\Model;
use Modules\Core\Models\PinnedTimelineSubject;
use Modules\Core\Resource\Resourceable;
use Modules\Core\Timeline\HasTimeline;
use Modules\Core\Workflow\HasWorkflowTriggers;
use Modules\Deals\Database\Factories\DealFactory;
use Modules\Deals\Enums\DealStatus;
use Modules\Documents\Concerns\HasDocuments;
use Modules\MailClient\Concerns\HasEmails;

class Deal extends Model implements Presentable
{
    use LogsModelChanges,
        Resourceable,
        HasUuid,
        HasMedia,
        HasCreator,
        HasWorkflowTriggers,
        HasTimeline,
        HasEmails,
        HasFactory,
        HasActivities,
        HasProducts,
        HasDocuments,
        SoftDeletes,
        BroadcastsEvents,
        Prunable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_by',
        'created_at',
        'updated_at',
        'owner_assigned_date',
        'next_activity_id',
        'stage_changed_date',
        'uuid',
    ];

    /**
     * Attributes and relations to log changelog for the model
     *
     * @var array
     */
    protected static $changelogAttributes = [
        '*',
        'user.name',
        'pipeline.name',
    ];

    /**
     * Exclude attributes from the changelog
     *
     * @var array
     */
    protected static $changelogAttributeToIgnore = [
        'updated_at',
        'created_at',
        'created_by',
        'owner_assigned_date',
        'stage_changed_date',
        'swatch_color',
        'board_order',
        'status',
        'won_date',
        'lost_date',
        'lost_reason',
        'next_activity_id',
        // Stage change are handled via custom pivot log events
        'stage_id',
        'deleted_at',
    ];

    /**
     * Provides the relationships for the pivot logger
     *
     * [ 'main' => 'reverse']
     *
     * @return array
     */
    protected static $logPivotEventsOn = [
        'companies' => 'deals',
        'contacts' => 'deals',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expected_close_date' => ISO8601Date::class,
        'stage_changed_date' => 'datetime',
        'owner_assigned_date' => 'datetime',
        'won_date' => 'datetime',
        'lost_date' => 'datetime',
        'status' => DealStatus::class,
        'amount' => 'decimal:3',
        'stage_id' => 'int',
        'pipeline_id' => 'int',
        'user_id' => 'int',
        'board_order' => 'int',
        'created_by' => 'int',
        'web_form_id' => 'int',
        'next_activity_id' => 'int',
    ];

    /**
     * The fields for the model that are searchable.
     */
    protected static array $searchableFields = [
        'pipeline_id',
        'name' => 'like',
    ];

    /**
     * Indicates whether the deal "updating" and "updated" events are triggered via the board
     */
    public bool $boardFiresEvents = false;

    /**
     * Indicates whether to broadcast to the current user when the model is updated
     */
    public bool $broadcastToCurrentUser = false;

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        static::restoring(function ($model) {
            $model->logToAssociatedRelationsThatRelatedInstanceIsRestored(['contacts', 'companies']);
        });

        static::created(function ($model) {
            if ($model->status === DealStatus::open) {
                $model->startStageHistory();
            }
        });

        static::saving(function ($model) {
            if ($model->isDirty('status')) {
                if ($model->status === DealStatus::open) {
                    $model->fill(['won_date' => null, 'lost_date' => null, 'lost_reason' => null]);
                } elseif ($model->status === DealStatus::lost) {
                    $model->fill(['lost_date' => now(), 'won_date' => null]);
                } else {
                    // won status
                    $model->fill(['won_date' => now(), 'lost_date' => null, 'lost_reason' => null]);
                }
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('stage_id')) {
                $model->stage_changed_date = now();
            }

            if (! $model->isDirty('status')) {
                // Guard these attributes when the status is not changed
                foreach (['won_date', 'lost_date'] as $guarded) {
                    if ($model->isDirty($guarded)) {
                        $model->fill([$guarded => $model->getOriginal($guarded)]);
                    }
                }

                // Allow updating the lost reason only when status is lost
                if ($model->status !== DealStatus::lost && $model->isDirty('lost_reason')) {
                    $model->fill(['lost_reason' => $model->getOriginal('lost_reason')]);
                }
            }
        });

        static::updated(function ($model) {
            if ($model->wasChanged('status')) {
                if ($model->status === DealStatus::won || $model->status === DealStatus::lost) {
                    $model->stopLastStageTiming();
                } else {
                    // changed to open
                    $model->startStageHistory();
                }
            }

            if ($model->wasChanged('stage_id') && $model->status === DealStatus::open) {
                $model->recordStageHistory($model->stage_id);
            }
        });

        static::deleting(function ($model) {
            if ($model->isForceDeleting()) {
                $model->purge();
            } else {
                $model->logRelatedIsTrashed(['contacts', 'companies'], [
                    'key' => 'core::timeline.associate_trashed',
                    'attrs' => ['displayName' => $model->display_name],
                ]);
            }
        });
    }

    /**
     * Check whether the falls behind the expected close date
     */
    public function fallsBehindExpectedCloseDate(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->expected_close_date || $this->status !== DealStatus::open) {
                return false;
            }

            return $this->expected_close_date->isPast();
        });
    }

    /**
     * Mark the deal as lost
     */
    public function markAsLost(?string $reason = null): static
    {
        if ($reason) {
            $this->lost_reason = $reason;
        }

        $this->status = DealStatus::lost;
        $this->save();

        $activity = $this->logStatusChangeActivity('marked_as_lost', ['reason' => $this->lost_reason]);

        $attrs = [$this->id, static::class, $activity->getKey(), $activity::class];

        (new PinnedTimelineSubject())->pin(...$attrs);

        return $this;
    }

    /**
     * Mark the deal as wont
     */
    public function markAsWon(): static
    {
        $this->status = DealStatus::won;
        $this->save();

        $this->logStatusChangeActivity('marked_as_won');

        return $this;
    }

    /**
     * Mark the deal as open
     */
    public function markAsOpen(): static
    {
        $this->status = DealStatus::open;
        $this->save();
        $this->logStatusChangeActivity('marked_as_open');

        return $this;
    }

    /**
     * Change the deal status
     */
    public function changeStatus(DealStatus $status, ?string $lostReason = null): static
    {
        return match ($status) {
            DealStatus::won => $this->markAsWon(),
            DealStatus::lost => $this->markAsLost($lostReason),
            DealStatus::open => $this->markAsOpen(),
        };
    }

    /**
     * Log status change activity for the deal
     *
     * @return \Modules\Core\Models\Changelog
     */
    protected function logStatusChangeActivity(string $langKey, array $attrs = [])
    {
        return ChangeLogger::onModel($this, [
            'lang' => [
                'key' => 'deals::deal.timeline.'.$langKey,
                'attrs' => $attrs,
            ],
        ])->log();
    }

    /**
     * Get the pipeline that belongs to the deal.
     */
    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(\Modules\Deals\Models\Pipeline::class);
    }

    /**
     * Get the stage that belongs to the deal.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    /**
     * Get the stages history the deal has been.
     */
    public function stagesHistory(): BelongsToMany
    {
        return $this->belongsToMany(Stage::class, 'deal_stages_history')
            ->withPivot(['id', 'entered_at', 'left_at'])
            ->using(\Modules\Deals\Models\StageHistory::class)
            ->orderBy('entered_at', 'desc')
            ->as('history');
    }

    /**
     * Get the stages history with time in
     */
    public function timeInStages(): Collection
    {
        return $this->stagesHistory->groupBy('id')->map(function ($stages) {
            return $stages->reduce(function ($carry, $stage) {
                // If left_at is null, is using the current time
                $carry += $stage->history->entered_at->diffInSeconds($stage->history->left_at);

                return $carry;
            }, 0);
        });
    }

    /**
     * Start start history from the deal current stage
     */
    public function startStageHistory(): static
    {
        $this->recordStageHistory($this->stage_id);

        return $this;
    }

    /**
     * Get the deal last stage history
     */
    public function lastStageHistory(): ?Stage
    {
        return $this->stagesHistory()->first();
    }

    /**
     * Stop the deal last stage timing
     */
    public function stopLastStageTiming(): static
    {
        $latest = $this->lastStageHistory();

        if ($latest && is_null($latest['history']['left_at'])) {
            $this->stagesHistory()
                ->wherePivot('id', $latest->history->id)
                ->updateExistingPivot($latest->history->stage_id, ['left_at' => now()]);
        }

        return $this;
    }

    /**
     * Record stage history
     */
    public function recordStageHistory(int $stageId): static
    {
        $this->stopLastStageTiming();
        $this->stagesHistory()->attach($stageId, ['entered_at' => now()]);

        return $this;
    }

    /**
     * Get all of the contacts that are associated with the deal
     */
    public function contacts(): MorphToMany
    {
        return $this->morphedByMany(\Modules\Contacts\Models\Contact::class, 'dealable')
            ->withTimestamps()
            ->orderBy('dealables.created_at');
    }

    /**
     * Get all of the companies that are associated with the deal
     */
    public function companies(): MorphToMany
    {
        return $this->morphedByMany(\Modules\Contacts\Models\Company::class, 'dealable')
            ->withTimestamps()
            ->orderBy('dealables.created_at');
    }

    /**
     * Get all of the notes for the deal
     */
    public function notes(): MorphToMany
    {
        return $this->morphToMany(\Modules\Notes\Models\Note::class, 'noteable');
    }

    /**
     * Get all of the calls for the deal
     */
    public function calls(): MorphToMany
    {
        return $this->morphToMany(\Modules\Calls\Models\Call::class, 'callable');
    }

    /**
     * Get the deal owner
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\Modules\Users\Models\User::class);
    }

    /**
     * Get the model display name
     */
    public function displayName(): Attribute
    {
        return Attribute::get(fn () => $this->name);
    }

    /**
     * Get the URL path
     */
    public function path(): Attribute
    {
        return Attribute::get(fn () => "/deals/{$this->id}");
    }

    /**
     * Provide the total column to be updated whenever the billable is updated
     */
    public function totalColumn(): string
    {
        return 'amount';
    }

    /**
     * Get the channels that model events should broadcast on.
     *
     * @param  string  $event
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn($event)
    {
        // We will broadcast only when stage is changed when the update
        // comes from the custom broadcast event in "BoardUpdater"
        if ($this->boardFiresEvents && ! $this->isDirty('stage_id')) {
            return [];
        }

        // Currently only the updated event is used
        return match ($event) {
            'updated' => [new PrivateChannel($this)],
            default => null,
        };
    }

    /**
     * Broadcast to current user when updated
     */
    public function broadcastToCurrentUser(): static
    {
        $this->broadcastToCurrentUser = true;

        return $this;
    }

    /**
     * Create a new broadcastable model event for the model.
     *
     * @return \Illuminate\Database\Eloquent\BroadcastableModelEventOccurred
     */
    protected function newBroadcastableEvent(string $event)
    {
        $instance = (new BroadcastableModelEventOccurred(
            $this,
            $event
        ));

        if ($this->broadcastToCurrentUser) {
            return $instance;
        }

        return $instance->dontBroadcastToCurrentUser();
    }

    /**
     * Get the data to broadcast for the model.
     *
     * @param  string  $event
     */
    public function broadcastWith($event): array
    {
        return [];
    }

    /**
     * Scope a query to only include open deals.
     */
    public function scopeWon(Builder $query): void
    {
        $query->where('status', DealStatus::won);
    }

    /**
     * Scope a query to only include open deals.
     */
    public function scopeOpen(Builder $query): void
    {
        $query->where('status', DealStatus::open);
    }

    /**
     * Scope a query to only include lost deals.
     */
    public function scopeLost(Builder $query): void
    {
        $query->where('status', DealStatus::lost);
    }

    /**
     * Scope a query to only include closed deals.
     */
    public function scopeClosed(Builder $query): void
    {
        $query->where('status', DealStatus::won)->orWhere('status', DealStatus::lost);
    }

    /**
     * Eager load the relations that are required for the front end response.
     */
    public function scopeWithCommon(Builder $query): void
    {
        $query->withCount(['calls', 'notes'])->with([
            'changelog',
            'changelog.pinnedTimelineSubjects',
            'stagesHistory',
            'media',
            'contacts.phones', // for calling
            'companies.phones', // for calling
            'billable',
            'billable.products',
            'billable.products.originalProduct',
            'billable.products.billable',
            'pipeline.stages' => function ($query) {
                $query->orderByDisplayOrder();
            },
        ]);
    }

    /**
     * Purge the model data.
     */
    public function purge(): void
    {
        foreach (['emails', 'contacts', 'companies', 'activities', 'documents'] as $relation) {
            tap($this->{$relation}(), function ($query) {
                if ($query->getModel()->usesSoftDeletes()) {
                    $query->withTrashed();
                }

                $query->detach();
            });
        }

        if ($this->billable) {
            $this->billable->delete();
        }

        $this->notes->each->delete();
        $this->calls->each->delete();
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): DealFactory
    {
        return DealFactory::new();
    }
}
