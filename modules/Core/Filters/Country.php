<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Filters;

use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\Country as CountryModel;

class Country extends Select
{
    /**
     * Initialize new Country filter.
     */
    public function __construct()
    {
        parent::__construct('country_id', __('core::filters.country'));

        $this->valueKey('id')->labelKey('name')->options($this->countries(...));
    }

    /**
     * Get the filter countries.
     */
    public function countries(): Collection
    {
        return CountryModel::get(['id', 'name']);
    }
}
