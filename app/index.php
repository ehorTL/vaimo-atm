<?php

/**
 Main script for application work demonstration.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\User\User;
use App\Models\User\Gender;

use App\Models\Bank\BankAccountNumber;
use App\Models\Bank\IbanGeneratorImpl;
use App\Models\Currency\CurrencyEnum;

use App\Models\Bank\Bank;
use App\Models\Currency\ExchangeUnit;

use App\Models\Atm\BanknoteCassette;
use App\Models\Atm\Atm;

$users = array();
$user1 = new User('Alice', 'Smith', Gender::MALE, [],[], null);
$user2 = new User('Bob', 'Brown', Gender::FEMALE, [], [], null);
$users[] = $user1;
$users[] = $user2;


$bn = new BankAccountNumber(new IbanGeneratorImpl(), "12/21", 100.0);
print $bn ->getBalance();
$bn->topUp(20, CurrencyEnum::USD);
print PHP_EOL . $bn->getBalance();
$bn->writeOff(90.0, CurrencyEnum::USD);
print PHP_EOL . $bn->getBalance();

$exchangeRates = [
    CurrencyEnum::UAH => [
        new ExchangeUnit(CurrencyEnum::USD, 27.1, 27.3),
        new ExchangeUnit(CurrencyEnum::EUR, 31.8, 32.4),
        new ExchangeUnit(CurrencyEnum::RUB, 0.35, 0.38),
        new ExchangeUnit(CurrencyEnum::UAH, 1.0, 1.0),
    ],
    CurrencyEnum::USD => [
        new ExchangeUnit(CurrencyEnum::EUR, 1.172, 1.19),
    ]
];

print_r($exchangeRates[CurrencyEnum::USD]);

$bank = new Bank($exchangeRates);
print $bank->calculateExchange(2730, CurrencyEnum::UAH, CurrencyEnum::USD);
print PHP_EOL . $bank->calculateExchange(100, CurrencyEnum::USD, CurrencyEnum::UAH);
print PHP_EOL . $bank->calculateExchange(10, CurrencyEnum::UAH, CurrencyEnum::RUB);


$banknoteCassettes = [
    new BanknoteCassette(CurrencyEnum::UAH, 100, 200),
    new BanknoteCassette(CurrencyEnum::UAH, 50, 500),
    new BanknoteCassette(CurrencyEnum::UAH, 200, 100),
    new BanknoteCassette(CurrencyEnum::UAH, 200, 150),
    new BanknoteCassette(CurrencyEnum::UAH, 500, 50),
    new BanknoteCassette(CurrencyEnum::USD, 10, 1000),
];

$atm = new Atm($bank, "", $banknoteCassettes);
print_r($atm->getAvailableBanknotesNominals());
print_r($atm->totalBanknotesSum());
print_r($atm->partition(74900, CurrencyEnum::UAH));
print_r($atm->canExtract(79910, CurrencyEnum::UAH));

//print_r($atm->getBanknoteCassettes());
print_r($atm->getAvailableBanknotesNominals());
//$atm->extract(CurrencyEnum::UAH, [ 500 => 50, 200 => 250, 100 => 49, 50 => 1]);
//print_r($atm->getBanknoteCassettes());
print_r($atm->getAvailableBanknotesNominals());

