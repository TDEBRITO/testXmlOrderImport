<?php

namespace App\Twig;

use App\Entity\ExchangeRate;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class currencyExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('currency', [$this, 'currencyFilter']),
        ];
    }

    public function currencyFilter($price, ExchangeRate $exchangeRate, $currencyFilter)
    {
        if ($exchangeRate->getCurrencyCode() == $currencyFilter) {
            return $price.' '.$exchangeRate->getCurrencyCode();
        }

        if ($exchangeRate->getExchangeCurrency() == $currencyFilter) {
            $finalPrice = $price * $exchangeRate->getExchangeValue();
        }

        return $finalPrice.' '.$currencyFilter;
    }
}
