<?php

namespace Dbt\LaravelFilepond;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class FilepondServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishConfig();
        }

        $this->extendValidator();
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
            return new Filepond();
        });
    }

    protected function registerRoutes(): void
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('laravel-filepond.route_prefix', 'filepond'),
            'middleware' => config('laravel-filepond.middleware', [])
        ];
    }


    private function publishConfig() : void
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-filepond.php'),
        ], 'config');
    }

    private function extendValidator(): void
    {
        app(ValidationFactory::class)->resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            return new Validator($translator, $data, $rules, $messages, $customAttributes, app('laravel-filepond'));
        });
    }
}
