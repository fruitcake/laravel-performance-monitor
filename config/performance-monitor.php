<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Performance Monitor Enable/Disable
   |--------------------------------------------------------------------------
   |
   | Enable/Disable the Performance Monitor globally or ignore certain paths
   |
   */

    'enabled' => env('PERFORMANCE_MONITOR_ENABLED', true),

    'ignore_paths' => [
        //
    ],


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'path' => 'performance-monitor',

    'middleware' => [
        'web',
        \Fruitcake\PerformanceMonitor\Http\Middleware\Authorize::class,
    ],
];
