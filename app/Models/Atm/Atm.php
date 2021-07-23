<?php

namespace App\Models\Atm;

use App\Models\Atm\Abstr\AtmAbstract;

class Atm extends AtmAbstract {
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
