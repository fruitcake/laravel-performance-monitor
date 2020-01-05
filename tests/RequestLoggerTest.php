<?php

namespace Fruitcake\PerformanceMonitor\Tests;

use Fruitcake\PerformanceMonitor\RequestLogger;
use Fruitcake\PerformanceMonitor\Storage\IncomingRequest;

class RequestLoggerTest extends TestCase
{
    public function testLogsValidRequest()
    {
        $crawler = $this->call('GET', 'web/ping?q=1');

        $this->assertEquals(200, $crawler->getStatusCode());

        $this->assertEquals(1, IncomingRequest::count());

        $incomingRequest = IncomingRequest::latest()->first();

        $this->assertEquals('http://localhost/web/ping?q=1', $incomingRequest->request_url);
        $this->assertEquals('web/ping', $incomingRequest->request_path);
        $this->assertEquals(200, $incomingRequest->response_code);
        $this->assertNotEquals(0, $incomingRequest->duration);

    }

    public function testLogsNotFoundRequest()
    {
        $crawler = $this->call('GET', 'web/404');

        $this->assertEquals(404, $crawler->getStatusCode());

        $this->assertEquals(1, IncomingRequest::count());

        $incomingRequest = IncomingRequest::latest()->first();

        $this->assertEquals('http://localhost/web/404', $incomingRequest->request_url);
        $this->assertEquals('web/404', $incomingRequest->request_path);
        $this->assertEquals(404, $incomingRequest->response_code);
        $this->assertNotEquals(0, $incomingRequest->duration);
    }

    public function testLogsErrorRequest()
    {
        $crawler = $this->call('GET', 'web/error');

        $this->assertEquals(500, $crawler->getStatusCode());

        $this->assertEquals(1, IncomingRequest::count());

        $incomingRequest = IncomingRequest::latest()->first();

        $this->assertEquals('http://localhost/web/error', $incomingRequest->request_url);
        $this->assertEquals('web/error', $incomingRequest->request_path);
        $this->assertEquals(500, $incomingRequest->response_code);
        $this->assertNotEquals(0, $incomingRequest->duration);
    }

    public function testLogsQueryCountRequest()
    {
        // Reset because of migrations etc.
        RequestLogger::resetQueryCount();

        $crawler = $this->call('GET', 'web/query');

        $this->assertEquals(200, $crawler->getStatusCode());

        $this->assertEquals(1, IncomingRequest::count());

        $incomingRequest = IncomingRequest::latest()->first();
        $this->assertEquals(200, $incomingRequest->response_code);
        $this->assertEquals(2, $incomingRequest->query_count);

    }

    public function testIgnoresPaths()
    {
        $crawler = $this->call('GET', 'ignored/ping');

        $this->assertEquals(404, $crawler->getStatusCode());

        $this->assertEquals(0, IncomingRequest::count());

    }
}
