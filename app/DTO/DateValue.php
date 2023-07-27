<?php

namespace App\DTO;

use Carbon\Carbon;
use Exception;
use Kint\Kint;

class DateValue
{
    protected Carbon $dateTime;

    public function __construct(string $dateTimeString) {
        try {
            $this->validate($dateTimeString);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $this->dateTime = Carbon::make($dateTimeString);
    }

    public function getValue(string $format = 'Y-m-d'): string
    {
        return $this->dateTime->format($format);
    }

    /**
     * Проверка корректности значения
     * @throws Exception
     *
     * @test {@see \Tests\Unit\DTO\DateValue\ValidateMethodTest::class}
     */
    protected function validate(string $value): bool
    {
        $dateArguments = explode('-', $value);
        if (count($dateArguments) !== 3) {
            throw new Exception('Неверный формат даты. YYYY-MM-DD');
        }

        [$year, $month, $day] = $dateArguments;
        if (!checkdate($month, $day, $year)) {
            throw new Exception('Неправильная дата, проверьте корректность даты и номера месяца');
        }

        $valueDate = Carbon::make($value)->startOfDay();
        $today = Carbon::today();
        if ($today < $valueDate) {
            throw new Exception('Дата, которую вы запрашиваете, еще не наступила');
        }

        return true;
    }
}