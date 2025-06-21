<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class TmdbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('tmdb', fn () => new \App\Services\TMDB\TMDB(config('services.tmdb.api_key'), config('services.tmdb.api_language')));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
