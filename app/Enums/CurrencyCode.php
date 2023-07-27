<?php

namespace App\Enums;

use ReflectionClass;

class CurrencyCode
{
    public const AUD = 'AUD';
    public const AZN = 'AZN';
    public const GBP = 'GBP';
    public const AMD = 'AMD';
    public const BYN = 'AMD';
    public const BGN = 'BGN';
    public const BRL = 'BRL';
    public const HUF = 'HUF';
    public const VND = 'VND';
    public const HKD = 'HKD';
    public const GEL = 'GEL';
    public const DKK = 'DKK';
    public const AED = 'AED';
    public const EGP = 'EGP';
    public const INR = 'INR';
    public const IDR = 'IDR';
    public const KZT = 'KZT';
    public const CAD = 'CAD';
    public const QAR = 'QAR';
    public const KGS = 'KGS';
    public const MDL = 'MDL';
    public const NZD = 'NZD';
    public const NOK = 'NOK';
    public const PLN = 'PLN';
    public const RON = 'RON';
    public const XDR = 'XDR';
    public const SGD = 'SGD';
    public const TJS = 'TJS';
    public const THB = 'THB';
    public const TRY = 'TRY';
    public const TMT = 'TMT';
    public const UZS = 'UZS';
    public const UAH = 'UAH';
    public const CZK = 'CZK';
    public const SEK = 'SEK';
    public const CHF = 'CHF';
    public const RSD = 'RSD';
    public const ZAR = 'ZAR';
    public const KRW = 'KRW';
    public const JPY = 'JPY';
    public const RUB = 'RUB';
    public const USD = 'USD';
    public const EUR = 'EUR';
    public const CNY = 'CNY';

    public static function getAllValues(): array
    {
        return (new ReflectionClass(self::class))->getConstants();
    }
}