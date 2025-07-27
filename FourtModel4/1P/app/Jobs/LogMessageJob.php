<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LogMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Log::channel('single')->info('Queue Job executed: ' . $this->message, [
            'timestamp' => now()->toDateTimeString(),
            'job_id' => $this->job->getJobId(),
        ]);


        $logFile = storage_path('logs/queue_jobs.log');
        $logMessage = '[' . now()->toDateTimeString() . '] Queue Job: ' . $this->message . PHP_EOL;
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);


        sleep(2);

        echo "Job processed: " . $this->message . PHP_EOL;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('LogMessageJob failed: ' . $exception->getMessage(), [
            'message' => $this->message,
            'exception' => $exception,
        ]);
    }
}
