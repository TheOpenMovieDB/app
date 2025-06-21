<?php

declare(strict_types=1);

namespace App\Services\TMDB\Repository;

use App\Services\TMDB\TMDB;
use Illuminate\Support\Collection;

/**
 * @see https://developers.themoviedb.org/3/movies
 */
final class MovieRepository
{
    public function __construct(private readonly TMDB $tmdb)
    {
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-details
     */
    public function details($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId);
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-alternative-titles
     */
    public function alternativeTitles($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/alternative_titles");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-changes
     */
    public function changes($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/changes");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-credits
     */
    public function credits($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/credits");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-external-ids
     */
    public function externalIds($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/external_ids");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-images
     */
    public function images($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/images");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-keywords
     */
    public function keywords($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/keywords");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-lists
     */
    public function lists($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/lists");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-recommendations
     */
    public function recommendations($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/recommendations");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-release-dates
     */
    public function releaseDates($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/release_dates");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-reviews
     */
    public function reviews($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/reviews");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-similar-movies
     */
    public function similar($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/similar");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-translations
     */
    public function translations($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/translations");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-videos
     */
    public function videos($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/videos");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-movie-watch-providers
     */
    public function watchProviders($movieId): Collection
    {
        return $this->tmdb->request("movie/" . $movieId . "/watch/providers");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-latest-movie
     */
    public function latest(): Collection
    {
        return $this->tmdb->request("movie/latest");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-now-playing
     */
    public function nowPlaying(): Collection
    {
        return $this->tmdb->request("movie/now_playing");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-popular-movies
     */
    public function popular(): Collection
    {
        return $this->tmdb->request("movie/popular");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-top-rated-movies
     */
    public function topRated(): Collection
    {
        return $this->tmdb->request("movie/top_rated");
    }

    /**
     * @see https://developers.themoviedb.org/3/movies/get-upcoming
     */
    public function upcoming(): Collection
    {
        return $this->tmdb->request("movie/upcoming");
    }
}
