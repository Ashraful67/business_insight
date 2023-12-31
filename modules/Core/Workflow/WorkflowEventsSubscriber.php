<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Workflow;

use Illuminate\Events\Dispatcher;
use Modules\Core\Models\Workflow;

class WorkflowEventsSubscriber
{
    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events)
    {
        foreach (Workflows::$eventOnlyListeners as $data) {
            $events->listen($data['event'], function ($event) use ($data) {
                $workflows = Workflow::byTrigger($data['trigger'])->get();

                foreach ($workflows as $workflow) {
                    Workflows::process($workflow, ['event' => $event]);
                }
            });
        }
    }
}
