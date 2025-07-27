<?php
require_once 'vendor/autoload.php';

use Predis\Client;

class RedisQueueConsumer
{
    private $redis;
    private $queueName;
    private $logFile;

    public function __construct($host = 'redis', $port = 6379, $queueName = 'task_queue')
    {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host'   => $host,
            'port'   => $port,
        ]);
        $this->queueName = $queueName;
        $this->logFile = __DIR__ . '/queue_logs.txt';
    }

    public function processJobs()
    {
        echo "🚀 Starting Redis queue consumer...\n";
        echo "📝 Logs will be written to: {$this->logFile}\n";
        echo "⏹️  Press Ctrl+C to stop\n\n";

        while (true) {
            $result = $this->redis->brpop($this->queueName, 5);

            if ($result) {
                $queueName = $result[0];
                $jobData = json_decode($result[1], true);

                $this->processJob($jobData);
            } else {
                echo "⏳ No jobs in queue, waiting...\n";
            }
        }
    }

    private function processJob($job)
    {
        try {
            $startTime = microtime(true);

            echo "🔄 Processing job: {$job['id']}\n";
            echo "📄 Data: {$job['data']}\n";

            sleep(rand(1, 3));

            $endTime = microtime(true);
            $duration = round($endTime - $startTime, 2);

            $logEntry = [
                'job_id' => $job['id'],
                'data' => $job['data'],
                'processed_at' => date('Y-m-d H:i:s'),
                'duration' => $duration . 's',
                'status' => 'completed'
            ];

            file_put_contents(
                $this->logFile,
                json_encode($logEntry) . "\n",
                FILE_APPEND | LOCK_EX
            );

            echo "✅ Job {$job['id']} completed in {$duration}s\n\n";

        } catch (Exception $e) {
            echo "❌ Error processing job {$job['id']}: " . $e->getMessage() . "\n";
        }
    }
}


try {
    $consumer = new RedisQueueConsumer();
    $consumer->processJobs();

} catch (Exception $e) {
    echo "❌ Consumer error: " . $e->getMessage() . "\n";
}