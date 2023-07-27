<?php

namespace App\Core;

use App\Queue\IAMQPClient;
use App\Queue\RabbitMQClient;
use GuzzleHttp\Client;
use Medoo\Medoo;
use App\Cache\DatabaseCache;
use App\Cache\ICache;
use App\Parsers\CBRParser;
use App\Parsers\ICurrencyParser;

/**
 * Сервис-контейнер
 */
class ServiceContainer
{
    private array $objects;

    public function __construct()
    {
        $this->objects = [
            ICache::class => function() {
                $db = new Medoo(['type' => 'sqlite', 'database' => 'cache.db']);
                return new DatabaseCache($db);
            },
            ICurrencyParser::class => fn() => new CBRParser(new Client()),
            IAMQPClient::class => fn() => new RabbitMQClient()
        ];
    }

    public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }

    public function get(string $id): mixed
    {
        return $this->objects[$id]();
    }
}