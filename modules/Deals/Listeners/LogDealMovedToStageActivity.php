<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Listeners;

use Modules\Core\Facades\ChangeLogger;
use Modules\Deals\Events\DealMovedToStage;

class LogDealMovedToStageActivity
{
    /**
     * Log deal stage activity when a stage is changed.
     */
    public function handle(DealMovedToStage $event): void
    {
        ChangeLogger::generic()->on($event->deal)->withProperties(
            $this->logProperties($event)
        )->log();
    }

    /**
     * Get the log properties.
     */
    protected function logProperties(DealMovedToStage $event): array
    {
        return [
            'icon' => 'Plus',
            'lang' => [
                'key' => 'deals::deal.timeline.stage.moved',
                'attrs' => [
                    // Name will be replace in the front end from causer_name
                    // saves some database entries duplication
                    'user' => null,
                    'previous' => $event->previousStage->name,
                    'stage' => $event->deal->stage->name,
                ],
            ],
        ];
    }
}
