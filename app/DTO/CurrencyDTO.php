<?php

namespace App\DTO;

class CurrencyDTO
{
    public function __construct(public string $code, public DateValue $date, public int $nominal, public string $name, public float $value, public string $baseCurrencyCode = 'RUB')
    {}

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'nominal' => $this->nominal,
            'name' => $this->name,
            'base_currency_code' => $this->baseCurrencyCode,
            'date' => $this->date->getValue(),
            'value' => $this->value
        ];
    }
}