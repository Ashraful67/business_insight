<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Core\Facades\OAuthState;
use Modules\Core\OAuth\OAuthManager;

class OAuthCalendarController extends Controller
{
    /**
     * OAuth connect email account.
     */
    public function connect(string $providerName, Request $request, OAuthManager $manager): RedirectResponse
    {
        return redirect($manager->createProvider($providerName)
            ->getAuthorizationUrl(['state' => $this->createState($request, $manager)]));
    }

    /**
     * Create state.
     */
    protected function createState(Request $request, OAuthManager $manager): string
    {
        return OAuthState::putWithParameters([
            'return_url' => '/calendar/sync?viaOAuth=true',
            're_auth' => $request->re_auth,
            'key' => $manager->generateRandomState(),
        ]);
    }
}
