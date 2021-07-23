<?php

namespace App\Models\Bank;

use App\Models\Bank\Abstr\BankAbstract;

/**
 * Bank branch is physical place where the bank department can be located.
 * It has address and bank info.
 */
class BankBranch {
    protected $address;
    protected $bank;

    function __construct(BankAbstract $bank, $address = "")
    {
        $this->bank = $bank;
        $this->address = $address;
    }

    public function setBank($bank){
        $this->bank = $bank;
    }

    public function setAddress($address){
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getBank()
    {
        return $this->bank;
    }
}
