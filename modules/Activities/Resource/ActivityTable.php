<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Resource;

use Modules\Core\Actions\ForceDeleteAction;
use Modules\Core\Actions\RestoreAction;
use Modules\Core\Table\Table;

class ActivityTable extends Table
{
    // Policy
    protected array $with = ['guests'];

    /**
     * Indicates whether the user can customize columns orders and visibility
     */
    public bool $customizeable = true;

    /**
     * Additional fields to be selected with the query
     */
    public function addSelect(): array
    {
        return [
            'user_id', // is for the policy checks
            'completed_at', // see appends below
            'due_time', // for displaying in the due date column
            'end_time', // for displaying in the due date column
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
     * Provide the attributes that should be appended within the response
     */
    protected function appends(): array
    {
        return [
            'is_completed', // for state change
            'is_due', // row class
        ];
    }

    /**
     * Boot table
     */
    public function boot(): void
    {
        $this->orderBy('created_at', 'desc');
    }
}
