<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Resource;

use Modules\Core\Contracts\Presentable;
use Modules\Core\Models\Model;

class EmailSearch extends GlobalSearch
{
    /**
     * Provide the model data for the response.
     */
    protected function data(Model&Presentable $model, Resource $resource): array
    {
        return [
            'id' => $model->getKey(),
            'address' => $model->email,
            'name' => $model->display_name,
            'path' => $model->path,
            'resourceName' => $resource->name(),
        ];
    }
}
