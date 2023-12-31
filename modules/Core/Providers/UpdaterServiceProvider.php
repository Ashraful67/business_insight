<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Providers;

use GuzzleHttp\Client;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Updater\Patcher;
use Modules\Core\Updater\Updater;

class UpdaterServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Updater::class, function ($app) {
            return new Updater(new Client, new Filesystem, [
                'purchase_key' => $app['config']->get('updater.purchase_key'),
                'archive_url' => $app['config']->get('updater.archive_url'),
                'download_path' => $app['config']->get('updater.download_path'),
                'version_installed' => $app['config']->get('updater.version_installed'),
                'exclude_folders' => $app['config']->get('updater.exclude_folders'),
                'exclude_files' => $app['config']->get('updater.exclude_files'),
                'permissions' => $app['config']->get('updater.permissions'),
            ]);
        });

        $this->app->singleton(Patcher::class, function ($app) {
            return new Patcher(new Client, new Filesystem, [
                'purchase_key' => $app['config']->get('updater.purchase_key'),
                'patches_url' => $app['config']->get('updater.patches_archive_url'),
                'download_path' => $app['config']->get('updater.download_path'),
                'version_installed' => $app['config']->get('updater.version_installed'),
                'permissions' => $app['config']->get('updater.permissions'),
            ]);
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [Updater::class, Patcher::class];
    }
}