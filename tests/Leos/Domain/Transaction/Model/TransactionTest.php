<?php

namespace Leos\Domain\Transaction\Model;

use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Transaction\ValueObject\TransactionType;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class TransactionTest
 *
 * @package Leos\Domain\Transaction\Model
 */
class TransactionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testGetters()
    {
        $wallet = new Wallet(new WalletId(), new Credit(0), new Credit(0));

        $currency = new Currency('EUR', 1);

        $transaction = Transaction::credit(
            $wallet,
            new Money(50.00, $currency),
            new Money(25.00, $currency)
        );

        $referral = Transaction::debit(
            $wallet,
            new Money(25.00, new Currency('EUR', 1)),
            new Money(0, new Currency('EUR', 1))
        );

        self::assertTrue(null !== $transaction->id());
        self::assertEquals($wallet, $transaction->wallet());
        self::assertEquals(TransactionType::CREDIT, $transaction->type());
        self::assertEquals(0, $transaction->prevReal()->amount());
        self::assertEquals(0, $transaction->prevBonus()->amount());
        self::assertEquals(5000, $transaction->operationReal());
        self::assertEquals(2500, $transaction->operationBonus());
        self::assertNull($transaction->referralTransaction());
        self::assertNotNull($transaction->createdAt());
        self::assertNull($transaction->updatedAt());
        self::assertNull($currency, $transaction->currency());

        $transaction->setReferralTransaction($referral);

        self::assertNotNull($transaction->referralTransaction());
    }
}
