<?php
/**
 * Created by PhpStorm.
 * User: tdb
 * Date: 18/09/18
 * Time: 21:41.
 */

namespace App\Model;

class Currencies
{
    const GBP = 'Pound';
    const EURO = 'Euro';

    public static function getCurrencyChoices()
    {
        return [
            self::GBP => 'Pound',
            self::EURO => 'Euro',
        ];
    }

    /**
     * @return mixed|string
     */
    public static function getReadableCurrency($currency)
    {
        $currencyList = self::getCurrencyChoices();

        return isset($currencyList[$currency]) ? $currencyList[$currency] : '';
    }
}
