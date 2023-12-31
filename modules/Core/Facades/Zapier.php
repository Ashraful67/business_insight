<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Zapier\Zapier as BaseZapier;

/**
 * @method static void processQueue()
 *
 * @mixin \Modules\Core\Zapier\Zapier
 */
class Zapier extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return BaseZapier::class;
    }
}
