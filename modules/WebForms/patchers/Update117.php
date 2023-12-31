<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use App\Support\ToModuleMigrator;
use Illuminate\Support\Facades\DB;
use Modules\Core\Updater\UpdatePatcher;

return new class extends UpdatePatcher
{
    public function run(): void
    {
        ToModuleMigrator::make('webforms')
            ->migrateMailableTemplates($this->getMailableTemplatesMap())
            ->migrateDbLanguageKeys('form')
            ->migrateLanguageFiles(['form.php'])
            ->deleteConflictedFiles([app_path('Models/WebForm.php')]);

        DB::table('changelog')
            ->where('identifier', 'web-form-submission')
            ->update(['identifier' => 'web-form-submission-changelog']);
    }

    public function shouldRun(): bool
    {
        return file_exists(app_path('Models/WebForm.php'));
    }

    protected function getMailableTemplatesMap(): array
    {
        return [
            'App\\Mail\\WebFormSubmitted' => 'Modules\WebForms\Mail\WebFormSubmitted',
        ];
    }
};
