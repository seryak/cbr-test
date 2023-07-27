<?php

namespace App\DTO;

class ResponseDTO
{
    public function __construct(public CurrencyDTO $todayCurrency,  public CurrencyDTO $yesterdayCurrency)
    {}
}