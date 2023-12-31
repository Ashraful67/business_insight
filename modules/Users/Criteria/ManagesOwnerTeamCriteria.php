<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Contracts\Criteria\QueryCriteria;
use Modules\Users\Models\User;

class ManagesOwnerTeamCriteria implements QueryCriteria
{
    /**
     * Initialize new ManagesOwnerTeamCriteria instance
     */
    public function __construct(protected User $user, protected string $relation = 'user')
    {
    }

    /**
     * Apply the criteria for the given query.
     */
    public function apply(Builder $model): void
    {
        $model->whereHas($this->relation.'.teams', function ($query) {
            $query->where('teams.user_id', $this->user->getKey());
        });
    }
}
