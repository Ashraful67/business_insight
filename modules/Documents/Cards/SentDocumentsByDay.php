<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Cards;

use Illuminate\Http\Request;
use Modules\Core\Charts\Progression;
use Modules\Documents\Models\Document;
use Modules\Users\Criteria\ManagesOwnerTeamCriteria;
use Modules\Users\Criteria\QueriesByUserCriteria;

class SentDocumentsByDay extends Progression
{
    /**
     * Calculates sent documents by day
     *
     * @return mixed
     */
    public function calculate(Request $request)
    {
        /** @var \Modules\Users\Models\User */
        $user = $request->user();

        $query = (new Document)->newQuery()->when($user->cant('view all documents'), function ($query) use ($user) {
            if ($user->can('view team documents')) {
                $query->criteria(new ManagesOwnerTeamCriteria($user));
            } else {
                $query->criteria(new QueriesByUserCriteria($user));
            }
        });

        if ($filterByUser = $this->getUser()) {
            $query->criteria(new QueriesByUserCriteria($filterByUser));
        }

        return $this->countByDays($request, $query, 'original_date_sent');
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
            60 => __('core::dates.periods.60_days'),
        ];
    }

    /**
     * The card name
     */
    public function name(): string
    {
        return __('documents::document.cards.sent_by_day');
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
        return request()->user()->canAny(['view all documents', 'view team documents']);
    }
}
