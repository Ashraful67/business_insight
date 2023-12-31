<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Resource\Http;

use Modules\Core\Fields\FieldsCollection;

class CreateResourceRequest extends ResourcefulRequest
{
    /**
     * Get the fields for the current request.
     */
    public function fields(): FieldsCollection
    {
        return $this->resource()->resolveCreateFields();
    }
}
