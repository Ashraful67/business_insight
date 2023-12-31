<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Translator\Tests\Unit;

use Illuminate\Support\Facades\File;
use Modules\Translator\LoaderManager;
use Modules\Translator\Translator;
use Tests\TestCase;

class LoaderManagerTest extends TestCase
{
    protected function tearDown(): void
    {
        foreach (['en_TEST', '.custom/en_TEST', '.custom'] as $folder) {
            $path = lang_path($folder);

            if (is_dir($path)) {
                File::deepCleanDirectory($path);
            }
        }

        parent::tearDown();
    }

    public function test_it_uses_the_loader_manager()
    {
        $this->assertInstanceOf(LoaderManager::class, app('translation.loader'));
    }

    public function test_it_can_loader_locale_translation_group()
    {
        File::ensureDirectoryExists(lang_path('en_TEST'));
        File::copy(base_path('tests/Fixtures/locale_group.php'), lang_path('en_TEST/locale_group.php'));

        $manager = app('translation.loader');
        $groupsTranslations = $manager->load('en_TEST', 'locale_group');

        $this->assertIsArray($groupsTranslations);
        $this->assertCount(2, $groupsTranslations);
        $this->assertArrayHasKey('key', $groupsTranslations);
        $this->assertArrayHasKey('deep', $groupsTranslations);
    }

    public function test_it_merges_the_custom_translations()
    {
        File::ensureDirectoryExists(lang_path('en_TEST'));
        File::copy(base_path('tests/Fixtures/locale_group.php'), lang_path('en_TEST/locale_group.php'));

        $override = new Translator;
        $override->save('en_TEST', 'locale_group', [
            'key' => 'changed',
            'deep' => [
                'key' => 'changed',
            ],
            'new' => 'value',
        ]);

        $manager = app('translation.loader');
        $groupsTranslations = $manager->load('en_TEST', 'locale_group');

        $this->assertIsArray($groupsTranslations);
        $this->assertCount(3, $groupsTranslations);
        $this->assertArrayHasKey('key', $groupsTranslations);
        $this->assertArrayHasKey('deep', $groupsTranslations);
        $this->assertArrayHasKey('new', $groupsTranslations);
        $this->assertSame('changed', $groupsTranslations['key']);
        $this->assertSame('changed', $groupsTranslations['deep']['key']);
        $this->assertSame('value', $groupsTranslations['new']);
    }
}
