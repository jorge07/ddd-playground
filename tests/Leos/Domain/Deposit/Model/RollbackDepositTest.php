<?php

namespace Leos\Domain\Deposit\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Transaction\Model\AbstractTransaction;

/**
 * Class RollbackDepositTest
 * 
 * @package Leos\Domain\Deposit\Model
 */
class RollbackDepositTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $transaction = new RollbackDeposit(
            new Deposit(new Wallet(new WalletId()), new Money(10, new Currency('EUR', 1)))
        );

        self::assertInstanceOf(AbstractTransaction::class, $transaction);
        self::assertEquals(0, $transaction->wallet()->real()->amount());
    }
}
