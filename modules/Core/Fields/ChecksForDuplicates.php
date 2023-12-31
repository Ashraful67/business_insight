<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

trait ChecksForDuplicates
{
    /**
     * Duplicate checker data
     */
    protected array $checkDuplicatesWith = [];

    /**
     * Add duplicates checker data
     */
    public function checkPossibleDuplicatesWith(string $url, array $params, string $langKey): static
    {
        return $this->withMeta([
            'checkDuplicatesWith' => [
                'url' => $url,
                'params' => $params,
                'lang_keypath' => $langKey,
            ],
        ]);
    }
}
