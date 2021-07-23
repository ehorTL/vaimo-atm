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

use App\Models\Bank\PaymentCard;

$users = [
    new User('Alice', 'Smith', Gender::MALE, ['+1234567890'],['alice@gmail.com'], null),
    new User('Bob', 'Brown', Gender::FEMALE, ['+2345678901'], ['bob@gmail.com'], null),
    new User('Clara', 'Mae', Gender::FEMALE, ['+3456789012'], ['clara@gmail.com'], null)
];

$ban0 = new BankAccountNumber(new IbanGeneratorImpl(), "12/21", 1000.0, CurrencyEnum::UAH);
$ban0->setOwner($users[0]);

$ban1 = new BankAccountNumber(new IbanGeneratorImpl(), "12/21", 2000.0, CurrencyEnum::UAH);
$ban0->setOwner($users[1]);

$ban2 = new BankAccountNumber(new IbanGeneratorImpl(), "12/21", 30000.0, CurrencyEnum::UAH);
$ban0->setOwner($users[2]);

$bankAccounts = [$ban0, $ban1, $ban2];

$crd0 = new PaymentCard('0000567812345678', '0000', '07/25');
$crd0->setBankAccountNumber($ban0);
$crd0->setCardHolder($users[0]);
$crd1 = new PaymentCard('1111567812345678', '1111', '07/25');
$crd1->setBankAccountNumber($ban1);
$crd1->setCardHolder($users[1]);
$crd2 = new PaymentCard('2222567812345678', '2222', '07/25');
$crd2->setBankAccountNumber($ban2);
$crd2->setCardHolder($users[2]);

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

$bank = new Bank($exchangeRates);
$bank->setBankAccounts($bankAccounts);
$bank->setPaymentCards([$crd0, $crd1, $crd2]);

$banknoteCassettes = [
    new BanknoteCassette(CurrencyEnum::UAH, 100, 200),
    new BanknoteCassette(CurrencyEnum::UAH, 50, 500),
    new BanknoteCassette(CurrencyEnum::UAH, 200, 100),
    new BanknoteCassette(CurrencyEnum::UAH, 200, 150),
    new BanknoteCassette(CurrencyEnum::UAH, 500, 50),
    new BanknoteCassette(CurrencyEnum::USD, 10, 1000),
];

$atm = new Atm($bank, "ABC Street, 21", $banknoteCassettes);

print_r($atm->getBalance($crd0, '0000'));
print_r($atm->getBalance($crd1, '1111'));
print_r($atm->getBalance($crd2, '2222'));
print PHP_EOL;

$atm->changePinCode($crd0, '0000', '0011');
print ($crd0->pinCodeIsValid('0000') ? 'Pincode 0000 ok' : 'Pincode 0000 - error') . PHP_EOL;
print ($crd0->pinCodeIsValid('0011') ? 'Pincode 0011 ok' : 'Pincode 0011 - error') . PHP_EOL;
$atm->changePinCode($crd0, '0011', '0000');
print ($crd0->pinCodeIsValid('0000') ? 'Pincode 0000 ok' : 'Pincode 0000 - error') . PHP_EOL;

print_r($atm->withdraw($crd2, '2222', 26700, CurrencyEnum::UAH));
print_r($atm->getBalance($crd2, '2222'));

foreach ($atm->getTransactionsHistory($crd2, '2222') as $t){
    print $t;
}

