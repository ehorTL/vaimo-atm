<?php

namespace App\Models\Bank;

use App\Models\Bank\Abstr\PaymentCardAbstract;
use App\Models\User\User;

class PaymentCard extends PaymentCardAbstract {
    public function pinCodeIsValid($pinCode){
        return $this->pinCodeHash === hash('md5', $pinCode);
    }

    function __construct(string $cardNumber, string $pincode, $expirationDate){
        $this->cardNumber = $cardNumber;
        $this->pinCodeHash = hash('md5', $pincode);
        $this->bankAccountNumber = null;
        $this->expirationDate = $expirationDate;
    }

    protected function userIsAuthorized($pincode){
        $this->pinCodeIsValid($pincode);
    }

    public function setBankAccountNumber(BankAccountNumber $bankAccountNumber){
        $this->bankAccountNumber = $bankAccountNumber;
    }

    /**
     * @return BankAccountNumber
     */
    public function getBankAccountNumber()
    {
        return $this->bankAccountNumber;
    }

    public function setCardStatus(bool $activated)
    {
        $this->activated = $this->activated;
    }

    public function getCardStatus(){
        return $this->activated;
    }

    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param User $cardHolder
     */
    public function setCardHolder($cardHolder)
    {
        $this->cardHolder = $cardHolder;
    }

    /**
     * @return User
     */
    public function getCardHolder()
    {
        return $this->cardHolder;
    }

    public function setPinCode($pinCode){
        $this->pinCodeHash = hash('md5', $pinCode);
    }
}
