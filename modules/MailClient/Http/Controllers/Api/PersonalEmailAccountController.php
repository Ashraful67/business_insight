<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ApiController;
use Modules\MailClient\Http\Resources\EmailAccountResource;
use Modules\MailClient\Models\EmailAccount;

class PersonalEmailAccountController extends ApiController
{
    /**
     * Display personal email accounts for the logged in user.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $accounts = EmailAccount::withCommon()
            ->personal((int) $request->user()->id)
            ->orderBy('email')
            ->get();

        return $this->response(
            EmailAccountResource::collection($accounts)
        );
    }
}
