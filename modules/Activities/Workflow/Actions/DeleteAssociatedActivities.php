<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Workflow\Actions;

use Modules\Core\Workflow\Action;

class DeleteAssociatedActivities extends Action
{
    /**
     * Action name
     */
    public static function name(): string
    {
        return __('deals::deal.workflows.actions.delete_associated_activities');
    }

    /**
     * Run the trigger.
     *
     * @return void
     */
    public function run()
    {
        $this->model->incompleteActivities->each->delete();
    }

    /**
     * Action available fields
     */
    public function fields(): array
    {
        return [];
    }
}
