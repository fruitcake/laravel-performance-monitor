<?php

namespace Fruitcake\PerformanceMonitor;

use Illuminate\Foundation\Http\Events\RequestHandled;

class PerformanceMonitor
{
    use AuthorizesRequests;

    /**
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public static function start($app)
    {
        if (! config('performance-monitor.enabled')) {
            return;
        }

        RequestLogger::resetQueryCount();

        $app['db']->listen(\Closure::fromCallable([RequestLogger::class, 'incrementQueryCount']));

        $app['events']->listen(RequestHandled::class, [RequestLogger::class, 'storeHandledRequest']);
    }
}
