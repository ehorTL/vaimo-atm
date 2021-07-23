<?php

namespace App\Models\Bank\Abstr;

use App\Models\Bank\BankAccountNumber;

/**
 * Bank store users bank accounts numbers (with money on them and other info),
 * users that ever had accounts there,
 * payment cards and transactions history.
 * Bank also has some exchange rates and can exchange money for customers.
 * Bank responsible for transfers and other operations with money on accounts.
 *
 *
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
    public abstract function writeOff($sum, $currency, $transactionType, $fromAccount, $toAccount);

    public function setBankAccounts($bankAccounts)
    {
        $this->bankAccounts = $bankAccounts;
    }

    public function setPaymentCards($paymentCards)
    {
        $this->paymentCards = $paymentCards;
    }

    public function setTransactionsHistory($transactionsHistory)
    {
        $this->transactionsHistory = $transactionsHistory;
    }

    public function getTransactionsHistory()
    {
        return $this->transactionsHistory;
    }
}
