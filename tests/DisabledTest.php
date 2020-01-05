<?php

namespace Fruitcake\PerformanceMonitor\Tests;

use Fruitcake\PerformanceMonitor\Storage\IncomingRequest;

class DisabledTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = $app->get('config');
        $config->set('performance-monitor.enabled', false);
    }

    public function testLogsValidRequest()
    {
        $crawler = $this->call('GET', 'web/ping');

        $this->assertEquals(200, $crawler->getStatusCode());

        $this->assertEquals(0, IncomingRequest::count());
    }
}
