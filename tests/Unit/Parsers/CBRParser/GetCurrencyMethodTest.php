<?php

namespace Tests\Unit\Parsers\CBRParser;

use App\DTO\CurrencyDTO;
use App\DTO\CurrencyValue;
use App\DTO\DateValue;
use App\Parsers\CBRParser;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * {@see CBRParser::getCurrency()}
 */
class GetCurrencyMethodTest extends TestCase
{
    public function testOk(): void
    {
        $currencyValue = new CurrencyValue('USD');
        $dateValue = new DateValue('2022-12-12');
        $parser = new CBRParser(new Client());
        $result = $parser->getCurrency($currencyValue, $dateValue);

        $expected = new CurrencyDTO('USD', $dateValue, 1, 'Доллар США', 62.3813);

        $this->assertEquals($expected, $result);
    }

    public function testFail(): void
    {
        $currencyValue = new CurrencyValue('USD');
        $reflectionClass = new ReflectionClass(CurrencyValue::class);
        $reflectionProperty = $reflectionClass->getProperty('currencyCode');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($currencyValue, 'test');

        $dateValue = new DateValue('2022-12-12');
        $parser = new CBRParser(new Client());

        $this->expectExceptionMessage('Сервис CBR не вернул запрашиваемую валюту');
        $parser->getCurrency($currencyValue, $dateValue);
    }
}