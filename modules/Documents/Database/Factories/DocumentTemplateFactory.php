<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Users\Models\User;

class DocumentTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Documents\Models\DocumentTemplate::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->word()),
            'content' => $this->faker->text(),
            'is_shared' => false,
            'user_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the template is shared.
     */
    public function shared(): Factory
    {
        return $this->state(function () {
            return [
                'is_shared' => true,
            ];
        });
    }
}
