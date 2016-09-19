<?php

namespace Tests\Leos\Domain\Payment\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Payment\Model\Withdrawal;
use Leos\Domain\Payment\Model\RollbackWithdrawal;
use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Payment\ValueObject\WithdrawalDetails;

/**
 * Class RollbackWithdrawalTest
 *
 * @package Tests\Leos\Domain\Payment\Model
 */
class RollbackWithdrawalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $wallet = new Wallet();

        $wallet->addRealMoney(new Money(50 ,$currency = new Currency('EUR', 1)));

        $transaction = new RollbackWithdrawal(
            new Withdrawal($wallet, new Money(50, $currency), new WithdrawalDetails('paypal'))
        );

        self::assertInstanceOf(AbstractTransaction::class, $transaction);
        self::assertInstanceOf(WithdrawalDetails::class, $transaction->details());
        self::assertEquals(5000, $transaction->wallet()->real()->amount());
    }
}
