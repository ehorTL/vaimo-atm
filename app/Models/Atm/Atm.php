<?php

namespace App\Models\Atm;

class Atm {
    private $balance;
    private $bank;

    function __construct(Bank $bank, $balance = 0)
    {
        $this->bank = $bank;
    }

    private function bankTransaction(){}
    public function getBalance(){}
    public function withdraw(){}
}
