<?php

namespace Tests\Unit\DTO\DateValue;

use ReflectionClass;
use App\DTO\DateValue;

/**
 * {@see DateValue::validate()}
 */
class ValidateMethodTest extends \PHPUnit\Framework\TestCase
{
    protected ReflectionClass $class;
    protected DateValue $obj;

    protected function setUp(): void
    {
        parent::setUp();

        $this->class = new ReflectionClass(DateValue::class);
        $this->obj = new DateValue('2000-01-01');
    }

    /**
     * Кейс, где строка не является датой
     */
    public function testWrongStringDate(): void
    {
        $this->expectExceptionMessage('Неверный формат даты. YYYY-MM-DD');
        $this->callMethod('111');
    }

    /**
     * Кейс, где строка не содержит нужное количество аргументов даты
     */
    public function testShortWrongFormatDate(): void
    {
        $this->expectExceptionMessage('Неверный формат даты. YYYY-MM-DD');
        $this->callMethod('2022-12');
    }

    /**
     * Кейс, где строка содержит неверное количество аргументов даты
     */
    public function testLongWrongFormatDate(): void
    {
        $this->expectExceptionMessage('Неверный формат даты. YYYY-MM-DD');
        $this->callMethod('2022-12-12-12');
    }

    /**
     * Кейс, где строка содержит не существующую дату
     */
    public function testWrongDate(): void
    {
        $this->expectExceptionMessage('Неправильная дата, проверьте корректность даты и номера месяца');
        $this->callMethod('2022-56-56');
    }

    /**
     * Кейс, где строка содержит не верный формат даты
     */
    public function testWrongFormatDate(): void
    {
        $this->expectExceptionMessage('Неверный формат даты. YYYY-MM-DD');
        $this->callMethod('2022/12/12');
    }

    /**
     * Кейс, где строка содержит дату в будущем
     */
    public function testFutureDate(): void
    {
        $this->expectExceptionMessage('Дата, которую вы запрашиваете, еще не наступила');
        $this->callMethod('2025-12-12');
    }

    /**
     * Успешный кейс
     */
    public function testOk(): void
    {
        $result = $this->callMethod('2022-12-12');
        $this->assertTrue($result);
    }

    /**
     * @throws \ReflectionException
     */
    public function callMethod(string $date)
    {
        $method = $this->class->getMethod('validate');
        $method->setAccessible(true);
        return $method->invokeArgs($this->obj, [$date]);

    }
}