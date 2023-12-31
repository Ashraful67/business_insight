<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Deals\Models\Stage;

class SummaryService
{
    /**
     * Get the deals summary (by stage)
     */
    public function calculate(Builder $query, ?int $pipelineId = null): Collection
    {
        $stages = Stage::select(['id', 'win_probability'])
            ->when(! is_null($pipelineId), function ($query) use ($pipelineId) {
                $query->where('pipeline_id', $pipelineId);
            })->get();

        return $stages->mapWithKeys(function ($stage) use ($query) {
            return [$stage->id => [
                'count' => (int) $query->clone()->where('stage_id', $stage->id)->count(),
                'value' => (float) $sum = $query->clone()->where('stage_id', $stage->id)->sum('amount'),
                // Not applicable when the user is filtering won or lost deals
                'weighted_value' => $stage->win_probability * $sum / 100,
            ]];
        });
    }
}
