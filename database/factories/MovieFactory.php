<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
final class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tmdb_id' => $this->faker->unique()->numberBetween(1, 100000),
            'imdb_id' => $this->faker->regexify('tt\d{7,8}'),
            'adult' => $this->faker->boolean(10),
            'backdrop_path' => $this->faker->imageUrl(1280, 720, 'movies'),
            'belongs_to_collection' => null,
            'budget' => $this->faker->numberBetween(1000, 200000000),
            'homepage' => $this->faker->url(),
            'original_language' => $this->faker->languageCode(),
            'original_title' => $this->faker->sentence(3),
            'overview' => $this->faker->paragraph(),
            'popularity' => $this->faker->randomFloat(2, 0, 100),
            'poster_path' => $this->faker->imageUrl(500, 750, 'movies'),
            'release_date' => $this->faker->date(),
            'revenue' => $this->faker->numberBetween(0, 1000000000),
            'runtime' => $this->faker->numberBetween(30, 240),
            'status' => $this->faker->randomElement(['Released', 'Post Production', 'Canceled']),
            'tagline' => $this->faker->sentence(),
            'title' => $this->faker->sentence(3),
            'video' => $this->faker->boolean(5),
            'vote_average' => $this->faker->randomFloat(1, 0, 10),
            'vote_count' => $this->faker->numberBetween(0, 100000),
        ];
    }
}
