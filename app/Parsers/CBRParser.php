<?php

namespace App\Parsers;


use App\Cache\ICache;
use App\Core\ServiceContainer;
use App\DTO\CurrencyDTO;
use App\DTO\CurrencyValue;
use App\DTO\DateValue;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SimpleXMLElement;

/**
 * Класс для загрузки курса валют с сайта cbr.ru
 */
class CBRParser implements ICurrencyParser
{
    protected const API_ENDPOINT = 'https://www.cbr.ru/scripts/XML_daily.asp';

    public function __construct(protected Client $client)
    {
    }

    /**
     * Парсинг курса валюты
     * @test {@see Tests\Unit\Parsers\CBRParser\GetCurrencyMethodTest::class}
     */
    public function getCurrency(CurrencyValue $currencyCode, DateValue $date): CurrencyDTO
    {
        /** @var ICache $cache */
        $cache = (new ServiceContainer)->get(ICache::class);
        $currency = $cache->get($currencyCode->getValue(), $date);

        if (!isset($currency)) {
            $queryParams = ['date_req' => $date->getValue('d/m/Y')];
            try {
                $response = $this->client->request('GET', self::API_ENDPOINT, ['query' => $queryParams]);
            } catch (GuzzleException $e) {
                echo $e->getMessage();
                exit();
            }

            $xml = $response->getBody()->getContents();

            $xmlContent = new SimpleXMLElement($xml);
            foreach ($xmlContent->Valute as $element) {
                $currency = new CurrencyDTO(
                    $element->CharCode,
                    $date,
                    (int)$element->Nominal,
                    $element->Name,
                    (float)str_replace(',', '.', $element->Value)
                );

                $cache->set($currencyCode->getValue(), $date, $currency);

                if ($currency->code === $currencyCode->getValue()) {
                    return $currency;
                }
            }

            throw new Exception('Сервис CBR не вернул запрашиваемую валюту');
        }

        return $currency;
    }
}