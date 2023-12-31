<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Modules\Core\Http\Controllers\ApiController;
use Modules\MailClient\Console\Commands\EmailAccountsSyncCommand;
use Modules\MailClient\Http\Resources\EmailAccountResource;
use Modules\MailClient\Models\EmailAccount;
use Modules\MailClient\Synchronization\Exceptions\SynchronizationInProgressException;

class EmailAccountSync extends ApiController
{
    /**
     * Invoke synchronization for the given email account.
     *
     * @throws \Modules\MailClient\Synchronization\Exceptions\SynchronizationInProgressException
     */
    public function __invoke(string $accountId): JsonResponse
    {
        $this->authorize('view', EmailAccount::findOrFail($accountId));

        $exitCode = Artisan::call(EmailAccountsSyncCommand::class, [
            '--account' => $accountId,
            '--broadcast' => false,
            '--isolated' => 5,
        ]);

        if ($exitCode === 5) {
            throw new SynchronizationInProgressException;
        }

        return $this->response(
            new EmailAccountResource(
                EmailAccount::withCommon()->find($accountId)
            )
        );
    }
}
