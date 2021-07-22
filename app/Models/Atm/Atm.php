<?php

namespace App\Models\Atm;

class Atm {
    private $balance;
    private $bank;
    private

    function __construct(Bank $bank, $balance = 0)
    {
        $this->balance = $balance;
        $this->bank = $bank;
//        parent::__construct();
    }

    private function bankTransaction(){}
    public function getBalance(){}
}
