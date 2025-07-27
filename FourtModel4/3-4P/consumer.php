<?php
require_once 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQConsumer
{
    private $connection;
    private $channel;
    private $queueName;
    private $logFile;

    public function __construct(
        $host = 'rabbitmq',
        $port = 5672,
        $user = 'guest',
        $password = 'guest',
        $queueName = 'task_queue'
    ) {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();
        $this->queueName = $queueName;
        $this->logFile = __DIR__ . '/rabbitmq_logs.txt';

        $this->channel->queue_declare(
            $this->queueName,
            false,
            true,
            false,
            false
        );

        $this->channel->basic_qos(null, 1, null);
    }

    public function startConsuming()
    {
        echo "🐰 RabbitMQ Consumer starting...\n";
        echo "📝 Logs will be written to: {$this->logFile}\n";
        echo "⏹️  Press Ctrl+C to stop\n\n";

        $callback = function (AMQPMessage $msg) {
            $this->processMessage($msg);
        };

        $this->channel->basic_consume(
            $this->queueName,
            '',
            false,
            false,
            false,
            false,
            $callback
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    private function processMessage(AMQPMessage $msg)
    {
        try {
            $startTime = microtime(true);
            $messageData = json_decode($msg->getBody(), true);

            echo "🔄 Processing message: {$messageData['id']}\n";
            echo "📄 Body: {$messageData['body']}\n";
            echo "🕐 Received at: {$messageData['timestamp']}\n";
            echo "⭐ Priority: {$messageData['priority']}\n";

            $processingTime = max(1, 5 - $messageData['priority']);
            sleep($processingTime);

            $endTime = microtime(true);
            $duration = round($endTime - $startTime, 2);

            $logEntry = [
                'message_id' => $messageData['id'],
                'body' => $messageData['body'],
                'priority' => $messageData['priority'],
                'received_at' => $messageData['timestamp'],
                'processed_at' => date('Y-m-d H:i:s'),
                'duration' => $duration . 's',
                'status' => 'completed'
            ];

            file_put_contents(
                $this->logFile,
                json_encode($logEntry) . "\n",
                FILE_APPEND | LOCK_EX
            );

            $msg->ack();

            echo "✅ Message {$messageData['id']} processed in {$duration}s\n\n";

        } catch (Exception $e) {
            echo "❌ Error processing message: " . $e->getMessage() . "\n";
            $msg->nack(false, false);
        }
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}


try {
    $consumer = new RabbitMQConsumer();
    $consumer->startConsuming();

} catch (Exception $e) {
    echo "❌ Consumer error: " . $e->getMessage() . "\n";
}
