<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Criteria\RequestCriteria;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Deals\Board\Board;
use Modules\Deals\Criteria\ViewAuthorizedDealsCriteria;
use Modules\Deals\Http\Resources\DealBoardResource;
use Modules\Deals\Models\Deal;
use Modules\Deals\Models\Pipeline;

class DealBoardController extends ApiController
{
    /**
     * Get the deals initial board data.
     */
    public function board(Pipeline $pipeline, Request $request): JsonResponse
    {
        $this->authorize('view', $pipeline);

        $pages = $request->input('pages', []);

        $stages = (new Board($request))->data($this->initialQuery(), (int) $pipeline->id, $pages);

        return $this->response(DealBoardResource::collection($stages));
    }

    /**
     * Load more deals for the given stage.
     */
    public function load(Pipeline $pipeline, string $stageId, Request $request): JsonResponse
    {
        $this->authorize('view', $pipeline);

        $stage = (new Board($request))->load($this->initialQuery(), (int) $stageId);

        return $this->response(new DealBoardResource($stage));
    }

    /**
     * Update board card order and stage.
     */
    public function update(Pipeline $pipeline, Request $request): void
    {
        $this->authorize('view', $pipeline);

        $request->validate([
            // Must be present for adding/removing the color
            '*.swatch_color' => 'present|max:7',
            '*.id' => 'required',
            '*.stage_id' => 'required',
            '*.board_order' => 'required',
        ]);

        (new Board($request))->update($request->input());
    }

    /**
     * Get the deals board summary for the given pipeline.
     */
    public function summary(Pipeline $pipeline, Request $request): JsonResponse
    {
        $this->authorize('view', $pipeline);

        return $this->response(
            (new Board($request))->summary($this->initialQuery(), (int) $pipeline->id)
        );
    }

    protected function initialQuery()
    {
        return Deal::criteria([
            ViewAuthorizedDealsCriteria::class,
            RequestCriteria::class,
        ]);
    }
}
