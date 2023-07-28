<?php

namespace App\DTO;

use Exception;
use App\Enums\CurrencyCode;

class CurrencyValue
{
    protected string $currencyCode;

    public function __construct(string $currencyCode)
    {
        $this->validate($currencyCode);
        $this->currencyCode = $currencyCode;
    }

    public function getValue(): string
    {
        return $this->currencyCode;
    }

    /**
     * Проверка корректности значения
     * @throws Exception
     *
     * @test {@see \Tests\Unit\DTO\CurrencyValue\ValidateMethodTest::class}
     */
    protected function validate(string $value): bool
    {
        if (isset(CurrencyCode::getAllValues()[$value])) {
            return true;
        }

        throw new \Exception('Неверный код валюты. Допустимые коды: '. implode(', ', CurrencyCode::getAllValues()) );
    }
}