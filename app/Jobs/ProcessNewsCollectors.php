<?php

namespace App\Jobs;

use App\Exceptions\CollectorException;
use App\Models\Collector;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessNewsCollectors implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all collectors
        $collectors = Collector::all();

        foreach ($collectors as $collector) {
            // Dispatch a separate job for each collector
            NewsCollector::dispatch($collector);
        }
    }

    public function failed(Exception $exception)
    {
        // Log the exception or perform any other desired actions
        throw new CollectorException($exception->getMessage(), []);
    }
}
