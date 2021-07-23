<?php

namespace App\Models\Bank;

use App\Models\Bank\Contracts\PaymentCardInterface;
use App\Models\User\User;

class PaymentCard implements PaymentCardInterface {
    private $cardNumber;
    private $expirationDate;
    private $bankAccountNumber;
    private $activated;

    /**
     * @var User
     */
    private $cardHolder;
    private $pinCodeHash;

    public function pinCodeIsValid($pinCode){
        return $this->pinCodeHash === hash('md5', $pinCode);
    }

    function __construct(string $cardNumber, string $pincode){
        $this->cardNumber = $cardNumber;
        $this->pinCodeHash = hash('md5', $pincode);
    }
}
