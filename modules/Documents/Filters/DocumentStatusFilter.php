<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Filters;

use Modules\Core\Filters\MultiSelect;
use Modules\Core\QueryBuilder\Parser;
use Modules\Documents\Enums\DocumentStatus;

class DocumentStatusFilter extends MultiSelect
{
    /**
     * Create new DocumentStatusFilter instance
     */
    public function __construct()
    {
        parent::__construct('status', __('documents::document.status.status'));

        $this->options(collect(DocumentStatus::cases())
            ->mapWithKeys(function ($status) {
                return [$status->value => $status->displayName()];
            })->all())->query(function ($builder, $value, $condition, $sqlOperator, $rule, Parser $parser) {
                return $parser->makeArrayQueryIn(
                    $builder,
                    $rule,
                    $sqlOperator['operator'],
                    collect($value)->map(
                        fn ($status) => DocumentStatus::tryFrom($status)
                    )->filter()->all(),
                    $condition
                );
            });
    }
}
