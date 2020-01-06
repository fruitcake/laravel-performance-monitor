<?php

namespace Fruitcake\PerformanceMonitor\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Router;
use Fruitcake\PerformanceMonitor\Storage\IncomingRequest;
use Fruitcake\PerformanceMonitor\PerformanceMonitorServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [PerformanceMonitorServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }

        $config = $app->get('config');
        $config->set('database.default', 'testbench');
//        $config->set('logging.default', 'errorlog');

        $config->set('database.default', 'testbench');
        $config->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $config->set('performance-monitor.ignore_paths', [
            'ignored/*'
        ]);

        /** @var Router $router */
        $router = $app['router'];

        $this->addWebRoutes($router);
    }

    /**
     * @param Router $router
     */
    protected function addWebRoutes(Router $router)
    {
        $router->get('web/ping', function () {
            return 'PONG';
        });

        $router->get('web/query', function () {
            IncomingRequest::count();
            IncomingRequest::get();
            return '2 queries executed';
        });

        $router->get('web/error', function () {
            throw new \RuntimeException('Whoops');
        });
    }
}
