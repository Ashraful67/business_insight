<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Listeners;

use Modules\Core\OAuth\Events\OAuthAccountDeleting;
use Modules\Core\Synchronization\SyncState;
use Modules\MailClient\Models\EmailAccount;

class StopRelatedOAuthEmailAccounts
{
    /**
     * Stop the related email accounts of the OAuth account when deleting.
     */
    public function handle(OAuthAccountDeleting $event): void
    {
        $oAuthAccount = $event->account;

        $emailAccount = EmailAccount::where('access_token_id', $oAuthAccount->id)->first();

        if ($emailAccount) {
            $emailAccount->setSyncState(
                SyncState::STOPPED,
                'The connected OAuth account ('.$oAuthAccount->email.') was deleted, hence, working with this email account cannot be proceeded. Consider removing the email account from the application.'
            );

            $emailAccount->fill(['access_token_id' => null])->save();
        }
    }
}
