<?php
/**
 * ExchangeRatesCBRF
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 *
 * @link http://www.idivision.ru/2010/10/24/cbrf-exchange-rates-php-class/
 */

namespace skeeks\modules\cms\money;

/**
 * Class ExchangeRatesCBRF
 * @package skeeks\modules\cms\money
 */
class ExchangeRatesCBRF
{
    /**
     * The exchange rates on defined date
     *
     * @var array
     */
    public $rates = array('byChCode' => array(), 'byCode' => array());

    /**
     * This method creates a connection to webservice of Central Bank of Russia
     * and obtains exchange rates, parse it and fills $rates property
     *
     * @param string $date The date on which exchange rates will be obtained
     */
    public function __construct($date = null)
    {
        if (!isset($date)) {
            $date = date("Y-m-d");
        }
        $client = new \SoapClient("http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL");


        $curs = $client->GetCursOnDate(array("On_date" => $date));
        $rates = new \SimpleXMLElement($curs->GetCursOnDateResult->any);

        foreach ($rates->ValuteData->ValuteCursOnDate as $rate) {
            $r = (float)$rate->Vcurs / (int)$rate->Vnom;
            $this->rates['byChCode'][(string)$rate->VchCode] = $r;
            $this->rates['byCode'][(int)$rate->Vcode] = $r;
        }

        // Adding an exchange rate of Russian Ruble
        $this->rates['byChCode']['RUB'] = 1;
        $this->rates['byCode'][643] = 1;
    }

    /**
     * This method returns exchange rate of given currency by its code
     *
     * @param mixed $code The alphabetic or numeric currency code
     *
     * @return float The exchange rate of given currency
     */
    public function GetRate($code)
    {
        if (is_string($code)) {
            $code = strtoupper(trim($code));
            return (isset($this->rates['byChCode'][$code])) ? $this->rates['byChCode'][$code] : false;

        } elseif (is_numeric($code)) {
            return (isset($this->rates['byCode'][$code])) ? $this->rates['byCode'][$code] : false;
        } else {
            return false;
        }
    }

    /**
     * This method returns exchange rate of given currency by its code
     *
     * @param mixed $CurCodeToSell The alphabetic or numeric currency code to sell
     * @param mixed $CurCodeToBuy The alphabetic or numeric currency code to buy
     *
     * @return float The cross exchange rate of given currencies
     */
    public function GetCrossRate($CurCodeToSell, $CurCodeToBuy)
    {
        $CurToSellRate = $this->GetRate($CurCodeToSell);
        $CurToBuyRate = $this->GetRate($CurCodeToBuy);

        if ($CurToSellRate && $CurToBuyRate) {
            return $CurToBuyRate / $CurToSellRate;
        } else {
            return false;
        }

    }

    /**
     * This method returns the array of exchange rates
     *
     * @return array The exchange rates
     */
    public function GetRates()
    {
        return $this->rates;
    }
}