<?php

namespace App\Models\Bank;

class BankAccountNumber{
    private $iban;
    private $holder; // owner

    function __construct(IBANGenerator $ibanGenerator){
//        $this->iban = $ibanGenerator->generate();
    }

    public function getIban(){
        return $this->iban;
    }
}