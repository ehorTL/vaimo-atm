<?php

namespace App\Models\Bank\Contracts;

interface Withdrawable{
    public function withdraw(float $sum, $currency);
}
