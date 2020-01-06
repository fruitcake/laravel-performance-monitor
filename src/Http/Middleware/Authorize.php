<?php

namespace Fruitcake\PerformanceMonitor\Http\Middleware;

use Fruitcake\PerformanceMonitor\PerformanceMonitor;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return PerformanceMonitor::check($request) ? $next($request) : abort(403);
    }
}
