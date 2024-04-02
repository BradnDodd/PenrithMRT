<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Callout>
 */
class CalloutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $starTime = fake()->dateTimeBetween('-6 months');
        $endTime = fake()->dateTimeInInterval($starTime, '+10 hours');
        return [
            'title' => fake()->sentence(),
            'type' => fake()->randomElement(['rescue', 'assist', 'search']),
            'location_string' => fake()->randomElement(['Great Dun Fell', 'Kidsty Howes, Haweswater', 'Coombs Wood, Armathwaite', 'Doddick Fell, Blencathra']),
            'location_latitude' => fake()->latitude(54.6, 54.7),
            'location_longitude' => fake()->longitude(-2.6, -2.8),
            'description' => fake()->text(500),
            'start_time' => $starTime,
            'end_time' => $endTime,
            'num_team_members' => fake()->numberBetween(4, 30),
        ];
    }
}
