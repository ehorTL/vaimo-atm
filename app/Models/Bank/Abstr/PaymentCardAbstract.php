<?php

namespace App\Models\Bank\Abstr;

abstract class PaymentCardAbstract{
    protected $cardNumber;
    protected $expirationDate;
    protected $bankAccountNumber;
    protected $activated;

    /**
     * @var User
     */
    protected $cardHolder;
    protected $pinCodeHash;

    public function pinCodeIsValid(){

    }
}

