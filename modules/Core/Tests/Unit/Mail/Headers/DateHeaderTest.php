<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Unit\Mail\Headers;

use Carbon\Carbon;
use Modules\Core\Mail\Headers\DateHeader;
use Tests\TestCase;

class DateHeaderTest extends TestCase
{
    public function test_date_header_is_converted_to_carbon_instance()
    {
        $header = new DateHeader('date', '2022-01-20 15:00:00');

        $this->assertInstanceOf(Carbon::class, $header->getValue());
        $this->assertSame(config('app.timezone'), (string) $header->getValue()->timezone);

        $header = new DateHeader('date', '2022-01-20T15:00:00+01:00');
        $this->assertSame('2022-01-20 14:00:00', $header->getValue()->format('Y-m-d H:i:s'));
        $this->assertSame(config('app.timezone'), (string) $header->getValue()->timezone);
    }

    public function test_date_header_value_is_null_when_header_has_no_date()
    {
        $header = new DateHeader('date', null);

        $this->assertNull($header->getValue());
    }
}
