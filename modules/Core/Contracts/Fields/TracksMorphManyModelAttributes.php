<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Fields;

interface TracksMorphManyModelAttributes
{
    /**
     * Get the attributes the changes should be tracked on.
     */
    public function trackAttributes(): array|string;
}
