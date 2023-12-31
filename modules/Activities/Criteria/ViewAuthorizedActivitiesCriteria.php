<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Contracts\Criteria\QueryCriteria;
use Modules\Users\Criteria\QueriesByUserCriteria;
use Modules\Users\Models\User;

class ViewAuthorizedActivitiesCriteria implements QueryCriteria
{
    /**
     * Apply the criteria for the given query.
     */
    public function apply(Builder $query): void
    {
        /** @var \Modules\Users\Models\User */
        $user = Auth::user();

        $query->unless($user->can('view all activities'), function ($query) use ($user) {
            $query->where(function ($query) use ($user) {
                $query->criteria(new QueriesByUserCriteria($user));

                if ($user->can('view attends and owned activities')) {
                    $query->orWhereHas('guests', function ($query) use ($user) {
                        return $query->where('guestable_type', User::class)->where('guestable_id', $user->getKey());
                    });

                    if ($user->can('view team activities')) {
                        $this->whereTeamActivities($query, $user);
                    }
                } elseif ($user->can('view team activities')) {
                    $this->whereTeamActivities($query, $user);
                }
            });
        });
    }

    protected function whereTeamActivities(Builder $query, User $user)
    {
        $query->orWhereHas('user.teams', function ($query) use ($user) {
            $query->where('teams.user_id', $user->getKey());
        });
    }
}
