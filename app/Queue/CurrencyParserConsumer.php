<?php

namespace App\Queue;

use App\Core\ServiceContainer;
use App\DTO\CurrencyValue;
use App\DTO\DateValue;
use App\Parsers\ICurrencyParser;

class CurrencyParserConsumer
{
    protected IAMQPClient $queueClient;

    public function __construct()
    {
        $this->queueClient = (new ServiceContainer())->get(IAMQPClient::class);
    }

    public function listen(): void
    {
        $callback = function ($msg) {
            $data = json_decode($msg->body, true, 512, JSON_THROW_ON_ERROR);

            /** @var ICurrencyParser $parser */
            $parser = (new ServiceContainer())->get(ICurrencyParser::class);
            $parser->getCurrency(new CurrencyValue($data['currency']), new DateValue($data['date']));

            echo ' [x] Received ', $msg->body, "\n";
        };

        $this->queueClient->listen('currency-parsing', $callback);
    }
}