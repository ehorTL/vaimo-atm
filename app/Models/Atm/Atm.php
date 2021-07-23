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

            $nominals = $this->getAvailableBanknotesNominals()[$currency];
            // TODO

            return true;
        }

        return false;
    }

    public function partition($sum, $currency){
        $sumInit = $sum;
        $nominalsAndQuantity = $this->getAvailableBanknotesNominals()[$currency];
        $nominals = array_keys($nominalsAndQuantity);
        $partition = array();

        $currentSum = 0;
        $index = count($nominals) - 1;
        while ($currentSum < $sumInit){
            $remainder = $sum % $nominals[$index];
            $banknotesNeeded = ($sum - $remainder) / $nominals[$index];
            $partition[$nominals[$index]] = min($nominalsAndQuantity[$nominals[$index]], $banknotesNeeded);
            $currentSum += $partition[$nominals[$index]] * $nominals[$index];
            $sum = $sum - $partition[$nominals[$index]] * $nominals[$index];
            $index--;

            if ($index == -1 && $remainder != 0){
                $partition[$nominals[0]] += 1;
                $currentSum += $partition[$nominals[0]] * $nominals[0];
            }
        }

        return ["controlSum" => $currentSum, 'partition' => $partition];
    }

    /**
     * Returns array with such structure:
     * [
     *      currencyCode => [nominal_unique => total_quantity],
     * ]
     */
    public function getAvailableBanknotesNominals(){
        $nominals = array();

        foreach ($this->banknoteCassettes as $cassette){
            $nominals[$cassette->getCurrency()] = array();
        }
        foreach ($this->banknoteCassettes as $cassette){
          if (isset($nominals[$cassette->getCurrency()][$cassette->getNominalValue()])){
              $nominals[$cassette->getCurrency()][$cassette->getNominalValue()] +=
                  $cassette->getQuantity();
          } else {
              $nominals[$cassette->getCurrency()][$cassette->getNominalValue()] =
                  $cassette->getQuantity();
          }
        }

        $keys = array_keys($nominals);
        foreach ($keys as $key) {
            ksort($nominals[$key], SORT_NUMERIC);
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
