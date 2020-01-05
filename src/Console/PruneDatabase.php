<?php

namespace Fruitcake\PerformanceMonitor\Console;

use Carbon\Carbon;
use Fruitcake\PerformanceMonitor\Storage\IncomingRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PruneDatabase extends Command
{
    protected $signature = 'performance-monitor:prune-database {--days=90 : Number of days to keep}';

    protected $description = 'Remove old requests from the database ';

    protected $chunkSize = 1000;

    public function handle()
    {
        $this->prune((new IncomingRequest())->getTable(), Carbon::now()->subDays($this->option('days')));
    }

    /**
     * Prune all of the entries older than the given date.
     *
     * @param string $table
     * @param \DateTimeInterface $before
     * @return int
     */
    public function prune($table, \DateTimeInterface $before)
    {
        $query = DB::table($table)->where('created_at', '<', $before);

        $totalDeleted = 0;
        do {
            $deleted = $query->take($this->chunkSize)->delete();
            $totalDeleted += $deleted;
        } while ($deleted !== 0);

        $this->info("Deleted {$totalDeleted} rows from {$table}");

        return $totalDeleted;
    }
}
