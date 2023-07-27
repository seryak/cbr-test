<?php

namespace App\Core;

use App\DTO\CurrencyValue;
use App\DTO\DateValue;
use App\Enums\CurrencyCode;
use App\Responsers\CliResponser;
use App\Service\CurrencyInfoService;

/**
 * Класс приложения
 */
class App
{
    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $appArguments = getopt(null, ['date:', 'currency:', 'base:']);
        $appArguments['base'] = $appArguments['base'] ?? CurrencyCode::RUB;

        if (!isset($appArguments['currency']) || !isset($appArguments['date'])) {
            throw new \Exception('Вы не указали параметр currency или date');
        }

        $currency = new CurrencyValue($appArguments['currency']);
        $baseCurrency = new CurrencyValue($appArguments['base']);
        $date = new DateValue($appArguments['date']);

        $currencyService = new CurrencyInfoService($currency, $baseCurrency, $date);
        $responseDTO = $currencyService->getCurrencyInfo();

        $response = new CliResponser($responseDTO->todayCurrency, $responseDTO->yesterdayCurrency);
        $response->printOutput();
    }
}