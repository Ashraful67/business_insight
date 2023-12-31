<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Fields;

use Modules\Core\Fields\BelongsTo;
use Modules\Deals\Http\Resources\StageResource;
use Modules\Deals\Models\Pipeline;
use Modules\Deals\Models\Stage;

class PipelineStage extends BelongsTo
{
    /**
     * Field component
     *
     * @var string
     */
    public ?string $component = 'pipeline-stage-field';

    /**
     * Creat new PipelineStage instance field
     *
     * @param  string|null  $label
     */
    public function __construct($label = null)
    {
        parent::__construct('stage', Stage::class, $label ?: __('deals::fields.deals.stage.name'));

        $this->setJsonResource(StageResource::class)
            ->creationRules('required')
            ->updateRules(['required_with:pipeline_id', 'filled'])
            ->rules(function ($attribute, $value, $fail) {
                // If no value, fails on the required rule
                if ($value && is_null(Pipeline::visible()
                    ->whereHas('stages', fn ($query) => $query->where('id', $value))
                    ->first())) {
                    $fail('The :attribute value is forbidden.');
                }
            })
            ->withDefaultValue(function () {
                // First visible/ordered pipeline is selected for the Pipeline fiel as well
                // in this case, we will use the same first pipeline to retrieve the first stage
                return Pipeline::with(['stages' => fn ($query) => $query->orderByDisplayOrder()])
                    ->visible()
                    ->userOrdered()
                    ->first()->stages->first();
            })
            ->required()
            ->acceptLabelAsValue();
    }

    /**
     * Provides the PipelineStage instance options
     *
     * We using dependable field, we need to provide all the options
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function resolveOptions()
    {
        return Stage::orderBy('display_order')->get();
    }
}
