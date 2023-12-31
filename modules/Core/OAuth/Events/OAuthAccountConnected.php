<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\OAuth\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Core\Models\OAuthAccount;

class OAuthAccountConnected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create new instance of OAuthAccountConnected.
     */
    public function __construct(public OAuthAccount $account)
    {
    }
}
