<?php

namespace Cache\DatabaseCache;

use App\Cache\DatabaseCache;
use App\DTO\CurrencyDTO;
use App\DTO\DateValue;
use Medoo\Medoo;
use PHPUnit\Framework\TestCase;

/**
 * {@see DatabaseCache::get()}
 */
class GetMethodTest extends TestCase
{
    protected Medoo $orm;

    public function testOk(): void
    {
        $date = new DateValue('2013-05-05');
        $currency = new CurrencyDTO('USD', $date, 500, 'testname', 60.60, 'RUB');
        $this->orm->insert('currencies', $currency->toArray());

        $cache = new DatabaseCache($this->orm);
        $result = $cache->get('USD', $date);

        $this->assertEquals($currency, $result);
    }

    public function testNull(): void
    {
        $date = new DateValue('2013-05-05');

        $cache = new DatabaseCache($this->orm);
        $result = $cache->get('notExistedKey', $date);

        $this->assertNull($result);
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