<?php

namespace App\Cache;

use App\DTO\CurrencyDTO;
use App\DTO\DateValue;

/**
 * Интерфейс хранилища кеша
 */
Interface ICache
{
    public function set(string $key, DateValue $date, CurrencyDTO $currency): void;
    public function get(string $key, DateValue $date): ?CurrencyDTO;
}