<?php

namespace App\Parsers;

use App\DTO\CurrencyDTO;
use App\DTO\CurrencyValue;
use App\DTO\DateValue;

/**
 * Интерфейс загрузчиков курса валют из различных источников
 */
Interface ICurrencyParser
{
    public function getCurrency(CurrencyValue $currencyCode, DateValue $date ): CurrencyDTO;
}