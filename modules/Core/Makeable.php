<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core;

trait Makeable
{
    /**
     * Create new instance
     *
     * @param  array  $params
     */
    public static function make(...$params): static
    {
        return new static(...$params);
    }
}
