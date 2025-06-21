<?php

declare(strict_types=1);

namespace App\Services\TMDB;

use App\Services\TMDB\DTO\TMDBMovieResponseDTO;
use App\Services\TMDB\Repository\AbstractRepository;
use App\Services\TMDB\Repository\MovieRepository;

final class TMDB extends AbstractRepository
{
    public function __construct(string $apiKey, string $apiLanguage = 'en-US')
    {
        parent::__construct($apiKey, $apiLanguage);
    }

    /**
     * Get the MovieRepository.
     *
     *
     * @return MovieRepository
     */
    public function movie(): MovieRepository
    {
        return new MovieRepository($this);

    }

    /**
     * Get movie details by ID.
     *
     * @param int $movieId
     * @return TMDBMovieResponseDTO
     */
    public function getMovieByID(int $movieId): TMDBMovieResponseDTO
    {
        return TMDBMovieResponseDTO::fromArray(
            $this->movie()->details($movieId)->toArray()
        );

    }

}
