<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Unit\Menu;

use Modules\Core\Facades\Innoclapps;
use Modules\Core\Facades\Menu;
use Modules\Core\Menu\MenuItem;
use Tests\TestCase;

class MenuTest extends TestCase
{
    public function test_menu_item_can_be_added()
    {
        Innoclapps::booting(function () {
            Menu::clear();
            Menu::register(
                MenuItem::make('Test', '/test-route')
            );
        });

        Innoclapps::boot();

        $this->assertEquals('/test-route', Menu::get()->first()->route);
    }

    public function test_user_cannot_see_menu_items_that_is_not_supposed_to_be_seen()
    {
        $this->asRegularUser()->signIn();

        Menu::register(MenuItem::make('test-item-1', '/')
            ->canSee(function () {
                return false;
            }));

        Menu::register(MenuItem::make('test-item-2', '/')
            ->canSeeWhen('dummy-ability'));

        Menu::register(MenuItem::make('test-item-3', '/'));

        $this->assertCount(1, Menu::get());
    }
}
