<?php

namespace App\Models\Bank;

use App\Models\Bank\Abstr\BankAbstract;
use App\Models\Currency\CurrencyEnum;
use http\Exception;

class Bank extends BankAbstract {
    function __construct(array $exchangeRates){
        $this->exchangeRates = $exchangeRates;
        $this->bankAccounts = [];
        $this->paymentCards = [];
        $this->transactionsHistory = [];
    }

    public function exchange($sum){

    }

    public function calculateExchange($sum, $currencyFrom, $currencyTo){
        foreach ($this->exchangeRates as $exFrom => $units){
            if ($exFrom === $currencyFrom){
                foreach ($units as $unit){
                    if ($unit->getCurrencyCode() === $currencyTo){
                        return $sum / $unit->getSale();
                    }
                }
            }
        }

        // if not found
        foreach ($this->exchangeRates as $exTo => $units){
            if ($exTo === $currencyTo){
                foreach ($units as $unit){
                    if ($unit->getCurrencyCode() === $currencyFrom){
                        return $sum * $unit->getPurchase();
                    }
                }
            }
        }

        throw new \Exception('No such exchange');
    }
}
