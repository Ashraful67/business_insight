<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\OAuth;

interface StateStorage
{
    /**
     * Get state from storage.
     */
    public function get(): ?string;

    /**
     * Put state in storage.
     *
     * @param  string  $value
     */
    public function put($value): void;

    /**
     * Check whether there is stored state.
     */
    public function has(): bool;

    /**
     * Forget the remembered state from storage.
     */
    public function forget(): void;
}
