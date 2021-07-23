<?php

namespace App\Models\Bank\Abstr;

abstract class BankAbstract{
    protected $bankAccounts;
    protected $paymentCards;
    protected $transactionsHistory;
    protected $exchangeRates;
}
