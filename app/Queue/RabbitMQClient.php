<?php

namespace App\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQClient implements IAMQPClient
{
    protected AMQPChannel $channel;
    protected AMQPStreamConnection $connection;

    public function __construct()
    {
        $connection = $this->connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $this->channel = $connection->channel();
    }

    public function send(string $message, string $queueName): void
    {
        $this->channel->queue_declare($queueName, false, true, false, false);

        $msg = new AMQPMessage($message, ['delivery_mode' => 2]);
        $this->channel->basic_publish($msg, '', $queueName);
    }

    public function listen(string $queueName, callable $callback): void
    {
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($queueName, '', false, false, false, false, $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->close();
    }

    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}