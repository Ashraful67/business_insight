<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Resource;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Export\ExportViaFields;
use Modules\Core\Fields\FieldsCollection;

class Export extends ExportViaFields
{
    /**
     * Export chunk size.
     */
    public static int $chunkSize = 500;

    /**
     * Create new Export instance.
     */
    public function __construct(protected Resource $resource, protected Builder $query)
    {
    }

    /**
     * Provides the export data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        [$with, $withCount] = $this->resource->getEagerLoadable($this->fields());

        return $this->query->withCount($withCount->all())
            ->with($with->all())
            ->lazy(static::$chunkSize);
    }

    /**
     * Provides the resource available fields.
     */
    public function fields(): FieldsCollection
    {
        return $this->resource->resolveFields();
    }

    /**
     * The export file name (without extension)
     */
    public function fileName(): string
    {
        return $this->resource->name();
    }
}
