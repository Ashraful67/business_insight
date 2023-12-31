<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\VoIP;

use Illuminate\Support\Manager;
use Modules\Core\Contracts\VoIP\ReceivesEvents;
use Modules\Core\VoIP\Clients\Twilio;

class VoIPManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->container['config']['core.voip.client'];
    }

    /**
     * Create Twilio VoIP driver
     *
     * @return \Modules\Core\VoIP\Clients\Twilio
     */
    public function createTwilioDriver()
    {
        return new Twilio($this->container['config']['core.services.twilio']);
    }

    /**
     * Check whether the driver receives events
     *
     * @param  string|null  $driver
     * @return bool
     */
    public function shouldReceivesEvents($driver = null)
    {
        return $this->driver($driver) instanceof ReceivesEvents;
    }
}
