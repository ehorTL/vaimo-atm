<?php

namespace App\Models\Bank\Transaction;

use App\Models\Bank\Transaction\TransactionType;

class Transaction{
    protected $sum;
    protected $fromBankAccount;
    protected $toBankAccount;
    protected $currency;
    protected $transactionType;

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
}
