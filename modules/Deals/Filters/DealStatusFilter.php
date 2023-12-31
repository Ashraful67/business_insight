<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Filters;

use Modules\Core\Filters\Select;
use Modules\Deals\Enums\DealStatus as StatusEnum;

class DealStatusFilter extends Select
{
    /**
     * Initialize Source class
     */
    public function __construct()
    {
        parent::__construct('status', __('deals::deal.status.status'));

        $this->options(collect(StatusEnum::names())->mapWithKeys(function ($status) {
            return [$status => __('deals::deal.status.'.$status)];
        })->all());

        $this->query(function ($builder, $value, $condition, $sqlOperator) {
            return $builder->where($this->field, $sqlOperator['operator'], StatusEnum::find($value), $condition);
        });
    }
}
