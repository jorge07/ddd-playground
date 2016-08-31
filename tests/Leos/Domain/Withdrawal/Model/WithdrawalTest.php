<?php

namespace Tests\Leos\Domain\Withdrawal\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Withdrawal\Model\Withdrawal;
use Leos\Domain\Transaction\Model\AbstractTransaction;

/**
 * Class WithdrawalTest
 *
 * @package Tests\Leos\Domain\Withdrawal\Model
 */
class WithdrawalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $wallet = new Wallet();

        $wallet->addRealMoney(new Money(50 ,$currency = new Currency('EUR', 1)));

        $transaction = new Withdrawal($wallet, new Money(50, $currency));

        self::assertInstanceOf(AbstractTransaction::class, $transaction);
        self::assertEquals(0, $transaction->wallet()->real()->amount());
    }
}
