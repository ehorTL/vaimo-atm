<?php

namespace App\Models\Atm;

use App\Models\Atm\Abstr\AtmAbstract;
use App\Models\Bank\Transaction\TransactionType;
use App\Models\Currency\CurrencyEnum;
use App\Models\Bank\Abstr\BankAbstract;
use App\Models\Bank\Abstr\PaymentCardAbstract;

/**
 * ATM implementation.
 * Implements methods declared and described in its abstract parent class.
 *
 *
 * ******
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

    protected function authorizeUser($card, $pincode){
        if (!$card->pinCodeIsValid($pincode)){
            throw new \Exception('Pincode is not valid. Access denied');
        }

        return true;
    }

    public function execTransactionToCard(PaymentCardAbstract $card, $pincode, $sum, $currency,
                                          PaymentCardAbstract $toCard){
        $this->authorizeUser($card, $pincode);
        return $this->bank->execTransaction($sum, $currency, $card->getBankAccountNumber(),
            $toCard->getBankAccountNumber());
    }

    public function execTransactionToAccount(PaymentCardAbstract $card, $pincode, $sum, $currency, $toAccount){
        $this->authorizeUser($card, $pincode);
        return $this->bank->execTransaction($sum, $currency, $card->getBankAccountNumber(), $toAccount);
    }

    public function getBalance(PaymentCardAbstract $card, $pincode){
        $this->authorizeUser($card, $pincode);

        return $card->getCardBalance();
    }

    public function withdraw(PaymentCardAbstract $card, $pincode, $sum, $currency){
        $this->authorizeUser($card, $pincode);

        $canExtract = $this->canExtract($sum, $currency);
        if ($canExtract[0]){
            if ($currency === $card->getBankAccountNumber()->getCurrency()){
                if ($card->getBankAccountNumber()->canWriteOff($sum)){
                    $card->getBankAccountNumber()->writeOff($sum, $currency);
                    $this->extract($currency, $canExtract[1]['partition']);
                    $this->bank->writeOff($sum, $currency, TransactionType::WITHDRAWAL,
                        $card->getBankAccountNumber(), null);
                    return $canExtract[1];
                }
            } else {
                $writeOffSum = $this->bank->calculateExchange($sum,
                    $currency, $card->getBankAccountNumber()->getCurrency());
                if ($card->getBankAccountNumber()->canWriteOff($writeOffSum)){
                    $card->getBankAccountNumber()->writeOff($sum, $card->getBankAccountNumber()->getCurrency());
                    $this->extract($card->getBankAccountNumber()->getCurrency(),
                        $canExtract[1]['partition']);
                    $this->bank->writeOff($sum, $currency, TransactionType::WITHDRAWAL,
                        $card->getBankAccountNumber(), null);
                    return $canExtract[1];
                }
            }
        }

        throw new \Exception('Withdrawal cannot be executed.');
    }

    /**
     * Solution should be as `Knapsack problem` solution, but here used another simple one.
     */
    public function canExtract($sum, $currency=CurrencyEnum::UAH){
        if ($this->totalBanknotesSum()[$currency] >= $sum){
            $partition = $this->partition($sum, $currency);
            return [true, $partition];
        }

        return [false, []];
    }

    /**
     * In case ATM has such a sum, calculates what banknotes the sum can be extracted.
     * The sum is "rounded" so that it can be extracted with available banknotes.
     */
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

    /**
     * Assuming that such partition is available.
     * @param $partition array of the form [nominal_unique => quantity, ...]
     */
    protected function extract($currency, $partition){
        $currencyCassettes = array_filter($this->banknoteCassettes,
            function ($key, $val) use ($currency) {
                return $key->getCurrency() === $currency;
        }, ARRAY_FILTER_USE_BOTH);

        usort($currencyCassettes, function($a, $b){
            if ($a->getNominalValue() == $b->getNominalValue()){
                return 0;
            }
            return ($a->getNominalValue() < $b->getNominalValue()) ? 1 : -1;
        });

        $partitionKeys = array_keys($partition);
        for ($partitionIndex=0; $partitionIndex<count($partitionKeys); $partitionIndex++){
            for ($i=0; $i<count($currencyCassettes); $i++){
                if ($partitionKeys[$partitionIndex] ===
                    $currencyCassettes[$i]->getNominalValue()){
                    $banknotesToExtractQuantity = min($partition[$partitionKeys[$partitionIndex]],
                        $currencyCassettes[$i]->getQuantity());
                    $currencyCassettes[$i]->extractBanknotes($banknotesToExtractQuantity);
                    $partition[$partitionKeys[$partitionIndex]] -= $banknotesToExtractQuantity;
                }
            }
        }
    }

    public function changePinCode(PaymentCardAbstract $card, $oldPincode, $newPincode){
        $this->authorizeUser($card, $oldPincode);

        $card->setPinCode($newPincode);
    }

    public function forgotPinCode($card){
        // TODO: call to SMS-service method and try to generate
        // new pincode and send it by SMS to users phone number
    }
}
