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

        Blueprint::macro('blameable', function (
            $softDeletes = false,
            $createdColumn = null,
            $updatedColumn = null,
            $deletedColumn = null
        ) {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $columns = config('blameable.columns');

            $createdColumn = $createdColumn ?? $columns['created_by'];
            $updatedColumn = $updatedColumn ?? $columns['updated_by'];
            $deletedColumn = $deletedColumn ?? $columns['deleted_by'];

            $this->integer($createdColumn)->nullable();
            $this->integer($updatedColumn)->nullable();

            if ($softDeletes) {
                $this->integer($deletedColumn)->nullable();
            }
        });
    }
}
