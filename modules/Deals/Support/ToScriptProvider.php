<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Support;

use Illuminate\Support\Facades\Auth;
use Modules\Deals\Http\Resources\LostReasonResource;
use Modules\Deals\Http\Resources\PipelineResource;
use Modules\Deals\Models\LostReason;
use Modules\Deals\Models\Pipeline;

class ToScriptProvider
{
    /**
     * Provide the data to script.
     */
    public function __invoke(): array
    {
        if (! Auth::check()) {
            return [];
        }

        return [
            'options' => [
                'allow_lost_reason_enter' => settings('allow_lost_reason_enter'),
                'lost_reason_is_required' => settings('lost_reason_is_required'),
            ],

            'deal_fields_height' => settings('deal_fields_height'),

            'deals' => [
                'pipelines' => PipelineResource::collection(
                    Pipeline::withCommon()
                        ->withVisibilityGroups()
                        ->visible()
                        ->userOrdered()
                        ->get()
                ),
                'lost_reasons' => LostReasonResource::collection(
                    LostReason::withCommon()->orderBy('name')->get()
                ),
            ], ];
    }
}
