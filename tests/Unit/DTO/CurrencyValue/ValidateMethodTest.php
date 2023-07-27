<?php

namespace Tests\Unit\DTO\CurrencyValue;

use App\DTO\CurrencyValue;
use App\Enums\CurrencyCode;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * {@see CurrencyValue::validate()}
 */
class ValidateMethodTest extends TestCase
{
    protected ReflectionClass $class;
    protected CurrencyValue $obj;

    /**
     * Кейс, где строка не является датой
     */
    public function testWrongStringCode(): void
    {
        $this->expectExceptionMessage(
            'Неверный код валюты. Допустимые коды: ' . implode(', ', CurrencyCode::getAllValues())
        );
        $this->callMethod('111');
    }

    /**
     * @throws ReflectionException
     */
    public function callMethod(string $code)
    {
        $method = $this->class->getMethod('validate');
        $method->setAccessible(true);
        return $method->invokeArgs($this->obj, [$code]);
    }

    /**
     * Успешный кейс
     */
    public function testOk(): void
    {
        $result = $this->callMethod(CurrencyCode::RUB);
        $this->assertTrue($result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->obj = new CurrencyValue('USD');
        $this->class = new ReflectionClass(CurrencyValue::class);
    }
}