<?php

namespace App\Models\Bank\Transaction;

abstract class TransactionType{
    const WITHDRAWAL = 0;
    const TOP_UP = 1;
    const CUSTOMER_TRANSFER = 2;
//    const BANK_TRANSFER = 3;
//    const EXCHANGE = 4;
    public static function transactionToString($transaction){
        if ($transaction === self::WITHDRAWAL){
            return 'WITHDRAWAL';
        }
        if ($transaction === self::CUSTOMER_TRANSFER){
            return 'CUSTOMER_TRANSFER';
        }
        if ($transaction === self::CUSTOMER_TRANSFER){
            return 'TOP_UP';
        }
        else return 'NON_MENTIONED';
    }
}
