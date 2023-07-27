<?php

namespace App\Service;

use Carbon\Carbon;
use App\Core\ServiceContainer;
use App\DTO\CurrencyDTO;
use App\DTO\CurrencyValue;
use App\DTO\DateValue;
use App\DTO\ResponseDTO;
use App\Enums\CurrencyCode;
use App\Parsers\ICurrencyParser;

class CurrencyInfoService
{

    public function __construct(protected CurrencyValue $currencyCode, protected CurrencyValue $baseCurrencyCode, protected DateValue $date) {}
    public function getCurrencyInfo(): ResponseDTO
    {
        /** @var ICurrencyParser $parser */
        $parser = (new ServiceContainer())->get(ICurrencyParser::class);
        $todayCurrency = $parser->getCurrency($this->currencyCode, $this->date);

        $yesterdayDate = new DateValue(Carbon::make($this->date->getValue())->subDay()->format('Y-m-d'));
        $yesterdayCurrency = $parser->getCurrency($this->currencyCode, $yesterdayDate);

        if ($this->baseCurrencyCode->getValue() !== CurrencyCode::RUB) {
            $todayCurrency = $this->calculateFromBaseCurrency($todayCurrency);
            $yesterdayCurrency = $this->calculateFromBaseCurrency($yesterdayCurrency);
        }

        return new ResponseDTO($todayCurrency, $yesterdayCurrency);
    }

    protected function calculateFromBaseCurrency(CurrencyDTO $currency): CurrencyDTO
    {
        /** @var ICurrencyParser $parser */
        $parser = (new ServiceContainer())->get(ICurrencyParser::class);
        $baseCurrency = $parser->getCurrency($this->baseCurrencyCode, $this->date);

        $basePrice = $baseCurrency->value / $baseCurrency->nominal;
        $currencyPrice = $currency->value / $currency->nominal / $basePrice;

        return new CurrencyDTO($currency->code, $currency->date, $currency->nominal, $currency->name, $currencyPrice, $this->baseCurrencyCode->getValue());
    }
}