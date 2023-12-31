<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Fields;

interface HandlesChangedMorphManyAttributes
{
    /**
     * Handle the attributes updated event
     */
    public function morphManyAtributesUpdated(string $relationName, array $new, array $old): void;
}
