## Project for ATM use cases demonstration.

### Project requirements:
- PHP ^= 7.3
- Composer

### To run project:
- install dependencies with `composer install`
- generate autoload.php file with `composer dump-autoload`
- run index.php (can be started from terminal with `php app/index.php` from project directory)

### Logic
ATM is bounded to the bank (PrivatBank, Oschadbank etc).
Bank keeps its customers with their bank accounts.
Every customer can have multiple bank accounts.
So that customer can use ATM, he need to have any payment card.
Payment card is bounded to bank account.
Payment card keeps holder, pincode, its number and other properties like payment system, expiration date etc.
For one account there allowed to exist multiple cards.

Bank can have multiple branches (like different buildings).

ATM requirements:
- allow to:
    - make withdrawals
    - check card balance
    - transfer money to other card / account
    - check payments / withdrawals history
    - select the currency to put money out
- keeps the banknotes cassettes
- authorizes customers
- keeps all the actions performed by customers and collectors (like refill, withdrawals).

Bank processes e-transactions and ATM registers transactions with paper banknotes.
All the operations have to be traceble. 