<?php

namespace App\Models\Currency;

class ExchangeUnit{
    protected $currencyCode;
    protected $purchase;
    protected $sale;

    function __construct(int $currencyCode, float $purchase, float $sale){
        $this->currencyCode = $currencyCode;
        $this->purchase = $purchase;
        $this->sale = $sale;
    }

    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    public function getPurchase()
    {
        return $this->purchase;
    }

    public function getSale()
    {
        return $this->sale;
    }

    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
    }

    public function setSale($sale)
    {
        $this->sale = $sale;
    }
}
