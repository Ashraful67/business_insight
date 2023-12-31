<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Activities\Models\ActivityType;
use Modules\Activities\Models\Calendar;
use Modules\Users\Models\User;

class CalendarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Calendar::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail(),
            'user_id' => User::factory(),
            'activity_type_id' => ActivityType::factory(),
            'activity_types' => [ActivityType::factory()->create(), ActivityType::factory()->create()],
        ];
    }

    /**
     * Indicate that the product is inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}
