<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\Facades\OAuthState;
use Modules\Core\OAuth\OAuthManager;
use Modules\MailClient\Enums\EmailAccountType;

class OAuthEmailAccountController extends Controller
{
    /**
     * OAuth connect email account
     *
     * @param  string  $type shared|personal
     * @param  string  $providerName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function connect($type, $providerName, Request $request, OAuthManager $manager)
    {
        abort_if(
            ! $request->user()->isSuperAdmin() && EmailAccountType::from($type) === EmailAccountType::SHARED,
            403,
            'Unauthorized action.'
        );

        return redirect($manager->createProvider($providerName)
            ->getAuthorizationUrl(['state' => $this->createState($request, $type, $manager)]));
    }

    /**
     * Create state
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @param  \Modules\Core\OAuth\OAuthManager  $manager
     * @return string
     */
    protected function createState($request, $type, $manager)
    {
        return OAuthState::putWithParameters([
            'return_url' => '/mail/accounts?viaOAuth=true',
            'period' => $request->period,
            'email_account_type' => $type,
            're_auth' => $request->re_auth,
            'key' => $manager->generateRandomState(),
        ]);
    }
}
