<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core;

use Illuminate\Support\Facades\Gate;
use ReflectionClass;
use ReflectionMethod;

trait ProvidesModelAuthorizations
{
    /**
     * Get all defined authorizations for the model
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array  $without Exclude abilities from authorization
     * @return array|null
     */
    public function getAuthorizations($model, $without = [])
    {
        if ($policy = policy($model)) {
            return collect((new ReflectionClass($policy))->getMethods(ReflectionMethod::IS_PUBLIC))
                ->reject(function ($method) use ($without) {
                    return in_array($method->name, array_merge($without, ['denyAsNotFound', 'denyWithStatus', 'before']));
                })
                ->mapWithKeys(fn ($method) => [$method->name => Gate::allows($method->name, $model)])->all();
        }

        return null;
    }
}
