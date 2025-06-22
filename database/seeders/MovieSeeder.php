<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Facades\TMDB;
use App\Models\Movie;
use App\Services\TMDB\DTO\TMDBMovieResponseDTO;
use Illuminate\Database\Seeder;

final class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getMovieIds() as $movieId) {
            $movie = TMDB::movie()->details($movieId);
            $movieDto = TMDBMovieResponseDTO::fromArray($movie->toArray());

            if (false === $movie->get('success')) {
                $this->command->error("Failed to fetch movie with ID: {$movieId}");
                return;
            }
            $this->command->info("Fetched movie: {$movieDto->title} (TMDB ID: {$movieDto->id})");

            if ( ! Movie::query()->withTrashed()->where('tmdb_id', $movieDto->id)->exists()) {
                Movie::query()->create([
                    'tmdb_id' => $movieDto->id,
                    'imdb_id' => $movieDto->imdb_id,
                    'adult' => $movieDto->adult,
                    'backdrop_path' => $movieDto->backdrop_path,
                    //                    'belongs_to_collection' => $movieDto->belongs_to_collection,
                    'budget' => $movieDto->budget,
                    'homepage' => $movieDto->homepage,
                    'original_language' => $movieDto->original_language,
                    'original_title' => $movieDto->original_title,
                    'overview' => $movieDto->overview,
                    'popularity' => $movieDto->popularity,
                    'poster_path' => $movieDto->poster_path,
                    'release_date' => $movieDto->release_date,
                    'revenue' => $movieDto->revenue,
                    'runtime' => $movieDto->runtime,
                    'status' => $movieDto->status,
                    'tagline' => $movieDto->tagline,
                    'title' => $movieDto->title,
                    'video' => $movieDto->video,
                    'vote_average' => $movieDto->vote_average,
                    'vote_count' => $movieDto->vote_count,
                ]);
                $this->command->info("Movie with ID {$movieId} has been created.");
            } else {
                $this->command->info("Movie with ID {$movieId} already exists in the database.");
            }

            $this->command->info("Movie with ID {$movieId} has been processed.");
            sleep(5); // to not get rate limited by TMDB ;)
        }
    }

    private function getMovieIds(): array
    {
        return [
            100, 101, 102, 103, 104, 105, 106, 107, 108, 109,
            110, 111, 112, 113, 114, 115, 116, 117, 118, 119,
            120, 121, 122, 123, 124, 125, 126, 127, 128, 129,
            130, 131, 132, 133, 134, 135, 136, 137, 138, 139,
            140, 141, 142, 143, 144, 145, 146, 147, 148, 149,
            150
        ];
    }
}
