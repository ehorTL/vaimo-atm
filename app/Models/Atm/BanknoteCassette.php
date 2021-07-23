<?php

namespace App\Models\Atm;

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

    public function extract($sum){
        if ($this->hasSum($sum)){
            $sumInt = intval($sum);
            if ($sumInt % $this->nominalValue == 0){
                $this->quantity -= ($sumInt / $this->nominalValue);
                return $sumInt;
            }
        }

        return 0;
    }

    public function addBanknotes($quantity){
        if($quantity <=0 ){
            return $this->quantity;
        }
        $this->quantity += $quantity;

        return $this->quantity;
    }
}
