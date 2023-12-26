<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Join>
 */
class JoinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => $this->faker->unique()->randomElement([1,2,3,4,5,6,7,8,9,10]),
            'user_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10]),

        ];
    }
}
