<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use App\Support\ToModuleMigrator;
use Modules\Core\Updater\UpdatePatcher;

return new class extends UpdatePatcher
{
    public function run(): void
    {
        ToModuleMigrator::make('deals')
            ->migrateLanguageFiles(['brand.php'])
            ->deleteConflictedFiles($this->getConflictedFiles());
    }

    public function shouldRun(): bool
    {
        return file_exists(app_path('Models/Brand.php'));
    }

    protected function getConflictedFiles(): array
    {
        return [
            app_path('Models/Brand.php'),
        ];
    }
};
