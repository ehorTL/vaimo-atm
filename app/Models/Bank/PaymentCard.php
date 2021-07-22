<?php

namespace App\Models\Bank;

class PaymentCard{
    private $cardNumber;
    private $expirationDate;
    private $bankAccountNumber;
    private $cardHolder;
    private $pinCodeHash;

    public function pinIsValid(string $pincode){
        return $this->pinCodeHash === hash('md5', $pincode);
    }

    function __construct(string $cardNumber, string $pincode){
        $this->cardNumber = $cardNumber;
        $this->pinCodeHash = hash('md5', $pincode);
    }
}
