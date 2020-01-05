<?php

namespace Fruitcake\PerformanceMonitor;

use Fruitcake\PerformanceMonitor\Console\PruneDatabase;
use Illuminate\Foundation\Http\Events\RequestHandled;
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

        $this->registerQueryCounter();

        $this->registerRequestHandler();
    }

    private function registerQueryCounter()
    {
        RequestLogger::resetQueryCount();

        $this->app['db']->listen(\Closure::fromCallable([RequestLogger::class, 'incrementQueryCount']));
    }

    private function registerRequestHandler()
    {
        $this->app['events']->listen(RequestHandled::class, [RequestLogger::class, 'storeHandledRequest']);
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
