<?php

namespace App\Models\Atm\Abstr;

use App\Models\Bank\Abstr\PaymentCardAbstract;

/**
 * Abstract class of ATM with basic methods declaration.
 * ATM have to be bounded to bank, contain banknote cassettes inside,
 * have address it is located at.
 *
 * The bank should be notified about all the operations the ATM performs
 * (bank is provided as a service). Most of the ATM's methods calls are delegated to bank,
 * where transactions are registered.
 *
 * Main function of the ATM is to give money out from its cassettes,
 * calculate what banknotes they should be withdrawn, give an opportunity users to check
 * balances on their cards, and make transfers from their accounts numbers to other
 */
abstract class AtmAbstract{
    protected $bank;
    protected $banknoteCassettes;
    protected $address;

    public function getBank()
    {
        return $this->bank;
    }

    public function getBanknoteCassettes()
    {
        return $this->banknoteCassettes;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setBank($bank)
    {
        $this->bank = $bank;
    }

    public function setBanknoteCassettes($banknoteCassettes)
    {
        $this->banknoteCassettes = $banknoteCassettes;
    }

    public abstract function execTransactionToCard(PaymentCardAbstract $card, $pincode, $sum,
                                                   $currency, PaymentCardAbstract $toCard);
    public abstract function execTransactionToAccount(PaymentCardAbstract $card, $pincode,
                                                      $sum, $currency, $toAccount);
    public abstract function getBalance(PaymentCardAbstract $card, $pincode);
    public abstract function withdraw(PaymentCardAbstract $card, $pincode, $sum, $currency);
    public abstract function changePinCode(PaymentCardAbstract $card, $oldPincode, $newPincode);
    public abstract function forgotPinCode($card);

    public abstract function getTransactionsHistory(PaymentCardAbstract $card, $pincode);
}
