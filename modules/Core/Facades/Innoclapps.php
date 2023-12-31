<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Application;

/**
 * @method static void boot()
 * @method static void booting(callable $callback)
 * @method static void booted(callable $callback)
 * @method static string version()
 * @method static string systemName()
 * @method static \Modules\Core\Resource\Resource resourceByName(string $name)
 * @method static \Modules\Core\Resource\Resource resourceByModel(string|\Modules\Core\Models\Model $model)
 *
 * @mixin \Modules\Core\Application
 * */
class Innoclapps extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return Application::class;
    }
}
