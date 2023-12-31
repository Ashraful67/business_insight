<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Core\Models\Synchronization;

/** @mixin \Modules\Core\Models\Model */
trait Synchronizable
{
    /**
     * Get the synchronizable synchronizer class
     *
     * @return \Modules\Core\Contracts\Synchronization\Synchronizable
     */
    abstract public function synchronizer();

    /**
     * Boot the Synchronizable trait
     *
     * @return void
     */
    public static function bootSynchronizable()
    {
        // Start a new synchronization once created.
        static::created(function ($synchronizable) {
            $synchronizable->synchronization()->create();
        });

        // Stop and delete associated synchronization.
        static::deleting(function ($synchronizable) {
            $synchronizable->synchronization->delete();
        });
    }

    /**
     * Get the model synchronization model
     */
    public function synchronization(): MorphOne
    {
        return $this->morphOne(Synchronization::class, 'synchronizable');
    }
}
