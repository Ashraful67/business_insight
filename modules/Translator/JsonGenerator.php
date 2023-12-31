<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Translator;

use Exception;
use JsonException;
use Modules\Core\Facades\Innoclapps;

class JsonGenerator
{
    const VUEX_I18N = 'vuex-i18n';

    const VUE_I18N = 'vue-i18n';

    const ESCAPE_CHAR = '!';

    /**
     * Initialize new JsonGenerator instance.
     */
    public function __construct(protected array $config = [])
    {
        if (! isset($this->config['i18nLib'])) {
            $this->config['i18nLib'] = self::VUE_I18N;
        }

        if (! isset($this->config['escape_char'])) {
            $this->config['escape_char'] = self::ESCAPE_CHAR;
        }
    }

    /**
     * Generate and save the file to a given location
     */
    public function generateTo(string $path): int|bool
    {
        return file_put_contents($path, $this->generate());
    }

    /**
     * Generate languages JSON file
     *
     * @throws \Exception
     */
    public function generate(): string
    {
        try {
            $jsonLocales = json_encode(
                $this->prepareTranslations(),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
            ).PHP_EOL;
        } catch (JsonException $e) {
            throw new Exception('Could not generate JSON, error code '.$e->getMessage());
        }

        return $jsonLocales;
    }

    /**
     * Prepare the translations for storage.
     */
    protected function prepareTranslations(): array
    {
        $locales = [];
        $translator = new Translator();

        foreach (Innoclapps::locales() as $locale) {
            $translations = $translator->current($locale);

            // global groups
            foreach ($translations['groups'] as $group => $groupTranslations) {
                $locales[$locale][$group] = $this->adjustArray($groupTranslations);
            }

            // namespaced
            foreach ($translations['namespaces'] as $namespace => $groups) {
                $locales[$locale][$namespace] = [];

                foreach ($groups as $group => $groupTranslations) {
                    $locales[$locale][$namespace][$group] = $this->adjustArray($groupTranslations);
                }
            }
        }

        return $locales;
    }

    /**
     * Adjust the translations array
     */
    protected function adjustArray(array $arr): array
    {
        $res = [];
        foreach ($arr as $key => $val) {
            $key = $this->removeEscapeCharacter($this->adjustString($key));

            if (is_array($val)) {
                $res[$key] = $this->adjustArray($val);
            } else {
                $res[$key] = $this->removeEscapeCharacter($this->adjustString($val));
            }
        }

        return $res;
    }

    /**
     * Turn Laravel style ":link" into vue-i18n style "{link}" or vuex-i18n style ":::".
     *
     * @param  string|null  $str
     * @return string
     */
    protected function adjustString($str)
    {
        if (! is_string($str)) {
            return $str;
        }

        if ($this->config['i18nLib'] === self::VUEX_I18N) {
            $searchPipePattern = '/(\s)*(\|)(\s)*/';
            $threeColons = ' ::: ';
            $str = preg_replace($searchPipePattern, $threeColons, $str);
        }

        $str = str_replace('@', '{\'@\'}', $str);

        $escaped_escape_char = preg_quote($this->config['escape_char'], '/');

        return preg_replace_callback(
            "/(?<!mailto|tel|{$escaped_escape_char}):\w+/",
            function ($matches) {
                return '{'.mb_substr($matches[0], 1).'}';
            },
            $str
        );
    }

    /**
     * Removes escape character if translation string contains sequence that looks like
     *
     * Laravel style ":link", but should not be interpreted as such and was therefore escaped.
     *
     * @param  string  $str
     * @return string
     */
    protected function removeEscapeCharacter($str)
    {
        if (! $str) {
            return $str;
        }

        $escaped_escape_char = preg_quote($this->config['escape_char'], '/');

        return preg_replace_callback(
            "/{$escaped_escape_char}(:\w+)/",
            function ($matches) {
                return mb_substr($matches[0], 1);
            },
            $str
        );
    }
}
