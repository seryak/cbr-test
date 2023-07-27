<?php

namespace App\Queue;

use App\Core\ServiceContainer;
use App\DTO\CurrencyValue;
use App\DTO\DateValue;
use App\Parsers\ICurrencyParser;
use PhpAmqpLib\Message\AMQPMessage;

class CurrencyParserConsumer
{
    protected IAMQPClient $queueClient;

    public function __construct()
    {
        $this->queueClient = (new ServiceContainer())->get(IAMQPClient::class);
    }

    public function listen(): void
    {
        $callback = function (AMQPMessage $msg) {
            $data = json_decode($msg->body, true, 512, JSON_THROW_ON_ERROR);

            /** @var ICurrencyParser $parser */
            $parser = (new ServiceContainer())->get(ICurrencyParser::class);
            $parser->getCurrency(new CurrencyValue('USD'), new DateValue($data['date']));
            $msg->ack();
            echo ' [x] Received ', $msg->body, "\n";
        };

        try {
            $this->queueClient->listen('currency-parsing', $callback);
        } catch (\Exception $e) {
            sleep(15);
            $this->queueClient->listen('currency-parsing', $callback);
        }
    }
}