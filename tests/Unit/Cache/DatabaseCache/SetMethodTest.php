<?php

namespace Tests\Unit\Cache\DatabaseCache;

use App\Cache\DatabaseCache;
use App\DTO\CurrencyDTO;
use App\DTO\DateValue;
use Medoo\Medoo;
use PHPUnit\Framework\TestCase;

/**
 * {@see DatabaseCache::set()}
 */
class SetMethodTest extends TestCase
{
    protected Medoo $orm;

    public function testOk(): void
    {
        $date = new DateValue('2000-01-01');
        $currency = new CurrencyDTO('USD', $date, 500, 'testname', 60.60, 'RUB');

        $cache = new DatabaseCache($this->orm);
        $cache->set('test', $date, $currency);

        $result = $this->orm->get(
            'currencies', '*',
            [
                'code' => 'USD',
                'date' => $date->getValue()
            ]

        );

        $this->assertEquals('USD', $result['code']);
        $this->assertEquals('RUB', $result['base_currency_code']);
        $this->assertEquals('60.6', $result['value']);
        $this->assertEquals('500', $result['nominal']);
        $this->assertEquals('testname', $result['name']);
        $this->assertEquals('2000-01-01', $result['date']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->orm = new Medoo(['type' => 'sqlite', 'database' => 'cache_test.db']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->orm->delete('currencies', ["id[>]" => 0]);
    }
}