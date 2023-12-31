<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Resource\Http;

use Modules\Core\Fields\FieldsCollection;

class UpdateResourceRequest extends ResourcefulRequest
{
    /**
     * Get the fields for the current request.
     */
    public function fields(): FieldsCollection
    {
        $this->resource()->setModel($this->record());

        return $this->resource()->resolveUpdateFields();
    }
}
