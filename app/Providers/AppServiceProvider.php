<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use URL;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureModels();
        $this->configureDates();
        $this->configureCli();
        $this->configureHttps();


    }

    /**
     * Configure defaults for models for the application.
     */
    private function configureModels(): void
    {
        Model::shouldBeStrict(true);
    }

    /**
     * Configure the dates for the application Immutable by default.
     */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Configure the default rules for cli commands.
     */
    private function configureCli(): void
    {
        DB::prohibitDestructiveCommands($this->app->isProduction());
    }


    private function configureHttps(): void
    {
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }
    }

}
