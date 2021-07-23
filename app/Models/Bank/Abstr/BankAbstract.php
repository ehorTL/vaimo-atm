<?php

namespace App\Models\Bank\Abstr;

use App\Models\Bank\BankAccountNumber;

/**
 * Suppose bank has unlimited equity.
 * All the withdrawn money and other transactions are saved in transactions history.
 * Consider deposited and withdrawn money as some debentures to third party.
 * From this history bank can calculate (restore) its debt etc.
 */
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
//    protected $bankMainCurrency;
//    protected $bankEquity;

    public abstract function calculateExchange($sum, $currencyFrom, $currencyTo);
    public abstract function execTransaction($sum, $currency, BankAccountNumber $fromAccount, BankAccountNumber $toAccount);
    protected abstract function transfer($sum, $currency, BankAccountNumber $fromAccount, BankAccountNumber $toAccount);
    public abstract function writeOff($sum, $currency, $transactionType,
                            BankAccountNumber $fromAccount, BankAccountNumber $toAccount);
}
