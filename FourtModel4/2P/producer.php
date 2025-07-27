<?php
require_once 'vendor/autoload.php';

use Predis\Client;

class RedisQueueProducer
{
    private $redis;
    private $queueName;

    public function __construct($host = 'redis', $port = 6379, $queueName = 'task_queue')
    {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host'   => $host,
            'port'   => $port,
        ]);
        $this->queueName = $queueName;
    }

    public function addJob($data)
    {
        $job = [
            'id' => uniqid(),
            'data' => $data,
            'created_at' => date('Y-m-d H:i:s'),
            'attempts' => 0
        ];

        $this->redis->lpush($this->queueName, json_encode($job));

        echo "✅ Job added to queue: " . json_encode($job) . "\n";
        return $job['id'];
    }

    public function getQueueSize()
    {
        return $this->redis->llen($this->queueName);
    }
}


try {
    $producer = new RedisQueueProducer();

    $messages = [
        "Process user registration",
        "Send welcome email",
        "Generate report",
        "Backup database"
    ];

    foreach ($messages as $message) {
        $producer->addJob($message);
        sleep(1);
    }

    echo "\n📊 Total jobs in queue: " . $producer->getQueueSize() . "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
