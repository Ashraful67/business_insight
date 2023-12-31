<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Settings\Contracts;

use Closure;

interface Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver();

    /**
     * Get all of the created "drivers".
     *
     * @return array
     */
    public function getDrivers();

    /**
     * Get a driver instance.
     *
     * @param  string|null  $driver
     * @return \Modules\Core\Settings\Contracts\Store
     */
    public function driver($driver = null);

    /**
     * Register a custom driver creator Closure.
     *
     * @param  string  $driver
     * @return static
     */
    public function extend($driver, Closure $callback);

    /**
     * Register a new store.
     *
     * @return static
     */
    public function registerStore(string $driver, array $params);
}
