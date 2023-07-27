<?php

namespace App\Queue;

interface IAMQPClient
{
    public function send(string $message, string $queueName): void;

    public function listen(string $queueName, callable $callback): void;
}