<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Modules\Core\ReCaptcha;

class ReCaptchaServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('recaptcha', function ($app) {
            return (new ReCaptcha(Request::instance()))
                ->setSiteKey($app['config']->get('core.recaptcha.site_key'))
                ->setSecretKey($app['config']->get('core.recaptcha.secret_key'))
                ->setSkippedIps($app['config']->get('core.recaptcha.ignored_ips', []));
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['recaptcha'];
    }
}
