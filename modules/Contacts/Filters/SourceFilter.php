<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Filters;

use Modules\Contacts\Models\Source as SoruceModel;
use Modules\Core\Facades\Innoclapps;
use Modules\Core\Filters\Select;

class SourceFilter extends Select
{
    /**
     * Initialize Source class
     */
    public function __construct()
    {
        parent::__construct('source_id', __('contacts::fields.companies.source.name'));

        $this->withNullOperators()
            ->valueKey('id')
            ->labelKey('name')
            ->options(Innoclapps::resourceByModel(SoruceModel::class));
    }
}
