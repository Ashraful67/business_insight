<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts;

interface Countable
{
    /**
     * Set that the class should count
     *
     * @return self
     */
    public function count(): static;

    /**
     * Check whether the class counts
     */
    public function counts(): bool;

    /**
     * Get the count key
     */
    public function countKey(): string;
}
