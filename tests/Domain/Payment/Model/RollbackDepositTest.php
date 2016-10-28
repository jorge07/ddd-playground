<?php

namespace Tests\Leos\Domain\Payment\Model;

use Leos\Domain\Payment\Model\Deposit;
use Leos\Domain\Payment\Model\RollbackDeposit;
use Leos\Domain\Payment\ValueObject\DepositDetails;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Transaction\Model\AbstractTransaction;
use Tests\Leos\Domain\Wallet\Model\WalletTest;

/**
 * Class RollbackDepositTest
 * 
 * @package Leos\Domain\Payment\Model
 */
class RollbackDepositTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $transaction = new RollbackDeposit(
            new Deposit(
                WalletTest::create(),
                new Money(10, new Currency('EUR', 1)),
                new DepositDetails('paypal')
            )
        );

        self::assertInstanceOf(AbstractTransaction::class, $transaction);
        self::assertEquals(0, $transaction->wallet()->real()->amount());
    }
}
