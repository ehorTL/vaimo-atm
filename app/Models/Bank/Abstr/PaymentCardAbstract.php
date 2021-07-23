<?php

namespace App\Models\Bank\Abstr;

use App\Models\Bank\BankAccountNumber;
use App\Models\Currency\CurrencyEnum;
use App\Models\User\User;

/**
 * Abstract class for payment bank card description.
 * It usually contains [16-digit] number, expiration date, card holder info.
 * Card is secured by PIN-code.
 * Card can be activate or not.
 * Card cannot be used without bank account number where the money actually lies.
 * Card holder and bank account number owner can differ.
 * Moreover one bank account can have multiple cards (~users).
 *
 * Pincode is stored as its hash.
 */
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
            'currencyCode' => CurrencyEnum::currencyToString($this->bankAccountNumber->getCurrency())];
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

    public abstract function setPinCode($pinCode);
}

