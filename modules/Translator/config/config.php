<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

return [
    'name' => 'Transalator',
    /**
     * The file path where the JSON generator will generate the translations
     */
    'json' => storage_path('i18n-locales.js'),

    /**
     * The translator custom path for OverrideFileLoader
     */
    'custom' => lang_path('.custom'),
];
