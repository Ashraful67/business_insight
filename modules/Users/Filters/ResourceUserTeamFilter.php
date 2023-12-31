<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Filters\Select;
use Modules\Users\Models\Team;

class ResourceUserTeamFilter extends Select
{
    /**
     * Create new ResourceUserTeamFilter instance
     */
    public function __construct(string $label, string $userRelationship = 'user')
    {
        parent::__construct('team', $label);

        $this->valueKey('id')
            ->labelKey('name')
            ->options($this->teams(...))
            ->query(function ($builder, $value, $condition, $sqlOperator) use ($userRelationship) {
                return $builder->whereHas($userRelationship.'.teams', fn (Builder $query) => $query->where(
                    'teams.id',
                    $sqlOperator['operator'],
                    $value,
                    $condition
                ));
            });
    }

    /**
     * Get the filter teams
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function teams()
    {
        return Team::userTeams()->get(['id', 'name']);
    }
}
