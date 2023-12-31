<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Concerns;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Core\Models\UserOrderedModel;
use Modules\Users\Models\User;

/** @mixin \Modules\Core\Models\Model */
trait UserOrderable
{
    /**
     * Boot the trait.
     */
    protected static function bootUserOrderable(): void
    {
        static::deleting(function ($model) {
            if (! $model->usesSoftDeletes() || $model->isForceDeleting()) {
                $model->userOrder?->delete();
            }
        });
    }

    /**
     * Get the current user model order
     */
    public function userOrder(): MorphOne
    {
        return $this->morphOne(UserOrderedModel::class, 'orderable')->where('user_id', Auth::id());
    }

    /**
     * Apply a scope query to order the records as the user specified.
     */
    public function scopeUserOrdered(Builder $query, ?User $user = null): void
    {
        $table = (new UserOrderedModel)->getTable();

        $query->select($this->prepareColumnsForUserOrderedQuery($query))
            ->leftJoin($table, function ($join) use ($query, $table, $user) {
                $orderableModel = $query->getModel();

                $join->on($table.'.orderable_id', '=', $orderableModel->getTable().'.'.$orderableModel->getKeyName())
                    ->where($table.'.orderable_type', $orderableModel::class)
                    ->where($table.'.user_id', $user ?: Auth::id());
            })
            ->orderBy($table.'.display_order', 'asc');
    }

    /**
     * Qualify the columns to avoid ambigious columns when joining.
     */
    protected function prepareColumnsForUserOrderedQuery(Builder $builder): array|string
    {
        $columns = $builder->getQuery()->columns;

        if (is_null($columns)) {
            return $builder->getModel()->getTable().'.*';
        }

        return collect($columns)->map(function ($column) use ($builder) {
            if (! Str::endsWith($column, '.*') && ! $column instanceof Expression) {
                return $builder->getModel()->qualifyColumn($column);
            }

            return $column;
        })->all();
    }
}
