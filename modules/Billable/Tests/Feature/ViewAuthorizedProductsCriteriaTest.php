<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Billable\Tests\Feature;

use Modules\Billable\Criteria\ViewAuthorizedProductsCriteria;
use Modules\Billable\Models\Product;
use Modules\Core\Database\Seeders\PermissionsSeeder;
use Tests\TestCase;

class ViewAuthorizedProductsCriteriaTest extends TestCase
{
    public function test_own_products_criteria_queries_only_own_products()
    {
        $this->seed(PermissionsSeeder::class);
        $user = $this->asRegularUser()->withPermissionsTo('view own products')->createUser();

        Product::factory()->for($user, 'creator')->create();
        Product::factory()->create();

        $this->signIn($user);

        $query = Product::criteria(ViewAuthorizedProductsCriteria::class);

        $this->assertSame(1, $query->count());
    }

    public function test_it_returns_all_products_when_user_is_authorized_to_see_all_products()
    {
        $this->seed(PermissionsSeeder::class);
        $user = $this->asRegularUser()->withPermissionsTo('view all products')->createUser();

        Product::factory()->for($user, 'creator')->create();
        Product::factory()->create();

        $this->signIn($user);
        $query = Product::criteria(ViewAuthorizedProductsCriteria::class);
        $this->assertSame(2, $query->count());

        $this->signIn();
        $this->assertSame(2, $query->count());
    }
}
