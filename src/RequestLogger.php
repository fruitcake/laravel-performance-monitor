<?php

namespace Fruitcake\PerformanceMonitor;

use Fruitcake\PerformanceMonitor\Storage\IncomingRequest;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\DB;

class RequestLogger
{
    private static $queryCount = 0;

    public static function resetQueryCount()
    {
        static::$queryCount = 0;
    }

    public static function incrementQueryCount()
    {
        static::$queryCount++;
    }

    public static function storeHandledRequest(RequestHandled $event)
    {
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : $event->request->server('REQUEST_TIME_FLOAT');

        if ($event->request->is(config('performance-monitor.ignore_paths', []))) {
            return;
        }

        IncomingRequest::forceCreate(
            [
                'request_url' => $event->request->fullUrl(),
                'request_path' => $event->request->path(),
                'response_code' => $event->response->getStatusCode(),
                'query_count' => static::$queryCount,
                'duration' => $startTime ? floor((microtime(true) - $startTime) * 1000) : 0,
            ]
        );

        static::resetQueryCount();
    }
}
