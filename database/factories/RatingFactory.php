<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $postId = 1; // Initialize post_id

        return [
            'post_id' => $postId++, // Random post_id between 1 and 10
            'user_id' => 10, // Set user_id to 11 for all rows
            'onestar' => 0, // Set stars to 0
            'twostar' => 0,
            'threestar' => 0,
            'fourstar' => 0,
            'fivestar' => 0,
        ];
    }

}
