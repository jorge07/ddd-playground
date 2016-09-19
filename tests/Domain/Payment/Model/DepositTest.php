<?php

namespace Tests\Leos\Domain\Payment\Model;

use Leos\Domain\Payment\Model\Deposit;
use Leos\Domain\Payment\Model\RollbackDeposit;
use Leos\Domain\Payment\ValueObject\DepositDetails;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Transaction\Model\AbstractTransaction;

/**
 * Class DepositTest
 *
 * @package Leos\Domain\Payment\Model
 */
class DepositTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $transaction = new Deposit(
            new Wallet(),
            new Money(10, new Currency('EUR', 1)),
            new DepositDetails('paypal')
        );

        self::assertInstanceOf(AbstractTransaction::class, $transaction);
        self::assertEquals(1000, $transaction->wallet()->real()->amount());
        self::assertInstanceOf(RollbackDeposit::class, $transaction->rollback());
        self::assertInstanceOf(DepositDetails::class, $transaction->details());
    }
}
