<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SarcallResponse>
 */
class SarcallResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $eta = fake()->time('H:i');
        return [
            'eta' => $eta,
            'response' => fake()->randomElement(['base', 'direct']) . ' ' . $eta,
            'time' => fake()->dateTimeBetween('now', '+2 hours'),
        ];
    }
}
