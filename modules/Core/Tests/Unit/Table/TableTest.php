<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Unit\Table;

use Modules\Core\Resource\Http\ResourceRequest;
use Modules\Core\Table\Exceptions\OrderByNonExistingColumnException;
use Tests\Fixtures\EventTable;
use Tests\TestCase;

class TableTest extends TestCase
{
    public function test_user_cannot_sort_table_field_that_is_not_added_in_table_columns()
    {
        $user = $this->signIn();

        $request = app(ResourceRequest::class)->setUserResolver(function () use ($user) {
            return $user;
        });

        $table = (new EventTable(null, $request))->orderBy('non-existent-field', 'desc');

        $this->expectException(OrderByNonExistingColumnException::class);

        $table->settings()->toArray();
    }
}
