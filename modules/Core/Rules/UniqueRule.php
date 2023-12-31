<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Rules;

use Illuminate\Validation\Rules\Unique;
use Modules\Core\Makeable;

class UniqueRule extends Unique
{
    use Makeable;

    /**
     * Create a new rule instance.
     */
    public function __construct(string $model, mixed $ignore = null, string|null $column = 'NULL')
    {
        parent::__construct(
            app($model)->getTable(),
            $column
        );

        if (! is_null($ignore)) {
            $ignoredId = is_int($ignore) ? $ignore : (request()->route($ignore) ?: null);

            $this->ignore($ignoredId);
        }
    }
}
