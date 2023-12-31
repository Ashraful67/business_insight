<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Cards;

use Illuminate\Http\Request;
use Modules\Core\Charts\Progression;
use Modules\Deals\Models\Deal;
use Modules\Users\Criteria\ManagesOwnerTeamCriteria;
use Modules\Users\Criteria\QueriesByUserCriteria;

class WonDealsByMonth extends Progression
{
    /**
     * Calculates won deals by day
     *
     * @return mixed
     */
    public function calculate(Request $request)
    {
        /** @var \Modules\Users\Models\User */
        $user = $request->user();

        $query = Deal::won()->when($user->cant('view all deals'), function ($query) use ($user) {
            if ($user->can('view team deals')) {
                $query->criteria(new ManagesOwnerTeamCriteria($user));
            } else {
                $query->criteria(new QueriesByUserCriteria($user));
            }
        });

        if ($filterByUser = $this->getUser()) {
            $query->criteria(new QueriesByUserCriteria($filterByUser));
        }

        return $this->countByMonths($request, $query, 'won_date');
    }

    /**
     * Get the ranges available for the chart.
     */
    public function ranges(): array
    {
        return [
            3 => __('core::dates.periods.last_3_months'),
            6 => __('core::dates.periods.last_6_months'),
            12 => __('core::dates.periods.last_12_months'),
        ];
    }

    /**
     * The card name
     */
    public function name(): string
    {
        return __('deals::deal.cards.won_by_month');
    }

    /**
     * Get the user for the card query
     */
    protected function getUser(): ?int
    {
        if ($this->canViewOtherUsersCardData()) {
            return request()->filled('user_id') ? request()->integer('user_id') : null;
        }

        return null;
    }

    public function canViewOtherUsersCardData(): bool
    {
        return request()->user()->canAny(['view all deals', 'view team deals']);
    }
}
