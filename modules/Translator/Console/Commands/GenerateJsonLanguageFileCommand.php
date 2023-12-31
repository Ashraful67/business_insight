<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Translator\Console\Commands;

use Illuminate\Console\Command;
use Modules\Translator\Translator;

class GenerateJsonLanguageFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translator:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate application json language file.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Translator::generateJsonLanguageFile();

        $this->info('Language file generated successfully.');
    }
}
