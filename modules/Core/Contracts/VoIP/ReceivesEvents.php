<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\VoIP;

use Illuminate\Http\Request;

interface ReceivesEvents
{
    /**
     * Set the call events URL
     *
     * @param  string  $url The URL the client events webhook should be pointed to
     */
    public function setEventsUrl(string $url): static;

    /**
     * Handle the VoIP service events request
     *
     *
     * @return mixed
     */
    public function events(Request $request);
}
