<?php

namespace Fruitcake\PerformanceMonitor\Storage;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IncomingRequest
 *
 * @property int $id
 * @property string $request_url
 * @property string $request_path
 * @property int $response_code
 * @property float $duration
 * @property int $query_count
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
