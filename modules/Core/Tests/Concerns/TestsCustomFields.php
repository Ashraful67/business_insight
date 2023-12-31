<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Concerns;

use Modules\Core\Facades\Fields;

trait TestsCustomFields
{
    protected function fieldsTypesThatRequiresDatabaseColumnCreation()
    {
        return Fields::customFieldable()->where('multioptionable', false)->keys()->all();
    }

    protected function fieldsTypesThatDoesntRequiresDatabaseColumnCreation()
    {
        return Fields::customFieldable()->where('multioptionable', true)->keys()->all();
    }
}
