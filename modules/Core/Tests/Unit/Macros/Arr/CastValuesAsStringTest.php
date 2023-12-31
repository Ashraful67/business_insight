<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Unit\Macros\Arr;

use Illuminate\Support\Arr;
use Tests\TestCase;

class CastValuesAsStringTest extends TestCase
{
    public function test_it_casts_values_as_string()
    {
        $casts = Arr::valuesAsString([1, 2, 3]);

        $this->assertSame('1', $casts[0]);
        $this->assertSame('2', $casts[1]);
        $this->assertSame('3', $casts[2]);
    }
}
