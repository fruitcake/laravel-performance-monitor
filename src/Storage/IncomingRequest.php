<?php

namespace Fruitcake\PerformanceMonitor\Storage;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int $id
 * @property string $request_method
 * @property string $request_url
 * @property string $request_path
 * @property string $controller_action
 * @property int $response_status
 * @property float $duration
 * @property int $query_count
 * @property int $memory
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @package Fruitcake\PerformanceMonitor\Storage
 */
class IncomingRequest extends Model
{
    protected $table = 'monitor_incoming_requests';
    public $casts = [
        'duration' => 'int',
        'query_count' => 'int',
        'response_code' => 'int',
    ];
}
