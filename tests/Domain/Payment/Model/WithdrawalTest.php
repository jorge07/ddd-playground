<?php

namespace Tests\Leos\Domain\Payment\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Payment\Model\RollbackWithdrawal;
use Leos\Domain\Payment\Model\Withdrawal;
use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Payment\ValueObject\WithdrawalDetails;
use Tests\Leos\Domain\Wallet\Model\WalletTest;

/**
 * Class WithdrawalTest
 *
 * @package Tests\Leos\Domain\Payment\Model
 */
class WithdrawalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $wallet = WalletTest::create();

        $wallet->addRealMoney(new Money(50 ,$currency = new Currency('EUR', 1)));

        $transaction = new Withdrawal($wallet, new Money(50, $currency), new WithdrawalDetails('paypal'));

        self::assertInstanceOf(AbstractTransaction::class, $transaction);
        self::assertInstanceOf(WithdrawalDetails::class, $transaction->details());
        self::assertEquals(0, $transaction->wallet()->real()->amount());
        self::assertInstanceOf(RollbackWithdrawal::class, $transaction->rollback());
    }
}
