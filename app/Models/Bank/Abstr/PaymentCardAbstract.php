<?php

namespace App\Models\Bank\Abstr;

use App\Models\Bank\BankAccountNumber;
use App\Models\Currency\CurrencyEnum;
use App\Models\User\User;

abstract class PaymentCardAbstract{
    protected $cardNumber;
    protected $expirationDate;

    /**
     * @var BankAccountNumber
     */
    protected $bankAccountNumber;

    /**
     * @var bool
     */
    protected $activated;

    /**
     * @var User
     */
    protected $cardHolder;
    protected $pinCodeHash;

    abstract public function pinCodeIsValid($pincode);

    public function getCardBalance(){
        return [
            'balance' => $this->bankAccountNumber->getBalance(),
            'currencyInt' => $this->bankAccountNumber->getCurrency(),
            'currencyCode' => CurrencyEnum::currencyToString($this->bankAccountNumber->getCurrency());
    }

    /**
     * @return User
     */
    public function getCardHolder()
    {
        return $this->cardHolder;
    }

    /**
     * @return BankAccountNumber
     */
    public function getBankAccountNumber()
    {
        return $this->bankAccountNumber;
    }
}

