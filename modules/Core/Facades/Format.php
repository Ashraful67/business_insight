<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Date\Format as BaseFormat;

/**
 * @method static string format($value, $format, ?\Modules\Core\Contracts\Localizeable $user = null)
 * @method static string dateTime($value, ?\Modules\Core\Contracts\Localizeable $user = null)
 * @method static string date($value, ?\Modules\Core\Contracts\Localizeable $user = null)
 * @method static string time($value, ?\Modules\Core\Contracts\Localizeable $user = null)
 * @method static string separateDateAndTime(string $date, string $time, ?\Modules\Core\Contracts\Localizeable $user = null)
 * @method static string|null diffForHumans($value, ?\Modules\Core\Contracts\Localizeable $user = null)
 *
 * @mixin \Modules\Core\Date\Format
 */
class Format extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return BaseFormat::class;
    }
}
