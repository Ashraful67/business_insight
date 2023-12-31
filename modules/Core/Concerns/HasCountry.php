<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @mixin \Modules\Core\Models\Model */
trait HasCountry
{
    /**
     * A model belongs to country.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(\Modules\Core\Models\Country::class);
    }
}
