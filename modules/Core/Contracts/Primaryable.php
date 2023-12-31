<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts;

interface Primaryable
{
    /**
     * Check whether the model is application wide default model
     */
    public function isPrimary(): bool;
}
