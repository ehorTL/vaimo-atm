<?php

namespace App\Models\Atm;

use App\Models\Atm\Abstr\AtmAbstract;
use App\Models\Currency\CurrencyEnum;
use App\Models\Bank\Abstr\BankAbstract;

/**
 * Each action must be authorized, so each method gets card and pincode as arguments.
 * There can also be saved card and user authorization status,
 * but this is not the current implementation case.
 */
class Atm extends AtmAbstract {
    function __construct(BankAbstract $bank, string $address, $banknoteCassettes = [])
    {
        $this->bank = $bank;
        $this->banknoteCassettes = $banknoteCassettes;
        $this->address = $address;
    }

    public function execTransactionToCard($card, $pincode, $sum, $toCard){

    }

    public function execTransactionToAccount($card, $pincode, $sum, $toAccount){

    }

    protected function bankTransaction($card, $pincode, $toAccount){

    }

    public function getBalance($card, $pincode, $sum){}

    public function withdraw($card, $pincode, $sum){}

    /**
     * Solution should be as `Knapsack problem` solution, but here used another simple one.
     */
    protected function canExtract($sum, $currency=CurrencyEnum::UAH){
        if ($this->totalBanknotesSum()[$currency] >= $sum){

            $nominals = $this->getAvailableBanknotesNominals();
            // TODO
            return true;
        }

        return false;
    }

    public function getAvailableBanknotesNominals(){
        $nominals = array();

        foreach ($this->banknoteCassettes as $cassette){
            $nominals[$cassette->getCurrency()] = array();
        }
        foreach ($this->banknoteCassettes as $cassette){
            $nominals[$cassette->getCurrency()][] = $cassette->getNominalValue();
        }

        foreach ($nominals as $key => $val){
            $nominals[$key] = array_unique($val, SORT_NUMERIC);
        }

        return $nominals;
    }

    /**
     * TODO: protected method
     */
    public function totalBanknotesSum(){
        $currencySums = array();
        foreach ($this->banknoteCassettes as $cassette){
             if (isset($currencySums[$cassette->getCurrency()])){
                 $currencySums[$cassette->getCurrency()] += $cassette->getControlSum();
             } else {
                 $currencySums[$cassette->getCurrency()] = $cassette->getControlSum();
             }
        }

        return $currencySums;
    }

}
