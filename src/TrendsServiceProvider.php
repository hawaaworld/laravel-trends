<?php

namespace Hawaaworld\Trends;

use Illuminate\Support\ServiceProvider;

class TrendsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('trends', fn () => new Trends());
    }

    public function boot(): void
    {
        $this->registerMigrations();

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'trends_migrations');

        $this->publishes([
            __DIR__.'/../config/trends.php' => config_path('trends.php'),
        ]);
    }

    public function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
