<?php

namespace App\Models\Bank\Transaction;

abstract class TransactionType{
    const WITHDRAWAL = 0;
    const TOP_UP = 1;
    const CUSTOMER_TRANSFER = 2;
//    const BANK_TRANSFER = 3;
//    const EXCHANGE = 4;
}
