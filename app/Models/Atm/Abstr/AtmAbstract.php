<?php

namespace App\Models\Atm\Abstr;

abstract class AtmAbstract{
    protected $bank;
    protected $banknoteCassettes;
    protected $address;

    public function getBank()
    {
        return $this->bank;
    }

    public function getBanknoteCassettes()
    {
        return $this->banknoteCassettes;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setBank($bank)
    {
        $this->bank = $bank;
    }

    public function setBanknoteCassettes($banknoteCassettes)
    {
        $this->banknoteCassettes = $banknoteCassettes;
    }
}
