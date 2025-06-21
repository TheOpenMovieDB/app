<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\TMDB\DTO\TMDBMovieResponseDTO;
use App\Services\TMDB\Repository\MovieRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @method static MovieRepository movie()
 * @method static TMDBMovieResponseDTO getMovieByID(int $movieId)
 */
final class TMDB extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tmdb';
    }
}
