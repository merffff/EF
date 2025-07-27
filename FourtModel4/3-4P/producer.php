<?php
require_once 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQProducer
{
    private $connection;
    private $channel;
    private $queueName;

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

        $this->channel->queue_declare(
            $this->queueName,
            false,
            true,
            false,
            false
        );
    }

    public function sendMessage($message, $priority = 0)
    {
        $messageData = [
            'id' => uniqid(),
            'body' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
            'priority' => $priority
        ];

        $msg = new AMQPMessage(
            json_encode($messageData),
            [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                'priority' => $priority
            ]
        );

        $this->channel->basic_publish($msg, '', $this->queueName);

        echo "✅ Message sent to RabbitMQ:\n";
        echo json_encode($messageData, JSON_PRETTY_PRINT) . "\n\n";

        return $messageData['id'];
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}


try {
    echo "🐰 RabbitMQ Producer starting...\n\n";

    $producer = new RabbitMQProducer();

    $messages = [
        ['message' => 'Process user payment', 'priority' => 10],
        ['message' => 'Send notification email', 'priority' => 5],
        ['message' => 'Generate monthly report', 'priority' => 3],
        ['message' => 'Clean temporary files', 'priority' => 1],
        ['message' => 'Backup user data', 'priority' => 8]
    ];

    foreach ($messages as $msg) {
        $producer->sendMessage($msg['message'], $msg['priority']);
        sleep(1);
    }

    $producer->close();
    echo "\n✅ Producer finished successfully!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
