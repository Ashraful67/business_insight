<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ResourceBundle;

class Locale implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! extension_loaded('intl')) {
            $passes = (bool) preg_match('/^[A-Za-z_]+$/', $value);
        } else {
            $passes = in_array($value, ResourceBundle::getLocales(''));
        }

        if (! $passes) {
            $fail('Invalid locale, locale name should be in format: "de" or "de_DE" or "pt_BR"');
        }
    }
}
