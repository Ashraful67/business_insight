<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core;

trait HasHelpText
{
    /**
     * Help text
     */
    public ?string $helpText = null;

    /**
     * Set filter help text
     */
    public function help(?string $text): static
    {
        $this->helpText = $text;

        return $this;
    }
}
