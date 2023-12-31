<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @mixin \Modules\Core\Models\Model */
trait HasSource
{
    /**
     * An record has source
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(\Modules\Contacts\Models\Source::class);
    }
}
