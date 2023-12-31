<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Highlights;

use Modules\Core\Highlights\Highlight;
use Modules\Core\Models\Filter;
use Modules\Deals\Criteria\ViewAuthorizedDealsCriteria;
use Modules\Deals\Models\Deal;

class OpenDeals extends Highlight
{
    /**
     * Get the highlight name
     */
    public function name(): string
    {
        return __('deals::deal.highlights.open');
    }

    /**
     * Get the highligh count
     */
    public function count(): int
    {
        return Deal::criteria(ViewAuthorizedDealsCriteria::class)->open()->count();
    }

    /**
     * Get the background color class when the highligh count is bigger then zero
     */
    public function bgColorClass(): string
    {
        return 'bg-info-500';
    }

    /**
     * Get the front-end route that the highly will redirect to
     */
    public function route(): array|string
    {
        $filter = Filter::findByFlag('open-deals');

        return [
            'name' => 'deal-index',
            'query' => [
                'filter_id' => $filter?->id,
            ],
        ];
    }
}
