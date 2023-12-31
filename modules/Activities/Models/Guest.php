<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\Model;

class Guest extends Model
{
    use SoftDeletes;

    public function guestable(): MorphTo
    {
        return $this->morphTo();
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(\Modules\Activities\Models\Activity::class, 'activity_guest');
    }
}
