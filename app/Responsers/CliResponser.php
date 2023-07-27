<?php

namespace App\Responsers;

use App\DTO\CurrencyDTO;

/**
 * Класс для вывода информации в терминале
 */
class CliResponser implements IResponser
{

    public function __construct(protected CurrencyDTO $todayCurrency, protected CurrencyDTO $yesterdayCurrency) {}

    /**
     * Выводит информацию на экран
     * @return void
     */
    public function printOutput() : void
    {
        $difference = $this->yesterdayCurrency->value - $this->todayCurrency->value;
        echo "\033[31mКурс {$this->todayCurrency->code} в {$this->todayCurrency->baseCurrencyCode} на {$this->todayCurrency->date->getValue()} : {$this->todayCurrency->value} \033[0m\n";
        echo "\033[34mИзменение с прошлым днем {$difference}  \033[0m\n";
    }
}