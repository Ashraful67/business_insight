<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Fields;

use Modules\Contacts\Http\Resources\SourceResource;
use Modules\Contacts\Models\Source as SourceModel;
use Modules\Core\Facades\Innoclapps;
use Modules\Core\Fields\BelongsTo;

class Source extends BelongsTo
{
    /**
     * Create new instance of Source field
     *
     * @param  string  $label Custom label
     */
    public function __construct($label = null)
    {
        parent::__construct('source', SourceModel::class, $label ?? __('contacts::source.source'));

        $this->setJsonResource(SourceResource::class)
            ->options(Innoclapps::resourceByModel(SourceModel::class))
            ->acceptLabelAsValue();
    }
}
