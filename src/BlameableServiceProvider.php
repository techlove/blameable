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
            $config = config('blameable');

            $this->integer($config['created_by_column'])->nullable();
            $this->integer($config['updated_by_column'])->nullable();
        });
    }
}
