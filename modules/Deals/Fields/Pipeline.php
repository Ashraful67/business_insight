<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Fields;

use Modules\Core\Fields\BelongsTo;
use Modules\Core\Rules\VisibleModelRule;
use Modules\Deals\Http\Resources\PipelineResource;
use Modules\Deals\Models\Pipeline as PipelineModel;

class Pipeline extends BelongsTo
{
    /**
     * Creat new Pipeline instance field
     *
     * @param  string  $label Custom label
     */
    public function __construct($label = null)
    {
        parent::__construct('pipeline', PipelineModel::class, $label ?: __('deals::fields.deals.pipeline.name'));

        $this->setJsonResource(PipelineResource::class)
            ->rules(new VisibleModelRule(new PipelineModel))
            ->emitChangeEvent()
            ->withDefaultValue(function () {
                return PipelineModel::withCommon()
                    ->visible()
                    ->userOrdered()
                    ->first();
            })
            ->acceptLabelAsValue();
    }

    /**
     * Provides the BelongsTo instance options
     *
     * @return \Illuminate\Eloquent\Collection
     */
    public function resolveOptions()
    {
        return PipelineModel::select(['id', 'name'])
            ->with('stages')
            ->visible()
            ->userOrdered()
            ->get();
    }
}
