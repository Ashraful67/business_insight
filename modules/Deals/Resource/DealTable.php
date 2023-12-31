<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Resource;

use Modules\Core\Actions\ForceDeleteAction;
use Modules\Core\Actions\RestoreAction;
use Modules\Core\Table\LengthAwarePaginator;
use Modules\Core\Table\Table;
use Modules\Deals\Criteria\ViewAuthorizedDealsCriteria;
use Modules\Deals\Models\Deal;
use Modules\Deals\Services\SummaryService;

class DealTable extends Table
{
    /**
     * Indicates whether the user can customize columns orders and visibility
     */
    public bool $customizeable = true;

    /**
     * Provide the attributes that should be appended within the response
     */
    protected function appends(): array
    {
        return [
            'falls_behind_expected_close_date', // row class
        ];
    }

    /**
     * Additional fields to be selected with the query
     */
    public function addSelect(): array
    {
        return [
            'user_id', // user_id is for the policy checks
            'expected_close_date', // falls_behind_expected_close_date check
            'status', // falls_behind_expected_close_date check
        ];
    }

    /**
     * Get the actions intended for the trashed table
     *
     * NOTE: No authorization is performed on these action, all actions will be visible to the user
     */
    public function actionsForTrashedTable(): array
    {
        return [new RestoreAction, new ForceDeleteAction];
    }

    /**
     * Tap the response
     */
    protected function tapResponse(LengthAwarePaginator $response): void
    {
        $query = Deal::criteria([
            $this->createTableRequestCriteria(),
            $this->createFilterRulesCriteria(),
            ViewAuthorizedDealsCriteria::class,
        ]);

        $summary = (new SummaryService())->calculate($query);

        $response->merge(['summary' => [
            'count' => $summary->sum('count'),
            'value' => $summary->sum('value'),
            'weighted_value' => $summary->sum('weighted_value'),
        ]]);
    }

    /**
     * Boot table
     */
    public function boot(): void
    {
        $this->orderBy('created_at', 'desc');
    }
}
