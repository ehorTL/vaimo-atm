<?php

namespace App\Models\Bank\Contracts;

/**
 * Not used. Can be removed.
 */
interface Withdrawable{
    public function withdraw(float $sum, $currency);
}
