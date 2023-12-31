<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\OAuth\State;

use Illuminate\Support\Manager;
use Modules\Core\OAuth\State\StorageDrivers\Session;

class StateStorageManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->container['config']['core.oauth.state.storage'];
    }

    /**
     * Create the session driver
     *
     * @return Session
     */
    public function createSessionDriver()
    {
        return new Session;
    }
}
