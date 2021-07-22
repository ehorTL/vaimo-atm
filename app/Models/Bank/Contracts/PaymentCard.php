<?php

namespace App\Models\Bank\Contracts;

interface PaymentCard{
    public function pinCodeIsValid($pinCode);
}
