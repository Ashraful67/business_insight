<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Calendar\Google;

use Google\Service\Exception as GoogleServiceException;
use Modules\Core\Calendar\Exceptions\UnauthorizedException;
use Modules\Core\Contracts\OAuth\Calendarable;
use Modules\Core\Facades\Google as Client;
use Modules\Core\OAuth\AccessTokenProvider;

class GoogleCalendar implements Calendarable
{
    /**
     * Initialize new GoogleCalendar instance.
     */
    public function __construct(protected AccessTokenProvider $token)
    {
        Client::connectUsing($token->getEmail());
    }

    /**
     * Get the available calendars.
     *
     * @return \Modules\Core\Contracts\Calendar\Calendar[]
     */
    public function getCalendars()
    {
        try {
            return collect(Client::calendar()->list())
                ->mapInto(Calendar::class)
                ->all();
        } catch (GoogleServiceException $e) {
            $message = $e->getErrors()[0]['message'] ?? $e->getMessage();

            if ($e->getCode() == 403) {
                throw new UnauthorizedException($message, $e->getCode(), $e);
            }

            throw $e;
        }
    }
}
