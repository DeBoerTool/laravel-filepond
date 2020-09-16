<?php

namespace Dbt\LaravelFilepond;

use Illuminate\Support\ServiceProvider;

class LaravelFilepondServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishConfig();
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-filepond');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-filepond', function () {
            return new LaravelFilepond();
        });
    }

    private function loadRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    private function publishConfig() : void
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-filepond.php'),
        ], 'config');
    }
}
