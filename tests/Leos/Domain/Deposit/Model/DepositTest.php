<?php

namespace Leos\Domain\Deposit\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Transaction\Model\AbstractTransaction;

/**
 * Class DepositTest
 *
 * @package Leos\Domain\Deposit\Model
 */
class DepositTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $transaction = new Deposit(new Wallet(new WalletId()), new Money(10, new Currency('EUR', 1)));

        self::assertInstanceOf(AbstractTransaction::class, $transaction);
        self::assertEquals(1000, $transaction->wallet()->real()->amount());
        self::assertInstanceOf(RollbackDeposit::class, $transaction->rollback());
    }
}
