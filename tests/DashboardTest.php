<?php

namespace Fruitcake\PerformanceMonitor\Tests;

use Fruitcake\PerformanceMonitor\PerformanceMonitor;
use Fruitcake\PerformanceMonitor\RequestLogger;
use Fruitcake\PerformanceMonitor\Storage\IncomingRequest;

class DashboardTest extends TestCase
{
    public function testAuthorized()
    {
        PerformanceMonitor::auth(function(){
            return app()->environment('testing');
        });

        $crawler = $this->call('GET', config('performance-monitor.path'));

        $this->assertEquals(200, $crawler->getStatusCode());
    }

    public function testNotAuthorized()
    {
        PerformanceMonitor::auth(function(){
            return app()->environment('local');
        });

        $crawler = $this->call('GET', config('performance-monitor.path'));

        $this->assertEquals(403, $crawler->getStatusCode());

    }

}
