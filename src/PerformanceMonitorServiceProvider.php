<?php

namespace Fruitcake\PerformanceMonitor;

use Fruitcake\PerformanceMonitor\Console\PruneDatabase;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PerformanceMonitorServiceProvider extends BaseServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/performance-monitor.php',
            'performance-monitor'
        );

        $this->commands([
            PruneDatabase::class,
        ]);
    }

    /**
     * Register the config for publishing
     *
     */
    public function boot()
    {
        $this->registerMigrations();
        $this->registerPublishing();

        if (! config('performance-monitor.enabled')) {
            return;
        }

        $this->registerRoutes();
        $this->registerViews();

        PerformanceMonitor::start($this->app);
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::middlewareGroup('performance-monitor', config('performance-monitor.middleware', []));

        Route::group([
             'namespace' => 'Fruitcake\PerformanceMonitor\Http\Controllers',
             'prefix' => config('performance-monitor.path'),
             'middleware' => 'performance-monitor',
         ], function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
         });
    }

    private function registerViews()
    {
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'performance-monitor'
        );
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        }
    }

    /**
     * Register the config
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                 __DIR__ . '/../config/performance-monitor.php' => config_path('performance-monitor.php'),
             ], 'performance-monitor-config');
        }
    }
}
