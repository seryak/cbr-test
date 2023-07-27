<?php

namespace App\Cache;

use App\DTO\CurrencyDTO;
use App\DTO\DateValue;
use Medoo\Medoo;

class DatabaseCache implements ICache
{

    public function __construct(protected Medoo $orm)
    {
    }

    /**
     * Запись в кеш
     *
     * @test {@see \Tests\Unit\Cache\DatabaseCache\SetMethodTest::class}
     */
    public function set(string $key, DateValue $date, CurrencyDTO $currency): void
    {
        $this->orm->insert('currencies', $currency->toArray());
    }

    /**
     * Чтение из кеша
     *
     * @test {@see \Tests\Unit\Cache\DatabaseCache\GetMethodTest::class}
     */
    public function get(string $key, DateValue $date): ?CurrencyDTO
    {
        $result = $this->orm->get(
            'currencies', '*',
            [
                'code' => $key,
                'date' => $date->getValue()
            ]
        );

        if ($result) {
            return new CurrencyDTO($result['code'], $date, $result['nominal'], $result['name'], $result['value']);
        }

        return null;
    }
}