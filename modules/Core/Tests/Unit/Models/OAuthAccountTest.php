<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Unit\Models;

use Illuminate\Support\Facades\Crypt;
use Modules\Core\Models\OAuthAccount;
use Modules\Core\OAuth\AccessTokenProvider;
use Tests\TestCase;

class OAuthAccountTest extends TestCase
{
    public function test_it_encrypts_the_oauth_account_access_token()
    {
        Crypt::shouldReceive('encrypt')->once()
            ->with('token', false)
            ->andReturnArg(0);

        new OAuthAccount(['access_token' => 'token']);
    }

    public function test_it_decrypts_the_oauth_account_access_token()
    {
        $account = new OAuthAccount(['access_token' => 'token']);

        Crypt::shouldReceive('decrypt')->once()
            ->andReturn('token');

        $this->assertEquals('token', $account->access_token);
    }

    public function test_oauth_account_has_access_token_provider()
    {
        $account = new OAuthAccount(['access_token' => 'token', 'email' => 'john@example.com']);

        $this->assertInstanceOf(AccessTokenProvider::class, $account->tokenProvider());
    }
}
