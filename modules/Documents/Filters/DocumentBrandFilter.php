<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Filters;

use Modules\Brands\Models\Brand;
use Modules\Core\Filters\MultiSelect;

class DocumentBrandFilter extends MultiSelect
{
    /**
     * Create new DocumentBrandFilter instance
     */
    public function __construct()
    {
        parent::__construct('brand_id', __('documents::fields.documents.brand.name'));

        $this->labelKey('name')
            ->valueKey('id')
            ->options(
                fn () => Brand::select(['id', 'name'])
                    ->orderBy('is_default', 'desc')
                    ->visible()
                    ->orderBy('name')
                    ->get()
            );
    }
}
