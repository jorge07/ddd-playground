<?php

namespace Leos\Domain\Deposit\Model;


use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Transaction\Model\Transaction;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class DepositTest
 * @package Leos\Domain\Deposit\Model
 */
class DepositTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testDebit()
    {
        $transaction = Deposit::deposit(new Wallet(new WalletId()), new Money(0, new Currency('EUR', 1)));

        self::assertInstanceOf(Transaction::class, $transaction);
    }
}
