<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Menu\MenuManager;

/**
 * @method static static register(\Modules\Core\Menu\MenuItem|array $items)
 * @method static static registerItem(\Modules\Core\Menu\MenuItem $item)
 * @method static \Illuminate\Support\Collection get()
 * @method static static clear()
 *
 * @mixin \Modules\Core\Menu\MenuManager
 */
class Menu extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return MenuManager::class;
    }
}
