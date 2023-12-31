<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Translator\Providers;

use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;
use Modules\Translator\Contracts\TranslationLoader;
use Modules\Translator\LoaderManager;
use Modules\Translator\Loaders\OverrideFileLoader;

class TranslationServiceProvider extends BaseTranslationServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(TranslationLoader::class, function ($app) {
            return new OverrideFileLoader($app['config']->get('translator.custom'));
        });
    }

    /**
     * Register the translation line loader. This method registers a
     * `LoaderManager` instead of a simple `FileLoader` as the
     * applications `translation.loader` instance.
     */
    protected function registerLoader(): void
    {
        $this->app->singleton('translation.loader', function ($app) {
            return new LoaderManager($app['files'], $app['path.lang']);
        });
    }
}
