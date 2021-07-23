<?php

namespace App\Models\Bank\Contracts;

/**
 * Interface for International Bank Account Number generation.
 * @see https://en.wikipedia.org/wiki/International_Bank_Account_Number
 */
interface IbanGenerator{
    public function generate();
}
