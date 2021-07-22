<?php

namespace App\Models\Bank;

class BankAccountNumber{
    private $iban;
    private $ibanGenerator;
    private $holder; // owner

    function __construct(IBANGenerator $ibanGenerator){
        $this->ibanGenerator = $ibanGenerator;
    }

    public function getIban(){
        return $this->iban;
    }
}