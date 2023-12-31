<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Cards;

use Illuminate\Http\Request;
use Modules\Contacts\Criteria\ViewAuthorizedCompaniesCriteria;
use Modules\Contacts\Models\Company;
use Modules\Core\Charts\Progression;

class CompaniesByDay extends Progression
{
    /**
     * Calculates companies created by day
     *
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByDays($request, Company::criteria(ViewAuthorizedCompaniesCriteria::class));
    }

    /**
     * Get the ranges available for the chart.
     */
    public function ranges(): array
    {
        return [
            7 => __('core::dates.periods.7_days'),
            15 => __('core::dates.periods.15_days'),
            30 => __('core::dates.periods.30_days'),
        ];
    }

    /**
     * The card name
     */
    public function name(): string
    {
        return __('contacts::company.cards.by_day');
    }
}
