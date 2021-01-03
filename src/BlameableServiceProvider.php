<?php

namespace AppKit\Blameable;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class BlameableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'blameable');
        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'blameable');
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__ . '/../routes/blameable.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('blameable.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'blameable');

        // Register the main class to use with the facade
        $this->app->singleton('blameable', function () {
            return new Blameable();
        });

        Blueprint::macro('blameable', function () {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $this->integer('created_by')->nullable();
            $this->integer('updated_by')->nullable();
        });
    }
}
