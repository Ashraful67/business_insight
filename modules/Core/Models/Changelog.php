<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Models;

use Modules\Core\Timeline\Timelineable;
use Spatie\Activitylog\Models\Activity as SpatieActivityLog;

class Changelog extends SpatieActivityLog
{
    use Timelineable;

    /**
     * Latests saved activity
     *
     * @var null|\Modules\Core\Models\Changelog
     */
    public static $latestSavedLog;

    /**
     * Causer names cache, when importing a lot data helps making hundreds of queries.
     */
    protected static array $causerNames = [];

    /**
     * Boot the model
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        /**
         * Automatically set the causer name if the logged in
         * user is set and no causer name provided
         */
        static::creating(function ($model) {
            if (! $model->causer_name) {
                $model->causer_name = static::causerName($model);
            }
        });

        static::created(function ($model) {
            static::$latestSavedLog = $model;
        });
    }

    /**
     * Get the causer name for the given model
     *
     * @param  \Modules\Core\Models\Changelog  $model
     * @return string|null
     */
    protected static function causerName($model)
    {
        if ($model->causer_id) {
            if (isset(static::$causerNames[$model->causer_id])) {
                return static::$causerNames[$model->causer_id];
            }

            return static::$causerNames[$model->causer_id] = $model->causer?->name;
        }

        return auth()->user()?->name;
    }

    /**
     * Get the relation name when the model is used as activity
     */
    public function getTimelineRelation(): string
    {
        return 'changelog';
    }

    /**
     * Get the activity front-end component
     */
    public function getTimelineComponent(): string
    {
        return $this->identifier;
    }
}
