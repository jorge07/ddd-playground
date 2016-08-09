<?php

namespace Leos\Domain\Wallet\Model;

use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Money\ValueObject\Money;

/**
 * Class WalletTest
 *
 * @package Leos\Domain\Wallet\Model
 */
class WalletTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @group unit
     */
    public function testWalletGetters()
    {
        $wallet = new Wallet(new Credit(100), new Credit(100));

        self::assertEquals(100, $wallet->getReal()->getAmount());
        self::assertEquals(100, $wallet->getBonus()->getAmount());
        self::assertNotNull($wallet->getCreatedAt());
        self::assertNull($wallet->getUpdatedAt());
    }

    /**
     * @group unit
     */
    public function testWalletAdd()
    {
        $wallet = new Wallet($real = new Credit(100), $bonus = new Credit(100));


        $wallet->addRealMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->getReal());
        self::assertFalse($real->equals($wallet->getReal()));

        self::assertEquals(350, $wallet->getReal()->getAmount());

        $wallet->addBonusMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->getBonus());
        self::assertFalse($real->equals($wallet->getBonus()));

        self::assertEquals(350, $wallet->getBonus()->getAmount());
    }

    /**
     * @group unit
     */
    public function testWalletRemove()
    {
        $wallet = new Wallet($real = new Credit(350), $bonus = new Credit(350));


        $wallet->removeRealMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->getReal());
        self::assertFalse($real->equals($wallet->getReal()));

        self::assertEquals(100, $wallet->getReal()->getAmount());

        $wallet->removeBonusMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->getBonus());
        self::assertFalse($real->equals($wallet->getBonus()));

        self::assertEquals(100, $wallet->getBonus()->getAmount());
    }

    /**
     * @group unit
     * 
     * @expectedException Leos\Domain\Wallet\Exception\Credit\CreditNotEnoughException
     */
    public function testWalletRemoveNotEnoughCredit()
    {
        $wallet = new Wallet($real = new Credit(350), $bonus = new Credit(350));

        $wallet->removeRealMoney(new Money(8.50, $this->getTestCurrency()));
    }

    /**
     * @return Currency
     */
    private function getTestCurrency(): Currency
    {
        return new Currency('EUR', 1);
    }
}
