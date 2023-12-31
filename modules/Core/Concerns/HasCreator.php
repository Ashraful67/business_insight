<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/** @mixin \Modules\Core\Models\Model */
trait HasCreator
{
    /**
     * Boot HasCreator trait
     */
    protected static function bootHasCreator(): void
    {
        static::creating(function ($model) {
            $foreignKeyName = (new static)->creator()->getForeignKeyName();

            if (! $model->{$foreignKeyName} && Auth::check()) {
                $model->{$foreignKeyName} = Auth::id();
            }
        });
    }

    /**
     * A model has creator.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(\Modules\Users\Models\User::class, 'created_by');
    }
}
