<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'        => fake()->unique()->words(3, true),
            'type'         => fake()->randomElement(['film', 'series', 'game']),
            'genre'        => fake()->randomElement(['Action', 'Drama', 'Comedy', 'Sci-Fi', 'Horror']),
            'release_year' => fake()->numberBetween(1990, 2026),
            'description'  => fake()->sentence(),
        ];
    }
}
