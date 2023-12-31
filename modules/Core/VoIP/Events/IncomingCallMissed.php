<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\VoIP\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Core\VoIP\Call;

class IncomingCallMissed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create new instance of IncomingCallMissed.
     */
    public function __construct(public Call $call)
    {
    }
}
