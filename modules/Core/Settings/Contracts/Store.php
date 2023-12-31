<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Settings\Contracts;

interface Store
{
    /**
     * Get a specific key from the settings data.
     *
     * @param  mixed  $default
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Determine if a key exists in the settings data.
     */
    public function has(string $key): bool;

    /**
     * Set a specific key to a value in the settings data.
     *
     * @param  mixed  $value
     */
    public function set(string|array $key, mixed $value = null): static;

    /**
     * Unset a key in the settings data.
     */
    public function forget(string $key): static;

    /**
     * Flushing all data.
     */
    public function flush(): static;

    /**
     * Get all settings data.
     */
    public function all(): array;

    /**
     * Save any changes done to the settings data.
     */
    public function save(): static;

    /**
     * Check if the data is saved.
     */
    public function isSaved(): bool;
}
