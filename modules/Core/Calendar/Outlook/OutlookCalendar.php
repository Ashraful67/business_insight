<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Calendar\Outlook;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Microsoft\Graph\Model\Calendar as CalendarModel;
use Modules\Core\Contracts\OAuth\Calendarable;
use Modules\Core\Facades\MsGraph as Api;
use Modules\Core\OAuth\AccessTokenProvider;
use Modules\Core\OAuth\Exceptions\ConnectionErrorException;

class OutlookCalendar implements Calendarable
{
    /**
     * Initialize new OutlookCalendar instance.
     */
    public function __construct(protected AccessTokenProvider $token)
    {
        Api::connectUsing($token);
    }

    /**
     * Get the available calendars
     *
     * @return \Modules\Core\Contracts\Calendar\Calendar[]
     */
    public function getCalendars()
    {
        $iterator = Api::createCollectionGetRequest('/me/calendars')->setReturnType(CalendarModel::class);

        return collect($this->iterateRequest($iterator))
            ->mapInto(Calendar::class)
            ->all();
    }

    /**
     * Itereate the request pages and get all the data
     *
     * @param  \Iterator  $iterator
     * @return array
     */
    protected function iterateRequest($iterator)
    {
        try {
            return Api::iterateCollectionRequest($iterator);
        } catch (IdentityProviderException $e) {
            throw new ConnectionErrorException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
