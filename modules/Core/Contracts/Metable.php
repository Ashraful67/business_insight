<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts;

interface Metable
{
    /**
     * Add or update the value of the `Meta` at a given key.
     *
     * @param  mixed  $value
     */
    public function setMeta(string $key, $value): void;

    /**
     * Check if a `Meta` has been set at a given key.
     */
    public function hasMeta(string $key): bool;

    /**
     * Delete the `Meta` at a given key.
     */
    public function removeMeta(string $key): void;

    /**
     * Retrieve the value of the `Meta` at a given key.
     *
     * @param  mixed  $default Fallback value if no Meta is found.
     * @return mixed
     */
    public function getMeta(string $key, $default = null);
}
