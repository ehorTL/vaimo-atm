<?php

namespace App\Models\Currency;

abstract class CurrencyEnum{
    const USD = 0;
    const UAH = 1;
    const EUR = 2;
    const RUB = 3;

    public static function currencyToString(int $currency){
        switch ($currency){
            case 0:
                return 'USD';
                break;
            case 1:
                return 'UAH';
                break;
            case 2:
                return 'EUR';
                break;
            case 3:
                return 'RUB';
                break;
            default:
                throw new \Exception('No such currency');
        }
    }
}
