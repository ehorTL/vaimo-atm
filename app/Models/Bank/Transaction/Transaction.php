<?php

namespace App\Models\Bank\Transaction;

use App\Models\Bank\Transaction\TransactionType;

/**
 * Transaction describes any action with money.
 * Transaction is described by its type (withdrawal, transfer etc),
 * time the action performed, information about where the money gone from and to.
 */
class Transaction{
    protected $sum;
    protected $fromBankAccount;
    protected $toBankAccount;
    protected $currency;
    protected $transactionType;
    protected $timestamp;

    function __construct(TransactionType $type, float $sum, $currency)
    {
        if ($sum < 0.0){
            throw new \Exception('Negative sum provided. Must be greater than 0.0');
        }

        $this->transactionType = $type;
        $this->sum = $sum;
        $this->currency = $currency;
    }

    public function setFromBankAccount($fromBankAccount)
    {
        $this->fromBankAccount = $fromBankAccount;
    }

    public function setToBankAccount($toBankAccount)
    {
        $this->toBankAccount = $toBankAccount;
    }

    public function getFromBankAccount()
    {
        return $this->fromBankAccount;
    }

    public function getToBankAccount()
    {
        return $this->toBankAccount;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getTransactionType()
    {
        return $this->transactionType;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
