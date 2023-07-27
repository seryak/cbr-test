<?php

namespace App\Queue;

use App\Core\ServiceContainer;
use App\DTO\CurrencyValue;
use App\DTO\DateValue;
use Carbon\Carbon;

class CurrencyParserProducer
{
    protected IAMQPClient $queueClient;

    public function __construct()
    {
        $this->queueClient = (new ServiceContainer())->get(IAMQPClient::class);
    }

    public function send(CurrencyValue $currencyCode, DateValue $date): void
    {
        for ($i=0; $i<180; $i++) {
            $date = $i === 0 ? $date : new DateValue(Carbon::make($date->getValue())->subDay()->format('Y-m-d'));
            $message = ['date' => $date->getValue(), 'currency' => $currencyCode->getValue()];
            $this->queueClient->send(json_encode($message, JSON_THROW_ON_ERROR), 'currency-parsing');
        }
        $this->queueClient->close();

        echo " [x] Sent";
    }
}