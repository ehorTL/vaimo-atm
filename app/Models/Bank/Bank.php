<?php

namespace App\Models\Bank;

use App\Models\Bank\Abstr\BankAbstract;
use App\Models\Bank\Transaction\Transaction;
use App\Models\Bank\Transaction\TransactionType;
use App\Models\Currency\CurrencyEnum;
use App\Models\Bank\BankAccountNumber;
use http\Exception;
use Carbon\Carbon;

class Bank extends BankAbstract {
    function __construct(array $exchangeRates){
        $this->exchangeRates = $exchangeRates;
        $this->bankAccounts = [];
        $this->paymentCards = [];
        $this->transactionsHistory = [];
    }

    public function calculateExchange($sum, $currencyFrom, $currencyTo){
        foreach ($this->exchangeRates as $exFrom => $units){
            if ($exFrom === $currencyFrom){
                foreach ($units as $unit){
                    if ($unit->getCurrencyCode() === $currencyTo){
                        return round($sum / $unit->getSale(), 2, PHP_ROUND_HALF_UP);
                    }
                }
            }
        }

        // if not found
        foreach ($this->exchangeRates as $exTo => $units){
            if ($exTo === $currencyTo){
                foreach ($units as $unit){
                    if ($unit->getCurrencyCode() === $currencyFrom){
                        return round($sum * $unit->getPurchase(), 2, PHP_ROUND_HALF_UP);
                    }
                }
            }
        }

        throw new \Exception('No such exchange');
    }

    public function execTransaction($sum, $currency, BankAccountNumber $fromAccount, BankAccountNumber $toAccount){
        $success = $this->transfer($sum, $currency, $fromAccount, $toAccount);
        if ($success){
            $transaction = new Transaction(TransactionType::CUSTOMER_TRANSFER, $sum,
                $currency);
            $transaction->setFromBankAccount($fromAccount);
            $transaction->setToBankAccount($toAccount);
            $transaction->setTimestamp(Carbon::now());

            $this->transactionsHistory[] = $transaction;

            return true;
        }

        return false;
    }

    protected function transfer($sum, $currency, BankAccountNumber $fromAccount, BankAccountNumber $toAccount){
        // TODO: some checks

        if ($currency !== $fromAccount->getCurrency()){
            // TODO: implement this case
            throw new \Exception('Transfer currency must be the same as account currency');
        }

        $sumToWriteOff = $sum; // additional commissions can be added
        $sumToTopUp = $sum;
        if ($fromAccount->getCurrency() !== $toAccount->getCurrency()){
            $sumToTopUp = $this->calculateExchange($sum, $currency, $toAccount->getCurrency());
        }

        if ($fromAccount->canWriteOff($sumToWriteOff)){
            $fromAccount->writeOff($sumToWriteOff, $fromAccount->getCurrency());
            $toAccount->topUp($sumToTopUp, $toAccount->getCurrency());

            return true;
        }

        return false;
    }

    public function writeOff($sum, $currency, $transactionType, $fromAccount, $toAccount){
        // writing off successfully done...
        $transaction = new Transaction($transactionType, $sum, $currency);
        $transaction->setTimestamp(Carbon::now());
        $transaction->setFromBankAccount($fromAccount);
        $transaction->setToBankAccount($toAccount);
        $this->transactionsHistory[] = $transaction;
    }

}
