<?php

namespace App\Models\Bank;

use App\Models\Bank\Abstr\BankAbstract;

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
