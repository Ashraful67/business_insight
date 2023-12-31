<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\ApiController;
use Modules\MailClient\Http\Resources\EmailAccountResource;
use Modules\MailClient\Models\EmailAccount;

class SharedEmailAccountController extends ApiController
{
    /**
     * Display shared email accounts.
     */
    public function __invoke(): JsonResponse
    {
        $accounts = EmailAccount::withCommon()
            ->shared()
            ->orderBy('email')
            ->get();

        return $this->response(
            EmailAccountResource::collection($accounts)
        );
    }
}