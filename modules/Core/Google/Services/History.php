<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Google\Services;

use Google\Client;

class History extends Service
{
    /**
     * Initialize new History service instance.
     */
    public function __construct(Client $client)
    {
        parent::__construct($client, \Google\Service\Gmail::class);
    }

    /**
     * https://developers.google.com/gmail/api/v1/reference/users/history/list
     *
     * Get the Gmail account history
     *
     * @param  array  $params Additional params for the request
     * @return \Google\Service\Gmail\History
     */
    public function get($params = [])
    {
        /** @var \Google\Service\Gmail\History */
        $service = $this->service;

        return $service->users_history->listUsersHistory('me', $params);
    }
}
