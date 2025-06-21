<?php

declare(strict_types=1);

namespace App\Services\TMDB\DTO;

use Carbon\Carbon;
use Illuminate\Support\Collection;

final class TMDBMovieResponseDTO
{
    public function __construct(
        public bool          $adult,
        public string        $backdrop_path,
        public ?array        $belongs_to_collection,
        public int           $budget,
        /** @var Collection<int, array<string, mixed>> */
        public Collection    $genres,
        public string        $homepage,
        public int           $id,
        public string        $imdb_id,
        public string        $original_language,
        public string        $original_title,
        public string        $overview,
        public float         $popularity,
        public string        $poster_path,
        /** @var Collection<int, array<string, mixed>> */
        public Collection    $production_companies,
        /** @var Collection<int, array<string, mixed>> */
        public Collection    $production_countries,
        public ?Carbon $release_date,
        public int           $revenue,
        public int           $runtime,
        /** @var Collection<int, array<string, mixed>> */
        public Collection    $spoken_languages,
        public string        $status,
        public string        $tagline,
        public string        $title,
        public bool          $video,
        public float         $vote_average,
        public int           $vote_count
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            adult: $data['adult'] ?? false,
            backdrop_path: $data['backdrop_path'] ?? '',
            belongs_to_collection: $data['belongs_to_collection'] ?? null,
            budget: $data['budget'] ?? 0,
            genres: collect($data['genres'] ?? []),
            homepage: $data['homepage'] ?? '',
            id: $data['id'] ?? 0,
            imdb_id: $data['imdb_id'] ?? '',
            original_language: $data['original_language'] ?? '',
            original_title: $data['original_title'] ?? '',
            overview: $data['overview'] ?? '',
            popularity: $data['popularity'] ?? 0.0,
            poster_path: $data['poster_path'] ?? '',
            production_companies: collect($data['production_companies'] ?? []),
            production_countries: collect($data['production_countries'] ?? []),
            release_date: ! empty($data['release_date']) ? Carbon::createFromDate($data['release_date']) : null,
            revenue: $data['revenue'] ?? 0,
            runtime: $data['runtime'] ?? 0,
            spoken_languages: collect($data['spoken_languages'] ?? []),
            status: $data['status'] ?? '',
            tagline: $data['tagline'] ?? '',
            title: $data['title'] ?? '',
            video: $data['video'] ?? false,
            vote_average: $data['vote_average'] ?? 0.0,
            vote_count: $data['vote_count'] ?? 0
        );
    }
}
