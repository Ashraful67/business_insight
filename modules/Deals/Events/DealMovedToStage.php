<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Deals\Models\Deal;
use Modules\Deals\Models\Stage;

class DealMovedToStage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create new DealMovedToStage instance.
     */
    public function __construct(public Deal $deal, public Stage $previousStage)
    {
    }
}
