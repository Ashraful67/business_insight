<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Cards;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Card\Card;
use Modules\Core\Card\TableAsyncCard;
use Modules\Core\ProvidesBetweenArgumentsViaString;
use Modules\Deals\Models\Deal;
use Modules\Users\Criteria\ManagesOwnerTeamCriteria;
use Modules\Users\Criteria\QueriesByUserCriteria;

class ClosingDeals extends TableAsyncCard
{
    use ProvidesBetweenArgumentsViaString;

    /**
     * The default renge/period selected
     *
     * @var string
     */
    public string|int|null $defaultRange = 'this_month';

    /**
     * Default sort field
     */
    protected Expression|string|null $sortBy = 'expected_close_date';

    /**
     * Provide the query that will be used to retrieve the items.
     */
    public function query(): Builder
    {
        /** @var \Modules\Users\Models\User */
        $user = Auth::user();

        $query = Deal::open()->when($user->cant('view all deals'), function ($query) use ($user) {
            if ($user->can('view team deals')) {
                $query->criteria(new ManagesOwnerTeamCriteria($user));
            } else {
                $query->criteria(new QueriesByUserCriteria($user));
            }
        });

        if ($filterByUser = $this->getUser()) {
            $query->criteria(new QueriesByUserCriteria($filterByUser));
        }

        $period = $this->getBetweenArguments(request()->range ?? $this->defaultRange);

        return $query->whereNotNull('expected_close_date')->whereBetween('expected_close_date', $period);
    }

    /**
     * Provide the table fields
     */
    public function fields(): array
    {
        return [
            ['key' => 'name', 'label' => __('deals::fields.deals.name'), 'sortable' => true],
            ['key' => 'expected_close_date', 'label' => __('deals::fields.deals.expected_close_date'), 'sortable' => true],
        ];
    }

    /**
     * Get the ranges available for the chart.
     */
    public function ranges(): array
    {
        return [
            'this_week' => __('core::dates.this_week'),
            'this_month' => __('core::dates.this_month'),
            'next_week' => __('core::dates.next_week'),
            'next_month' => __('core::dates.next_month'),
        ];
    }

    /**
     * The card name
     */
    public function name(): string
    {
        return __('deals::deal.cards.closing');
    }

    /**
     * Get the user for the card query
     *
     * @return mixed
     */
    protected function getUser()
    {
        if ($this->canViewOtherUsersCardData()) {
            return request()->filled('user_id') ? request()->integer('user_id') : auth()->user();
        }
    }

    public function canViewOtherUsersCardData(): bool
    {
        return request()->user()->canAny(['view all deals', 'view team deals']);
    }
}
