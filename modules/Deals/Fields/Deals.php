<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Fields;

use Modules\Core\Fields\MorphToMany;
use Modules\Deals\Http\Resources\DealResource;

class Deals extends MorphToMany
{
    /**
     * Field order
     *
     * @var int
     */
    public ?int $order = 999;

    /**
     * Create new instance of Deals field
     *
     * @param  string  $relation
     * @param  string  $label Custom label
     */
    public function __construct($relation = 'deals', $label = null)
    {
        parent::__construct($relation, $label ?? __('deals::deal.deals'));

        $this->setJsonResource(DealResource::class)
            ->labelKey('name')
            ->valueKey('id')
            ->excludeFromExport()
            ->excludeFromImport()
            ->tapIndexColumn(function ($column) {
                if (! $this->counts()) {
                    $column->useComponent('table-data-presentable-column');
                }
            })
            ->excludeFromZapierResponse()
            ->async('/deals/search')
            ->lazyLoad('/deals', ['order' => 'created_at|desc'])
            ->provideSampleValueUsing(fn () => [1, 2]);
    }
}
