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
use Modules\MailClient\Models\EmailAccount;

class EmailAccountPrimaryStateController extends ApiController
{
    /**
     * Mark the given account as primary for the current user.
     */
    public function update(string $id): JsonResponse
    {
        $this->authorize('view', $account = EmailAccount::findOrFail($id));

        $account->markAsPrimary(auth()->user());

        return $this->response('', 204);
    }

    /**
     * Remove primary account for the current user.
     */
    public function destroy(): JsonResponse
    {
        EmailAccount::unmarkAsPrimary(auth()->user());

        return $this->response('', 204);
    }
}
