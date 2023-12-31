<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;
use Modules\Core\Updater\UpdateFinalizer;

class FinalizeUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updater:finalize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finalize the application recent update.';

    /**
     * Execute the console command.
     */
    public function handle(UpdateFinalizer $instance): void
    {
        if (! $instance->needed()) {
            $this->info('There is no update to finalize');

            return;
        }

        $instance->run();

        $this->info('The update has been finalized');
    }
}
