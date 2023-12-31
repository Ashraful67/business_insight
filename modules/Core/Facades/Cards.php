<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Card\CardsManager;

/**
 * @method static static register(string $resourceName, mixed $provider)
 * @method static \Illuminate\Support\Collection resolve(string $resourceName)
 * @method static \Illuminate\Support\Collection forResource(string $resourceName)
 * @method static \Illuminate\Support\Collection resolveForDashboard()
 * @method static \Illuminate\Support\Collection registered()
 *
 * @mixin \Modules\Core\Card\CardsManager
 */
class Cards extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return CardsManager::class;
    }
}
