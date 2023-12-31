<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Cards;

use Modules\Core\Card\TableCard;
use Modules\Core\Date\Carbon;
use Modules\Deals\Enums\DealStatus;
use Modules\Users\Models\User;

class AssignedDealsBySaleAgent extends TableCard
{

    /**
     * Provide the table items
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function items(): iterable
    {
        $range = $this->getCurrentRange(request());
        $startingDate = $this->getStartingDate($range, static::BY_MONTHS);
        $endingDate = Carbon::asAppTimezone();

        return User::withCount(['deals' => function ($query) use ($startingDate, $endingDate) {
            return $query->whereBetween('created_at', [$startingDate, $endingDate]);
        }])
            ->get()
            ->map(function ($user) use ($startingDate, $endingDate) {
                return [
                    'name' => $user->name,
                    'deals_count' => $user->deals_count,

                    'forecast_amount' => to_money(
                        $user->deals()->whereBetween('created_at', [$startingDate, $endingDate])->sum('amount')
                    )->format(),

                    'closed_amount' => to_money(
                        $user->deals()->where('status', DealStatus::won)
                            ->whereBetween('created_at', [$startingDate, $endingDate])
                            ->sum('amount')
                    )->format(),
                ];
            })->sortByDesc('deals_count')->values();
    }

    /**
     * Provide the table fields
     */
    public function fields(): array
    {
        return [
            ['key' => 'name', 'label' => __('users::user.sales_agent')],
            ['key' => 'deals_count', 'label' => __('deals::deal.total_assigned')],
            ['key' => 'forecast_amount', 'label' => __('deals::deal.forecast_amount')],
            ['key' => 'closed_amount', 'label' => __('deals::deal.closed_amount')],
        ];
    }

    /**
     * Card title
     */
    public function name(): string
    {
        return __('deals::deal.cards.assigned_by_sale_agent');
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
     * jsonSerialize
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'help' => __('deals::deal.cards.assigned_by_sale_agent_info'),
        ]);
    }
}
