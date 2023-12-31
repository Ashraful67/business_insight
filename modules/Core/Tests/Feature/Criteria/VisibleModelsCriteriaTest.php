<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature\Criteria;

use Modules\Core\Criteria\VisibleModelsCriteria;
use Modules\Core\Models\ModelVisibilityGroup;
use Modules\Deals\Models\Pipeline;
use Modules\Users\Models\Team;
use Modules\Users\Models\User;
use Tests\TestCase;

class VisibleModelsCriteriaTest extends TestCase
{
    public function test_visible_pipelines_criteria()
    {
        $user = User::factory()->has(Team::factory())->create();

        Pipeline::factory()
            ->has(
                ModelVisibilityGroup::factory()->teams()->hasAttached($user->teams->first()),
                'visibilityGroup'
            )
            ->create();

        $this->assertSame(1, Pipeline::criteria(new VisibleModelsCriteria($user))->count());
    }
}
