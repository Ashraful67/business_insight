<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Permissions\PermissionsManager;

/**
 * @method static void group(string|array $group, \Closure $callback)
 * @method static array groups()
 * @method static void view(string $view, array $data)
 * @method static void createMissing(string $guard = 'api')
 * @method static array all()
 * @method static array labeled()
 * @method static void register(\Closure $callback)
 *
 * @mixin \Modules\Core\Permissions\PermissionsManager
 */
class Permissions extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return PermissionsManager::class;
    }
}
