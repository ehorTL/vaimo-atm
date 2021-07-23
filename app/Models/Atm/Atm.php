<?php

namespace App\Models\Atm;

use App\Models\Atm\Abstr\AtmAbstract;

/**
 * Each action must be authorized, so each method gets card and pincode as arguments.
 * There can also be saved card and user authorization status,
 * but this is not the current implementation case.
 */
class Atm extends AtmAbstract {
    function __construct(Bank $bank, $banknoteCassettes = [])
    {
        $this->bank = $bank;
        $this->banknoteCassettes = $banknoteCassettes;
    }



    public function execTransactionToCard($card, $pincode, $sum, $toCard){

    }

    public function execTransactionToAccount($card, $pincode, $sum, $toAccount){

    }

    protected function bankTransaction($card, $pincode, $toAccount){

    }

    public function getBalance($card, $pincode, $sum){}

    public function withdraw($card, $pincode, $sum){}
}
