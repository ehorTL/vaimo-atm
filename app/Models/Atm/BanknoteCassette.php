<?php

namespace App\Models\Atm;

/**
 * Banknote cassette is a container to keep banknotes of the same nominal value.
 * Cassettes are used in ATMs, it is where the money are stored.
 * Cassettes are described by banknotes nominal, their quantity and currency (eg USD, EUR ets).
 *
 * Banknotes can be extracted from cassette or put into.
 * Container can be empty.
 * It is also describes by the sum it contains.
 */
class BanknoteCassette{
    protected $currency;
    protected $quantity;
    protected $nominalValue;
//    protected $volume;

    function __construct($currency, $nominalValue=0, $quantity=0) {
        $this->currency = $currency;
        $this->nominalValue = $nominalValue;
        $this->quantity= $quantity;
    }


    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setNominalValue($nominalValue)
    {
        $this->nominalValue = $nominalValue;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getNominalValue()
    {
        return $this->nominalValue;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getControlSum(){
        return $this->quantity * $this->nominalValue;
    }

    public function hasSum($sum){
        return $this->getControlSum() - $sum >= 0.0;
    }

    public function extractSum($sum){
        if ($this->hasSum($sum)){
            $sumInt = intval($sum);
            if ($sumInt % $this->nominalValue == 0){
                $this->quantity -= ($sumInt / $this->nominalValue);
                return $sumInt;
            }
        }

        return 0;
    }

    public function extractBanknotes($quantity){
        if ($this->quantity >= $quantity){
            $this->quantity -= $quantity;
            return true;
        }

        return false;
    }

    public function addBanknotes($quantity){
        if($quantity <=0 ){
            return $this->quantity;
        }
        $this->quantity += $quantity;

        return $this->quantity;
    }
}
