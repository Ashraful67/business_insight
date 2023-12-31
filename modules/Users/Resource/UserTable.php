<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Resource;

use Modules\Core\Table\BelongsToManyColumn;
use Modules\Core\Table\BooleanColumn;
use Modules\Core\Table\Column;
use Modules\Core\Table\DateTimeColumn;
use Modules\Core\Table\ID;
use Modules\Core\Table\LengthAwarePaginator;
use Modules\Core\Table\Table;

class UserTable extends Table
{
    /**
     * Additional relations to eager load on every query.
     */
    protected array $with = ['teams', 'managedTeams'];

    /**
     * Indicates whether the user can customize columns orders and visibility
     */
    public bool $customizeable = true;

    /**
     * Provides table available default columns
     */
    public function columns(): array
    {
        return [
            ID::make(__('core::app.id')),

            Column::make('name', __('users::user.name'))->minWidth('200px'),

            Column::make('email', __('users::user.email'))
                ->queryWhenHidden(),

            BelongsToManyColumn::make('roles', 'name', __('core::role.roles'))->hidden(),

            BelongsToManyColumn::make('teams', 'name', __('users::team.teams'))->hidden(),

            Column::make('timezone', __('core::app.timezone'))->hidden(),

            BooleanColumn::make('super_admin', __('users::user.super_admin')),

            BooleanColumn::make('access_api', __('core::api.access'))->hidden(),

            DateTimeColumn::make('created_at', __('core::app.created_at'))->hidden(),

            DateTimeColumn::make('updated_at', __('core::app.updated_at'))->hidden(),
        ];
    }

    /**
     * Tap the response
     */
    protected function tapResponse(LengthAwarePaginator $response): void
    {
        $response->through(function ($model) {
            $model->setRelation('teams', $model->allTeams());

            return $model;
        });
    }

    /**
     * Additional fields to be selected with the query
     */
    public function addSelect(): array
    {
        return ['avatar', 'super_admin'];
    }

    /**
     * Provide the attributes that should be appended within the response
     */
    protected function appends(): array
    {
        return ['avatar_url'];
    }

    /**
     * Boot table
     */
    public function boot(): void
    {
        $this->orderBy('name', 'asc');
    }
}
