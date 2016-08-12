<?php

namespace Tests\Leos\Domain\Wallet\Model;

use Ramsey\Uuid\Uuid;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Exception\Credit\CreditNotEnoughException;

use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;

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
        $wallet = new Wallet(new WalletId($id = Uuid::uuid4()), new Credit(100), new Credit(100));

        self::assertEquals(100, $wallet->real()->amount());
        self::assertEquals(100, $wallet->bonus()->amount());
        self::assertNotNull($wallet->createdAt());
        self::assertNull($wallet->updatedAt());
        self::assertEquals($id, $wallet->id());
    }

    /**
     * @group unit
     */
    public function testWalletAdd()
    {
        $wallet = new Wallet(new WalletId(), $real = new Credit(100), $bonus = new Credit(100));

        $wallet->addRealMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->real());
        self::assertFalse($real->equals($wallet->real()));

        self::assertEquals(350, $wallet->real()->amount());

        $wallet->addBonusMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->bonus());
        self::assertFalse($real->equals($wallet->bonus()));

        self::assertEquals(350, $wallet->bonus()->amount());
    }

    /**
     * @group unit
     */
    public function testWalletRemove()
    {
        $wallet = new Wallet(new WalletId(), $real = new Credit(350), $bonus = new Credit(350));
        
        $wallet->removeRealMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->real());
        self::assertFalse($real->equals($wallet->real()));

        self::assertEquals(100, $wallet->real()->amount());

        $wallet->removeBonusMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->bonus());
        self::assertFalse($real->equals($wallet->bonus()));

        self::assertEquals(100, $wallet->bonus()->amount());
    }

    /**
     * @group unit
     */
    public function testWalletRemoveNotEnoughCredit()
    {
        try {

            $wallet = new Wallet(new WalletId(), $real = new Credit(350), $bonus = new Credit(350));

            $wallet->removeRealMoney(new Money(8.50, $this->getTestCurrency()));

            self::assertEquals(true, false);

        } catch (\Exception $e) {

            self::assertGreaterThan(4000, $e->getCode());
            self::assertInstanceOf(CreditNotEnoughException::class, $e);
        }
    }

    /**
     * @return Currency
     */
    private function getTestCurrency(): Currency
    {
        return new Currency('EUR', 1);
    }
}
