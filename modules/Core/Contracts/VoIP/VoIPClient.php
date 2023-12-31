<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\VoIP;

use Illuminate\Http\Request;
use Modules\Core\VoIP\Call;

interface VoIPClient
{
    /**
     * Validate the request for authenticity
     *
     *
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function validateRequest(Request $request);

    /**
     * Create new outgoing call from request
     *
     * @param  string  $phoneNumber
     * @return mixed
     */
    public function newOutgoingCall($phoneNumber, Request $request);

    /**
     * Create new incoming call from request
     *
     *
     * @return mixed
     */
    public function newIncomingCall(Request $request);

    /**
     * Get the Call class from the given webhook request
     */
    public function getCall(Request $request): Call;
}
