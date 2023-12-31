<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api\Resource;

use Modules\Core\Contracts\Resources\Exportable;
use Modules\Core\Criteria\ExportRequestCriteria;
use Modules\Core\Criteria\FilterRulesCriteria;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Resource\Http\ResourceRequest;

class ExportController extends ApiController
{
    /**
     * Export resource data
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function handle(ResourceRequest $request)
    {
        abort_unless($request->resource() instanceof Exportable, 404);

        $this->authorize('export', $request->resource()::$model);

        $query = $request->resource()->newQuery();
        $query->criteria(new ExportRequestCriteria($request));

        if ($criteria = $request->resource()->viewAuthorizedRecordsCriteria()) {
            $query->criteria($criteria);
        }

        if ($filters = $request->filters) {
            $query->criteria(
                new FilterRulesCriteria($filters, $request->resource()->filtersForResource($request), $request)
            );
        }

        return $request->resource()
            ->exportable($query)
            ->download($request->type);
    }
}
