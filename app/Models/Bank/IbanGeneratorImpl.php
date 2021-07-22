<?php

namespace App\Models\Bank;

use \App\Models\Bank\Contracts\IbanGenerator;

class IbanGeneratorImpl implements IbanGenerator {
    public function generate()
    {
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $aplhabet_size = strlen($alphabet);
        $iban = '';
        for ($i = 0; $i < 34; $i++){
            $iban .= $alphabet[random_int(1, $aplhabet_size)];
        }

        return $iban;
    }
}
