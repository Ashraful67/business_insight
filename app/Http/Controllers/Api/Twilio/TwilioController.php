<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace App\Http\Controllers\Api\Twilio;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ApiController;
use Twilio\Rest\Client;

class TwilioController extends ApiController
{
    /**
     * Retrieve available incoming phone numbers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->response(
            collect((new Client(
                $request->input('account_sid'),
                $request->input('auth_token')
            ))->incomingPhoneNumbers->read([], 50))
                ->map(function ($number) {
                    return $number->toArray();
                })->all()
        );
    }

    /**
     * Disconnect the Twilio Integration
     *
     * NOTE: We won't remove the created application SID because if the user
     * want to connect the integration again, to use the same app
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        settings()->forget('twilio_auth_token');
        settings()->forget('twilio_account_sid');
        // settings()->forget('twilio_app_sid');
        settings()->forget('twilio_number')->save();

        return $this->response('', 204);
    }
}
