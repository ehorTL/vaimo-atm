<?php

namespace App\Models\Bank;

use App\Models\Currency\CurrencyEnum;
use App\Models\User\User;
use App\Models\Bank\Contracts\IbanGenerator;

class BankAccountNumber{
    protected $iban;
    protected $ibanGenerator;
    protected $owner;
    protected $registrationDate;
    protected $balance;
    protected $currency;

    function __construct(IBANGenerator $ibanGenerator, $registrationDate,
                         $balance=0.0, $currency=CurrencyEnum::USD){
        $this->ibanGenerator = $ibanGenerator;
        $this->registrationDate = $registrationDate;
        $this->balance = $balance;
        $this->currency = $currency;
    }

    public function getIban(){
        return $this->iban;
    }

    public function setIban($iban){
        $this->iban = $iban;
    }

    public function generateIban(){
        $this->iban = $this->ibanGenerator->generate();
    }

    public function getOwner(){
        return $this->owner;
    }

    public function setOwner(User $owner){
        $this->owner = $owner;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;
    }

    public function topUp($sum, $currency){
        if ($currency !== $this->currency){
            throw new \Exception('Other currency. '
                . CurrencyEnum::currencyToString($this->currency) . ' expected but get '
                . CurrencyEnum::currencyToString($currency));
        }
        if ($sum < 0.0){
            throw \Exception('Negative sum provided');
        }
        $this->balance += $sum;

        return $this->balance;
    }

    public function writeOff($sum, $currency){
        if ($currency !== $this->currency){
            throw new \Exception('Other currency. '
                . CurrencyEnum::currencyToString($this->currency) . ' expected but get '
                . CurrencyEnum::currencyToString($currency));
        }
        if ($this->balance - $sum <= 0.0) {
            throw new \Exception('Sum is too large.');
        }
        if ($sum < 0.0){
            throw \Exception('Negative sum provided');
        }
        $this->balance -= $sum;

        return $this->balance;
    }
}