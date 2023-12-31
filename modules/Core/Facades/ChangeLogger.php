<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Changelog\Logging as BaseLogging;

/**
 * @mixin \Modules\Core\Changelog\Logging
 */
class ChangeLogger extends Facade
{
    /**
     * Indicates the model log name
     */
    const MODEL_LOG_NAME = 'model';

    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return BaseLogging::class;
    }
}
