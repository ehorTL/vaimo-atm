<?php

namespace App\Models\Bank\Abstr;

abstract class BankAbstract{
    protected $bankAccounts;
    protected $paymentCards;
    protected $transactionsHistory;
    protected $exchangeRates;

    /**
     * Simple bookkeeping in-place implementation.
     * The equity handling logic should be provided by other service and be injected
     * with using some interface so as to be replaceble in future.
     */
    protected $bankMainCurrency;
    protected $bankEquity;
}
